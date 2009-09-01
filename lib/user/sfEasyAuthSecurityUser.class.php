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
  protected $eaUser;
  
  /**
   * Returns the sfEasyAuthUser currently set in the class
   * 
   * @return sfEasyAuthUser
   */
  public function getAuthUser()
  {
    if (!$this->eaUser && $id = $this->getAttribute('security_user_id'))
    {
      $this->eaUser = sfEasyAuthUserPeer::retrieveByPk($id);

      if (!$this->eaUser)
      {
        // the user does not exist anymore in the database
        $this->logOut();

        throw new sfException('The user does not exist in the database.');
      }  
    }
    
    return $this->eaUser;
  }
  
  /**
   * Returns the username of the current sfEasyAuthUser
   * 
   * @return mixed A string on success, null on failure
   */
  public function getUsername()
  {
    return (is_object($this->eaUser)) ? $this->eaUser->getUsername() : null;
  }
  
  /**
   * Logs in a user whose ID and hash match a user in the database
   * 
   * @param int $id
   * @param string $hash The user's auto login hash
   * @return boolean
   */
  public function authenticateAutoLogin($id, $hash)
  {
    if ($eaUser = sfEasyAuthUserPeer::retrieveByIdAndAutoLoginHash($id, $hash))
    {
      // make sure their account is enabled. This allows them to log in via an
      // auto log-in link even if their account has been suspended due to too many
      // incorrect log-in attempts
      if (!$eaUser->accountLockedByAdmins())
      {
        $this->eaUser = $eaUser;
        
        if (!$this->eaUser->getEmailConfirmed())
        {
          // confirm the user's email address
          $this->eaUser->setEmailConfirmed(true);
          $this->eaUser->save();
          
          // call an event indicating that a user has confirmed their email address
          sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent(
            $this,
            'sf_easy_auth.email_confirmed',
            array(
              'eaUser' => $this->eaUser
            )
          ));
        }
        
        return $this->logIn();
      }
    }
    
    return false;
  }
  
  /**
   * Sets a flash called 'message' for a user depending on whether we should i18n strings
   * 
   * @param string $message The message to set as a flash
   */
  protected function setMessage($message)
  {
    if (!$this->hasFlash('message'))
    {
      if (sfConfig::get('app_sf_easy_auth_use_i18n'))
      {
        return $this->setFlash('message', sfContext::getInstance()->getI18n()->__($message));
      }
      else
      {
        return $this->setFlash('message', $message);
      }
    }
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
    sfEasyAuthUtils::logDebug("Authenticating... Username: $username, password: $password");
        
    if ($eaUser = sfEasyAuthUserPeer::retrieveByUsername($username))
    {
      sfEasyAuthUtils::logDebug('User retrieved. Checking password...');
      
      if ($eaUser->checkPassword($password))
      {
        sfEasyAuthUtils::logDebug('Password valid.');
        
        // check whether admins have locked the account
        if ($eaUser->accountLockedByAdmins() == 1)
        {
          sfEasyAuthUtils::logDebug("The account for user $username has been locked by admins.");
          
          $this->setMessage(sfConfig::get('app_sf_easy_auth_account_locked_by_admins'));
          return false;
        }

        // if email accounts need confirming, before users can log in, make sure the
        // user has confirmed their email address
        if (sfConfig::get('app_sf_easy_auth_require_email_confirmation'))
        {
          if (!$eaUser->getEmailConfirmed())
          {
            sfEasyAuthUtils::logDebug('User must confirm their email before being allowed to log in.');
            
            $this->setMessage(sfConfig::get('app_sf_easy_auth_must_confirm_email'));
            return false;
          }
        }

        // make sure the threshold for login attempts hasn't been exceeded
        if ($eaUser->accountTemporarilyLocked())
        {
          sfEasyAuthUtils::logDebug('User\'s account is temporarily disabled.');
          
          $this->setMessage(sfConfig::get('app_sf_easy_auth_account_temporarily_locked'));
          return false;
        }

        sfEasyAuthUtils::logDebug('User successfully authenticated.');
        
        $this->eaUser = $eaUser;
        return true;
      }
      else
      {
        sfEasyAuthUtils::logDebug('Invalid password supplied.');
        
        // user name matched, but password failed. Record the attempt to prevent 
        // brute forcing

        // if the users last log in attempt is outside the lockout duration, reset their
        // failed login counter
        if (($eaUser->getLastLoginAttempt('U') +
        sfConfig::get('app_sf_easy_auth_lockout_duration')) < time())
        {
          $eaUser->setFailedLogins(0);
        }

        $currentlyTemporarilyLocked = $eaUser->accountTemporarilyLocked();
        
        $eaUser->setFailedLogins($eaUser->getFailedLogins()+1);
        $eaUser->setLastLoginAttempt(time());
        $eaUser->save();

        if ($eaUser->accountTemporarilyLocked())
        {
          // if the user's account has just been locked, notify the system
          if (!$currentlyTemporarilyLocked)
          {
            // call an event to notify that a user's account will be temporarily locked
            sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent(
              $this,
              'sf_easy_auth.account_temporarily_locked',
              array(
                'eaUser' => $eaUser
              )
            ));
          }
          
          sfEasyAuthUtils::logDebug('User\'s account has been temporarily locked.');
          
          $this->setMessage(sfConfig::get('app_sf_easy_auth_account_temporarily_locked'));
        }
        return false;
      }
    }
    else
    {
      sfEasyAuthUtils::logDebug("Unable to locate user with username $username");
      
      return false;
    }
    
    // we should never reach here
    return false;
  }

  /**
   * Sets a cookie that can be used to automatically log a user in to the site
   */
  public function setRememberCookie()
  {
    if (!is_object($this->eaUser))
    {
      throw new RuntimeException("Can't set a remember cookie for a non-existent user");
    }
    
    // get a unique key
    do
    {
      $rememberKey = $this->generateRememberKey($this->eaUser);
    } while (sfEasyAuthUserPeer::retrieveByRememberKey($rememberKey));

    $duration = time()+sfConfig::get('app_sf_easy_auth_remember_me_duration', 30*24*60*60);
    
    $this->eaUser->setRememberKey($rememberKey);
    $this->eaUser->setRememberKeyLifetime($duration);
    $this->eaUser->save();
    
    sfContext::getInstance()->getResponse()->setCookie(sfConfig::get('app_sf_easy_auth_remember_cookie_name'), $rememberKey, $duration);
  }
  
  /**
   * Actually logs the user in, giving them their credentials
   * 
   * @param sfEasyAuthUser $eaUser The user to log in. If not set, 
   * the value of $this->eaUser will be used if it is an object
   * @return boolean
   */
  public function logIn(sfEasyAuthUser $eaUser=null)
  {
    $eaUser = (is_object($eaUser)) ? $eaUser : $this->eaUser;
     
    if (!$eaUser instanceof sfEasyAuthUser)
    {
      throw new RuntimeException("Error, user is not an instanceof sfEasyAuthUser");
    }
    
    sfEasyAuthUtils::logDebug('Logging user in and adding credentials.');
    
    $eaUser->unblockAccount();
    $eaUser->setLastLogin(time());
    $eaUser->save();
    $this->eaUser = $eaUser;
    
    $this->setAttribute('security_user_id', $eaUser->getId());
    $this->setAuthenticated(true);
    $this->clearCredentials();
    
    foreach ($eaUser->getCredentials() as $credential)
    {
      $this->addCredential($credential);
    }
    
    return true;
  }
  
  /**
   * Generates a key to be used for a remember me cookie value
   * 
   * @param sfUser $eaUser The user to generate it for
   * @return string
   */
  protected function generateRememberKey(sfEasyAuthUser $eaUser)
  {
    // the key is in two parts, first is a random string, the second is a string generated
    // from the user's id and a salt
    $userString = substr(md5(sfConfig::get('app_sf_easy_auth_remember_salt') . $eaUser->getId()), 0, 9);
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
    sfEasyAuthUtils::logDebug('Validating remember me hash...');
    
    // make sure the key contains the separator
    if (strpos($remember, '_') === false)
    {
      return false;
    }
    
    // try to retrieve the user
    if ($eaUser = sfEasyAuthUserPeer::retrieveByRememberKey($remember))
    {
      // make sure it's in date
      if (time() > $eaUser->getRememberKeyLifetime())
      {
        return false;
      }
      
      if (!$eaUser->accountTemporarilyLocked())
      {
        sfEasyAuthUtils::logDebug('Remember me hash successfully validated.');
        
        $this->eaUser = $eaUser;
        return true;
      }
    }
    
    return false;
  }
  
  /**
   * Validates that the given password reset token is set for the current user
   * 
   * @param string $token The password reset token
   * @return boolean
   */
  public function validatePasswordResetToken($token)
  {
    // make sure the token set for the user is still valid
    if ($this->getAuthUser()->getPasswordResetTokenCreatedAt('U') + sfConfig::get('app_sf_easy_auth_reset_token_lifetime') > time())
    {
      return (strcmp($this->getAuthUser()->getPasswordResetToken(), $token) === 0);
    }
    
    return false;
  }
  
  /**
   * Logs a user out of the site
   */
  public function logOut()
  {
    sfEasyAuthUtils::logDebug('Logging user out...');
    
    sfContext::getInstance()->getResponse()->setCookie('remember', '', -1);
    
    $this->getAttributeHolder()->remove('security_user_id');
    $this->getAttributeHolder()->remove('sf_easy_auth.restricted_url');
    $this->setAuthenticated(false);
    $this->clearCredentials();
    $this->eaUser = null;
  }
  
  /**
   * Returns the profile for the current user if it exists
   * 
   * @return mixed
   */
  public function getProfile()
  {
    return $this->getAuthUser()->getProfile();
  }
  
  /**
   * Returns whether the user has a profile
   * 
   * @return boolean
   */
  public function hasProfile()
  {
    return $this->getAuthUser()->hasProfile();
  }
  
  /**
   * Sets and saves a user's password
   * 
   * @param string $password
   */
  public function updatePassword($password)
  {
    $this->getAuthUser()->setPassword($password);
    
    return $this->getAuthUser()->save();
  }
  
  /**
   * Invalidates the password reset token to prevent replay attacks
   */
  public function invalidatePasswordResetToken()
  {
    $this->getAuthUser()->setPasswordResetToken('');
    
    return $this->getAuthUser()->save();
  }
}