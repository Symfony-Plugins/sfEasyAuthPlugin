<?php

class sfEasyAuthUserBase extends BasesfEasyAuthUserBase
{
  const PASSWORD_MASK = '**PASSWORD MASKED**';
  
  /**
   * @var object $profile The profile associated with this user
   */
  protected $profile;
  
  /**
   * Returns default credentials for this user by examining the inheritance
   * hierarchy
   * 
   * @return array
   */
  public function getCredentials()
  {
    $credentials = array();
    
    $superClass = 'sfEasyAuthUser';
    $className = get_class($this);

    // get default credentials for each parent class
    do
    {
      $credentials[] = preg_replace('/^(.)/e', 'strtolower("$1")', str_replace('sfEasyAuth', '', $className));
      $userReflection = new ReflectionClass($className);
      $className = $userReflection->getParentClass()->getName(); 
    } while ($className !== $superClass);
    
    // add extra credentials if they have them
    if ($this->getHasExtraCredentials())
    {
      $credentials = array_merge($credentials, $this->getExtraCredentials());
    }

    return $credentials;
  }

  /**
   * Gets extra credentials for a user
   * 
   * @return array
   */
  protected function getExtraCredentials()
  {
    $c = new Criteria();
    $c->add(SfEasyAuthUserCredentialsPeer::USER_ID, $this->getId());
    
    $credentials = SfEasyAuthUserCredentialsPeer::doSelect($c);
    
    $extraCredentials = array();
    
    foreach ($credentials as $credential)
    {
      $extraCredentials[] = $credential->getCredential();
    }
    
    return $extraCredentials;
  }

  /**
   * Removes this object and related objects from datastore
   *
   * @param      PropelPDO $con
   * @return     void
   * @throws     PropelException
   * @see		 BasesfEasyAuthUserBase::delete()
   * @see        BaseObject::setDeleted()
   * @see        BaseObject::isDeleted()
   */
  public function delete(PropelPDO $con=null)
  {
    $id = $this->getId();
    $profile = $this->getProfile();
    
    if ($return = parent::delete($con))
    {
      if (is_object($profile))
      {
        $profile->delete();
      }
    }
    
    return $return;
  }
  
  /**
   * Returns the default profile associated with the current class
   * 
   * @return mixed Returns the current class' default profile if one exists
   */
  public function getProfile()
  {
    if ($this->getProfileId())
    {
      if ($profileClass = $this->computeProfileClassName($this->getType()))
      {
        $peerClass = $profileClass . 'Peer';
        $this->profile = call_user_func(array($peerClass, 'retrieveByPk'), $this->getProfileId()); 
      }      
    }
    
    return $this->profile;
  }
  
  /**
   * Returns whether this user has a profile
   * 
   * @return boolean
   */
  public function hasProfile()
  {
    return (bool)$this->getProfile();
  }
  
  /**
   * Returns the name of the profile class associated with a user class 
   * 
   * @param string $type The name of a user type to compute a profile class name for
   * @return string
   */
  protected function computeProfileClassName($type)
  {
    return ($type) ? sfConfig::get('app_sf_easy_auth_profile_prefix') . ucfirst($type) . 'Profile' : '';
  }
  
  /**
   * Takes in a clear text password and returns it after hashing it with a
   * salt
   * 
   * @param string $password The plaintext password
   * @param bool $newSalt If true, a new salt will be generated first
   * @return string The hashed password
   */
  protected function hashPassword($password, $newSalt=false)
  {
    $salt = ($newSalt) ? $this->generateSalt() : $this->getSalt();
    
    return md5($salt . $password);
  }
  
  /**
   * Checks a supplied clear text password against a user's hashed password
   * 
   * @param string $password Clear text password
   * @return boolean
   */
  public function checkPassword($password)
  {
    return ($this->getPassword() === $this->hashPassword($password));
  }
  
  /**
   * Saves the ID of this user object into the profile's user_id field if a profile
   * exists
   * 
   * @param PropelPDO $con
   */
  /*
  public function save(PropelPDO $con = null)
  {
    $return = parent::save();
    
    if (is_object($this->profile) && $this->profile->getUserId() !== $this->getId())
    {
      $this->profile->setUserId($this->getId());
      $this->profile->save();
    } 
    
    return $return;
  }
  */
  
  /**
   * Makes sure the user name isn't already taken
   * 
   * @param string $username
   * @throws RuntimeException if the user name is already taken
   */
  public function setUserName($username)
  {
    if ($eaUser = sfEasyAuthUserPeer::retrieveByUsername($username))
    {
      if ($eaUser->getId() !== $this->getId())
      {
        throw new RuntimeException("Username already taken");
      }
    }
    
    return parent::setUsername($username);
  }
  
  /**
   * Sets the user's password, hashing it beforehand if it hasn't already been hashed.
   * 
   * @param string $password
   */
  public function setPassword($password)
  {
    // don't set the password if we've got the default text from the admin editor
    if (strcmp(self::PASSWORD_MASK, $password) !== 0)
    {
      // only hash the password if it hasn't been hashed already
      $hashedPassword  = ($this->getPassword() != $password) ? 
        $this->hashPassword($password, true) : $password; 
    
      // set the password
      return parent::setPassword($hashedPassword);
    }
  }
  
  /**
   * Generates a new salt for the user
   * 
   * @return string The new salt
   */
  protected function generateSalt()
  {
    $salt = md5(sfEasyAuthUtils::randomString(20));
    $this->setSalt($salt);
    
    return $salt;
  }
  
  /**
   * Sets the profile related to this object
   * 
   * @param Persistent $profile The Persistent profile object to associate with this record
   */
  public function setProfile(Persistent $profile)
  {
    // save the profile if it hasn't been saved already
    if (!$profile->getId())
    {
      $profile->save();
    }
    
    $this->setProfileId($profile->getId());
    $this->profile = $profile;
  }

  /**
   * Accessor for the locked_by_admins field. This reflects whether admins have locked
   * an account, in which case the user will not be able to log in at all.
   * 
   * @return int
   */
  public function accountLockedByAdmins()
  {
    return $this->getLockedByAdmins();
  }
  
  /**
   * Accessor for the admin generator
   * 
   * @return boolean
   */
  public function getAccountTemporarilyLocked()
  {
    return ($this->accountTemporarilyLocked()) ? 'yes' : '';
  }
  
  /**
   * Returns whether this account has been temporarily locked due to too many
   * unsuccessful log in attempts
   * 
   * @return boolean
   */
  public function accountTemporarilyLocked()
  {
    if (($this->getLastLoginAttempt('U') +
      sfConfig::get('app_sf_easy_auth_lockout_duration')) > time())
    {
      if ($this->getFailedLogins() >= sfConfig::get('app_sf_easy_auth_login_attempt_threshold'))
      {
        return true;
      }
    }

    return false;
  }
  
  /**
   * Unblocks an account that has been locked due to too many incorrect log in attempts
   */
  public function unblockAccount()
  {
    $this->setFailedLogins(0);
    $this->save();
  }
  
  /**
   * Overrides the parent method to generate a hash if this is a new object 
   * 
   * @param PropelPDO $con
   */
  public function save(PropelPDO $con = null)
  {
    if ($this->isNew())
    {
      $this->setAutoLoginHash($this->generateAutoLoginHash());
    }
    
    return parent::save($con);
  }
  
  /**
   * Generates a hash
   * 
   * @return string A hash
   */
  protected function generateAutoLoginHash()
  {
    return md5(sfEasyAuthUtils::randomString(20));
  }
  
  /**
   * Generates and saves a token that can be checked to make sure password reset 
   * urls aren't being replayed. A timestamp is also saved to the database for this
   * purpose
   */
  protected function generatePasswordResetToken()
  {
    $this->setPasswordResetToken(sfEasyAuthUtils::randomString(12));
    $this->setPasswordResetTokenCreatedAt(time());
    
    $this->save();
  }
  
  /**
   * Generates a new reset token, saves it to the user record, and returns it ready
   * for use
   * 
   * @return string
   */
  public function getNewPasswordResetToken()
  {
    $this->generatePasswordResetToken();
    return $this->getPasswordResetToken();
  }
  
  /**
   * Sends a user an email with a link to reset their password
   * 
   * @param string $message The message to send to this user
   * @param string $subject A subject that will override the default one configured
   * in the app.yml file
   */
  public function sendPasswordResetMessage($message, $subject='')
  {
    $callable = sfConfig::get('app_sf_easy_auth_password_reset_mailer_callable');
    
    if (is_array($callable) && count($callable) == 2)
    {
      $subject = ($subject) ? $subject :  
        sfConfig::get('app_sf_easy_auth_reset_email_subject');
      
      return call_user_func($callable, $this, $subject, $message);
    }
  }  
  
  /**
   * Sends a user an email with a link to confirm their email address and activate
   * their account
   * 
   * @param string $message The message to send to this user
   * @param string $subject A subject that will override the default one configured
   * in the app.yml file
   */
  public function sendEmailConfirmationMessage($message, $subject='')
  {
    $callable = sfConfig::get('app_sf_easy_auth_email_confirmation_mailer_callable');
    
    if (is_array($callable) && count($callable) == 2)
    {
      $subject = ($subject) ? $subject :  
        sfConfig::get('app_sf_easy_auth_email_confirmation_subject');
      
      return call_user_func($callable, $this, $subject, $message);
    }
  }
}
