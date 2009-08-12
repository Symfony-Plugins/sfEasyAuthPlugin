<?php

class sfEasyAuthUser extends BasesfEasyAuthUser
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
    return ($type) ? sfConfig::get('app_sf_easy_auth_profile_prefix') . ucfirst($type) : '';
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
  
  /**
   * Makes sure the user name isn't already taken
   * 
   * @param string $username
   * @throws RuntimeException if the user name is already taken
   */
  public function setUserName($username)
  {
    if ($user = sfEasyAuthUserPeer::retrieveByUsername($username))
    {
      if ($user->getId() !== $this->getId())
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
   * Returns a boolean for whether this account may be used. It makes sure it
   * is enabled (so hasn't been blocked by an admin), and that it hasn't been
   * locked as a result of too many incorrect log in attempts
   * 
   * @return boolean
   */
  public function accountIsActive()
  {
    if ($this->getEnabled() == 1)
    {
      return !$this->accountTemporarilyLocked();
    }
    
    return false;
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
}
