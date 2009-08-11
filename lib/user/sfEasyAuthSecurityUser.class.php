<?php
/**
 * An easy authenication class
 * 
 * @author al
 *
 */
class sfEasyAuthSecurityUser extends sfBasicSecurityUser
{
  /**
   * @var The sfEasyAuthUser
   */
  protected $user;
  
  /**
   * Returns the sfEasyAuthUser currently set in the class
   * 
   * @return sfEasyAuthUser
   */
  public function getAuthUser()
  {
    if (!$this->user && $id = $this->getAttribute('user_id', null, 'sfEasyAuthSecurityUser'))
    {
      $this->user = sfEasyAuthUserPeer::retrieveByPk($id);

      if (!$this->user)
      {
        // the user does not exist anymore in the database
        $this->logOut();

        throw new sfException('The user does not exist in the database.');
      }  
    }
    
    return $this->user;
  }
  
  /**
   * Returns the username of the current sfEasyAuthUser
   * 
   * @return mixed A string on success, null on failure
   */
  public function getUsername()
  {
    return (is_object($this->user)) ? $this->user->getUsername() : null;
  }
  
  /**
   * Attempt to authenticate a user with the supplied credentials
   * 
   * @param string $username
   * @param string $password
   * @param boolean $remember
   * @return boolean
   */
  public function authenticate($username, $password, $remember=0)
  {
    if ($user = sfEasyAuthUserPeer::retrieveByUsername($username))
    {
      if ($user->checkPassword($password))
      {
        if ($user->getEnabled() != 1)
        {
          $this->setFlash('message', 'Your account not active. Please contact us.');
          return false;
        }

        // make sure the threshold for login attempts hasn't been exceeded
        if (!$user->accountIsActive())
        {
          $this->setFlash('message', 'Your account has been locked due to too many incorrect log in attempts. Please try later.');
          return false;
        }

        $this->user = $user;
        return true;
      }
      else
      {
        // user name matched, but password failed. Record the attempt to prevent brute forcing

        // if the users last log in attempt is outside the lockout duration, reset their
        // failed login counter
        if (($user->getLastLoginAttempt('U') +
        sfConfig::get('app_sf_easy_auth_lockout_duration')) < time())
        {
          $user->setFailedLogins(0);
        }

        $user->setFailedLogins($user->getFailedLogins()+1);
        $user->setLastLoginAttempt(time());
        $user->save();

        if (!$user->accountIsActive())
        {
          $this->setFlash('message', 'Your account has been locked due to too many incorrect log in attempts. Please try later.');
        }
        return false;
      }
    }
    else
    {
      return false;
    }
    
    return true;
  }

  /**
   * Sets a cookie that can be used to automatically log a user in to the site
   */
  public function setRememberCookie()
  {
    if (!is_object($this->user))
    {
      throw new RuntimeException("Can't set a remember cookie for a non-existent user");
    }
    
    // get a unique key
    do
    {
      $rememberKey = $this->generateRememberKey($this->user);
    } while (sfEasyAuthUserPeer::retrieveByRememberKey($rememberKey));

    $duration = time()+sfConfig::get('app_sf_easy_auth_remember_me_duration', 30*24*60*60);
    
    $this->user->setRememberKey($rememberKey);
    $this->user->setRememberKeyLifetime($duration);
    $this->user->save();
    
    sfContext::getInstance()->getResponse()->setCookie(sfConfig::get('app_sf_easy_auth_remember_cookie_name'), $rememberKey, $duration);
  }
  
  /**
   * Actually logs the user in, giving them their credentials
   * 
   * @param sfEasyAuthUser $user The user to log in. If not set, 
   * the value of $this->user will be used if it is an object
   * @return boolean
   */
  public function logIn(sfEasyAuthUser $user=null)
  {
    $user = (is_object($user)) ? $user : $this->user;
     
    if (!$user instanceof sfEasyAuthUser)
    {
      throw new RuntimeException("Error, user is not an instanceof sfEasyAuthUser");
    }
    
    $user->unblockAccount();
    $user->setLastLogin(time());
    $user->save();
    $this->user = $user;
    
    $this->setAttribute('user_id', $user->getId(), 'sfEasyAuthSecurityUser');
    $this->setAuthenticated(true);
    $this->clearCredentials();
    
    foreach ($user->getCredentials() as $credential)
    {
      $this->addCredential($credential);
    }
    
    return true;
  }
  
  /**
   * Generates a key to be used for a remember me cookie value
   * 
   * @param sfUser $user The user to generate it for
   * @return string
   */
  protected function generateRememberKey(sfEasyAuthUser $user)
  {
    // the key is in two parts, first is a random string, the second is a string generated
    // from the user's id and a salt
    $userString = substr(md5(sfConfig::get('app_sf_easy_auth_remember_salt') . $user->getId()), 0, 9);
    return md5(sfEasyAuthUtils::randomString(20)) . '_' . $userString;
  }
  
  /**
   * Logs a user in via a 'remember me' cookie value
   * 
   * @param string $remember A hash stored in a table for a remember me cookie
   * @return mixed
   */
  public function validateRememberMe($remember)
  {
    // make sure the key contains the separator
    if (strpos($remember, '_') === false)
    {
      return false;
    }
    
    // try to retrieve the user
    if ($user = sfEasyAuthUserPeer::retrieveByRememberKey($remember))
    {
      // make sure it's in date
      if (time() > $user->getRememberKeyLifetime())
      {
        return false;
      }
      
      if ($user->accountIsActive())
      {
        $this->user = $user;
        return true;
      }
    }
    
    return false;
  }
  
  /**
   * Logs a user out of the site
   */
  public function logOut()
  {
    sfContext::getInstance()->getResponse()->setCookie('remember', '', -1);
    
    $this->setAuthenticated(false);
    $this->clearCredentials();
    $this->user = null;
  }
}