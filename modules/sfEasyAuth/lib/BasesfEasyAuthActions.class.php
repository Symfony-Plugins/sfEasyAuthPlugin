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
   * Executes the passwordReset action
   * 
   * @param sfRequest $request A request object
   */
  public function executePasswordReset(sfWebRequest $request)
  {
    if ($request->isMethod('post'))
    {
      $this->form = new sfEasyAuthPasswordResetForm();
      
      $this->form->bind($request->getParameter($this->form->getName()));
      
      if ($this->form->isValid())
      {
        $email = $this->form->getValue('email');

        // try to retrieve the user with this email address
        if (sfEasyAuthUserPeer::retrieveByEmail($email))
        {
          // send the user an email with an auto log in link with a parameter directing
          // them to a page to pick a new password

          // create a filter to process this too.
        }
      }
      else
      {
        $this->setFlash("We couldn't find a user with that email address");
        $this->redirect($this->generateUrl('sf_easy_auth_login') . '?invalidEmail=true');
      }
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
}
