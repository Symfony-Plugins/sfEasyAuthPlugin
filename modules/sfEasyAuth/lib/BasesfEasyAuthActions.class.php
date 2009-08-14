<?php

/**
 * sfEasyAuth actions.
 *
 * @package    .
 * @subpackage sfEasyAuth
 * @author     Ally
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class BasesfEasyAuthActions extends sfActions
{
 /**
  * Executes login action
  *
  * @param sfRequest $request A request object
  */
  public function executeLogin(sfWebRequest $request)
  {
    $user = $this->getUser();

    // user is already authenticated, so send them to the success url
    if ($user->isAuthenticated())
    {
      return $this->redirect(sfConfig::get('app_sf_easy_auth_login_success_url', '@homepage'));
    }
    
    if ($this->handleLogIn($request))
    {
      // log in successful, so redirect
      // to a URL set in app.yml
      // or to the homepage
      $url = sfConfig::get('app_sf_easy_auth_login_success_url', '@homepage');

      return $this->redirect($url);
    }
  }
  
  /**
   * Handles both ordinary log-ins and when a user requires more credentials
   *  
   * @param sfWebRequest $request
   * @return boolean True if the a user's details matched details in the database
   */
  protected function handleLogIn(sfWebRequest $request)
  {
    $user = $this->getUser();

    $this->loginForm = new sfEasyAuthLoginForm();
    $this->resetForm = new sfEasyAuthPasswordResetForm();

    // see if the user has a 'remember me' cookie set
    if ($request->getCookie(sfConfig::get('app_sf_easy_auth_remember_cookie_name')))
    {
      // try to retrieve the user
      if ($user->validateRememberMe($request->getCookie(sfConfig::get('app_sf_easy_auth_remember_cookie_name'))))
      {
        return $user->logIn();
      }
    }
    
    if ($request->isMethod('post'))
    {
      $this->loginForm->bind($request->getParameter($this->loginForm->getName()));
      
      if ($this->loginForm->isValid())
      {
        $authenticateMethod = sfConfig::get('app_sf_easy_auth_authenticate_callable', '');
        
        $username = $this->loginForm->getValue('username');
        $password = $this->loginForm->getValue('password');

        if (is_array($authenticateMethod) && count($authenticateMethod) == 2)
        {
          $result = call_user_func($authenticateMethod, $username, $password);
        }
        else
        {
          $result = $user->authenticate($username, $password);
        }
        
        if ($result === true)
        {
          // set the remember me cookie if they want it
          if ($this->loginForm->getValue('remember'))
          {
            $user->setRememberCookie();
          }
          
          return $user->logIn();
        }
        else
        {
          // log in failed.
          $this->setFlash(sfConfig::get('app_sf_easy_auth_invalid_credentials'));
        }
      }
      else
      {
        return false;
      }
    }
  }
  
  /**
   * Executes the action called when users need additional privileges
   * 
   * @param sfWebRequest $request
   */
  public function executeSecure(sfWebRequest $request)
  {
    $user = $this->getUser();
    
    $loginResult = $this->handleLogIn($request);
    
    if ($loginResult)
    {
      // log in successful, so redirect
      // to a URL set in app.yml
      // or to the homepage
      $url = sfConfig::get('app_sf_easy_auth_login_success_url', '@homepage');

      return $this->redirect($url);
    }
    else if ($loginResult !== false && $user->hasAttribute('sf.easy.auth.not.first.secure.attempt'))
    {
      $this->setFlash(sfConfig::get('app_sf_easy_auth_insufficient_privileges'));
    }
    else
    {
      $user->setAttribute('sf.easy.auth.not.first.secure.attempt', 1);
    }
  }
  
 /**
  * Executes logout action
  *
  * @param sfRequest $request A request object
  */
  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->logOut();

    $url = sfConfig::get('app_sf_easy_auth_logout_success_url', $request->getReferer());
    
    $url = ($url) ? $url : '@homepage';
    
    $this->redirect($url);
  }
  
  /**
   * Action that sends users an email to let them reset their password
   * 
   * @param sfRequest $request A request object
   */
  public function executePasswordResetSendEmail(sfWebRequest $request)
  {
    if ($request->isMethod('post'))
    {
      $this->form = new sfEasyAuthPasswordResetForm();
      
      $this->form->bind($request->getParameter($this->form->getName()));
      
      if ($this->form->isValid())
      {
        $email = $this->form->getValue('email');

        // try to retrieve the user with this email address
        if ($user = sfEasyAuthUserPeer::retrieveByEmail($email))
        {
          // send the user an email with an auto log in link with a parameter directing
          // them to a page to pick a new password
          $this->sendPasswordResetMessage($user);
        }
      }
      else
      {
        $this->setFlash(sfConfig::get('app_sf_easy_auth_reset_user_not_found'));
        $this->redirect(sprintf('%s?%s=true', $this->generateUrl('sf_easy_auth_login'), 
          sfConfig::get('app_sf_easy_auth_reset_user_not_found_url_token')));
      }
    }
  }
  
  /**
   * Action that lets users set a new password
   * 
   * @param sfRequest $request A request object
   */
  public function executePasswordResetSetPassword(sfWebRequest $request)
  {
    $user = $this->getUser();
    
    // if the user clicked on an auto-log-in link for example, and the link
    // failed to log them in, get them to log in.
    if (!$user->isAuthenticated() || !$user->getAuthUser())
    {
      // redirect them if they aren't already authenticated
      $this->redirect('@sf_easy_auth_login');
    }

    $this->form = new sfEasyAuthPasswordResetSetPasswordForm(
      array(), 
      array('token' => $request->getParameter('pw_reset[token]'))
    );
    
    if ($request->isMethod('post') && $user->validatePasswordResetToken($request->getParameter('pw_reset[token]')))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      
      if ($this->form->isValid())
      {
        // make sure the url 'token' parameter matches the one stored in the 
        // user table and is valid
        if ($user->validatePasswordResetToken($this->form->getValue('token')))
        {
          // set and save the new password
          $user->updatePassword($this->form->getValue('password'));
          
          // clear the password reset token so the link can't be used again
          $user->invalidatePasswordResetToken();
          
          // send them a success message
          $this->setTemplate('passwordResetPasswordUpdated');
        }
      }
    }
    else if (!$user->validatePasswordResetToken($request->getParameter('pw_reset[token]')))
    {
      // send them a new link
      $this->sendPasswordResetMessage($user->getAuthUser());
      
      // tell them that link has expired, but to check their email because we've sent
      // them a new link.
      $this->setTemplate('passwordResetExpiredToken');
    }
  }
  
  /**
   * Sets a flash for a user depending on whether we should i18n strings
   * 
   * @param string $message The message to set as a flash
   */
  private function setFlash($message)
  {
    if (!$user = $this->getUser())
    {
      return false;
    }
    
    if (!$user->hasFlash('message'))
    {
      if (sfConfig::get('app_sf_easy_auth_use_i18n'))
      {
        $user->setFlash('message', $this->getContext()->getI18n()->__($message));
      }
      else
      {
        $user->setFlash('message', $message);
      }
    }
  }
  
  /**
   * Sends a password reset message
   * 
   * @param sfEasyAuthUser $user The user to send a message to
   */
  protected function sendPasswordResetMessage(sfEasyAuthUser $user)
  {
    $message = $this->getPartial('sfEasyAuth/passwordResetEmail', array('user' => $user));
    return $user->sendPasswordResetMessage($message);
  }
}
