<?php

class sfEasyAuthUser extends BasesfEasyAuthUser
{
  const PASSWORD_MASK = '**PASSWORD MASKED**';
  
  /**
   * @var array $profile An array of profiles associated with this user
   */
  protected $profile = array();

  /**
   * @var array $credentials An array of credentials so we only have to
   * compute them once
   */
  protected $credentials;
  
  /**
   * @var array $credentialRelationships An array of credential relationships
   * defining inheritances
   */
  protected $credentialRelationships;

  public function __toString()
  {
    return $this->getUsername();
  }

  /**
   * Returns whether the user has a given credential
   *
   * @param string $credential
   * @return boolean
   */
  public function hasCredential($credential)
  {
    return in_array($credential, $this->getCredentials());
  }

  /**
   * Returns all credentials for this user including inherited credentials
   *
   * @param bool $forceRefresh Whether to force refreshing current credentials for the user
   * @return array
   */
  public function getCredentials($forceRefresh=false)
  {
    if (!$forceRefresh && isset($this->credentials))
    {
      return $this->credentials;
    }

    $credentials = array();

    // get all credentials for the user
    foreach (sfEasyAuthUserCredentialPeer::retrieveByUserId($this->getId()) as $credential)
    {
      $credentials[] = $credential->getCredential();

      // add any inherited credentials
      $credentials = array_merge($credentials, $this->getInheritedCredentials($credential->getCredential()));
    }

    $credentials = array_unique($credentials);

    $this->credentials = $credentials;

    return $credentials;
  }

  /**
   * Parses configured credential relationships and returns an array
   *
   * @return array An array of credential relationships
   */
  protected function parseCredentialInheritanceDefinition()
  {
    if (!isset($this->credentialRelationships))
    {
      $this->credentialRelationships = array();

      $settingKey = 'app_sf_easy_auth_credential_inheritance_';

      // find settings that start with our config key and build an array of
      // inheritance relationships
      foreach (sfConfig::getAll() as $setting => $value)
      {
        if (strpos($setting, $settingKey) === 0 && $setting !== $settingKey)
        {
          $credential = substr($setting, strlen($settingKey));

          $this->credentialRelationships[$credential] = (is_array($value)) ? $value : array($value => null);
        }
      }
    }

    return $this->credentialRelationships;
  }

  /**
   * Recurses through the given array of relationships for the named credential
   * 
   * @param string $credential The name of a credential to find parents of
   * @param array $relationships A nested array of relationships
   * @return array An array of parent credentials
   */
  protected function searchCredentialInheritanceDefinition($credential, $relationships)
  {
    // if the relationship array is an array
    if (is_array($relationships))
    {
      // if the credential matches an array key, return true so we can return parent keys
      if (in_array($credential, array_keys($relationships)))
      {
        return true;
      }
      // if the credential matches a value in the array return the array key that matches
      else if (in_array($credential, $relationships))
      {
        return array_keys($relationships);
      }
      // if there is no match, recurse
      else
      {
        foreach (array_keys($relationships) as $key)
        {
          $value = $this->searchCredentialInheritanceDefinition($credential, $relationships[$key]);

          // if there was a match, merge it with the current key and return it.
          if ($value)
          {
            if (is_array($value))
            {
              return array_merge($value, array($key));
            }
            else
            {
              return array($key);
            }
          }
        }
      }
    }
    else
    {
      return false;
    }
  }

  /**
   * Adds inherited credentials by checking those defined in the app.yml file
   * 
   * @param string $credential The name of a credential to ascend the hierarchy from
   * @return array An array of inherited credentials
   */
  protected function getInheritedCredentials($credential)
  {
    $relationships = $this->parseCredentialInheritanceDefinition();

    // traverse the defined relationships searching for the given credential
    $parentCredentials = $this->searchCredentialInheritanceDefinition($credential, $relationships);

    return (is_array($parentCredentials)) ? $parentCredentials : array();
  }

  /**
   * Adds a credential for this user
   *
   * @param string $credential The name of a credential to add, e.g. 'superAdmin'
   * @param int $profileId An ID of a profile to associate with this credential (optional)
   */
  public function addCredential($credential, $profileId=null)
  {
    // if the user doesn't already have the credential, add a new one
    if (!in_array($credential, $this->getCredentials(true)))
    {
      $userCredential = new sfEasyAuthUserCredential();
      $userCredential->setCredential($credential);

      if ($profileId !== null)
      {
        if (!is_integer($profileId))
        {
          throw new sfException("Profile ID must be an integer");
        }

        $userCredential->setProfileId($profileId);
      }

      $userCredential->setUserId($this->getId());

      $userCredential->save();

      // reload the credentials
      $this->getCredentials(true);

      // reload the credentials on the sfUser object too if the current user
      // has had a new credential added
      if ($this->getId() === sfContext::getInstance()->getUser()->getAuthUser()->getId())
      {
        sfContext::getInstance()->getUser()->refreshCredentials();
      }
    }
  }

  /**
   * Removes a credential from a user account
   *
   * @param string $credential The name of a credential to remove
   */
  public function removeCredential($credential)
  {
    // note: related profiles aren't deleted, just orphaned
    if ($userCredential = sfEasyAuthUserCredentialPeer::retrieveByUserIdAndName($this->getId(), $credential))
    {
      $userCredential->delete();
    }
  }

  /**
   * Returns the name of the getter method for retrieving a profile
   * associated with the given credential
   * 
   * @param string $credential The credential to compute a getter for the profile of
   * @return string In the form getXXProfile
   */
  public static function getProfileGetter($credential)
  {
    return 'get' . ucfirst($credential) . 'Profile';
  }

  /**
   * Removes this object and related objects from datastore
   *
   * @param      PropelPDO $con
   * @return     void
   * @throws     PropelException
   * @see		 BasesfEasyAuthUser::delete()
   * @see        BaseObject::setDeleted()
   * @see        BaseObject::isDeleted()
   */
  public function delete(PropelPDO $con=null)
  {
    // call an event before deleting the user
    sfContext::getInstance()->getEventDispatcher()->notify(
      new sfEvent(
        $this,
        'sf_easy_auth.pre_delete'
      )
    );

    $profileArray = array();

    // get an array of profiles
    foreach (sfEasyAuthUserCredentialPeer::retrieveByUserId($this->getId()) as $credential)
    {
      $method = self::getProfileGetter($credential->getCredential());

      if ($profile = $this->$method())
      {
        $profileArray[] = $profile;
      }
    }

    // if we can delete this object, delete all profiles
    if ($return = parent::delete($con))
    {
      foreach ($profileArray as $profile)
      {
        $profile->delete();
      }
    }

    // call an event after deleting the user
    sfContext::getInstance()->getEventDispatcher()->notify(
      new sfEvent(
        $this,
        'sf_easy_auth.post_delete'
      )
    );

    return $return;
  }
  
  /**
   * Magic method that lets us retrieve different kinds of profiles depending on a user's
   * credentials.
   * 
   * @param <type> $name
   * @param array $arguments 
   */
  public function __call($name, $arguments)
  {
    // support a magic method for getXXProfile and hasXXProfile
    if (preg_match('!(get|has)(.+)Profile!', $name, $matches))
    {
      $method = $matches[1];
      $profileClass = $matches[2];

      return $this->{"{$method}Profile"}($profileClass);
    }
    else
    {
      // no match, so pass the call up the chain.
      return parent::__call($name, $arguments);
    }
  }

  /**
   * Returns the profile associated with the named class or false if the
   * user doesn't have the required credential or a profile for that class
   *
   * @param string $class The name of a class to retrieve a profile for
   * @return bool|object Returns the profile for the class if one exists
   */
  protected function getProfile($class)
  {
    // return false if the user doesn't have the required credential for the named class
    if (!$this->hasCredential(lcfirst($class)))
    {
      return false;
    }

    // if we haven't already retrieved the profile, retrieve it
    if (!isset($this->profile[$class]))
    {
      // get the ID of the profile for the named class
      $profileId = $this->getProfileIdByClass($class);

      if ($profileId > 0)
      {
        if ($profileClass = $this->computeProfileClassName($class))
        {
          $peerClass = $profileClass . 'Peer';

          // save the profile to the profiles array
          $this->profile[$class] = call_user_func(array($peerClass, 'retrieveByPk'), $profileId);
        }
      }
    }

    return (isset($this->profile[$class])) ? $this->profile[$class] : false;
  }

  /**
   * Retrieves a user's profile ID for a given class
   *
   * @param string $class The name of a class associated with a profile
   * @return bool|int|null If the user doesn't have a given credential, returns false.
   * If the user doesn't have a profile for the class, returns null, otherwise returns
   * the profile ID.
   */
  protected function getProfileIdByClass($class)
  {
    if (!$this->hasCredential(lcfirst($class)))
    {
      return false;
    }

    // if we need to retrieve the default profile, just do it
// @todo: delete this bit of code after migrating
    if (ucfirst($this->getType()) == $class)
    {
      return $this->getProfileId();
    }

    // we need to pull out the ID from the extra credentials table
    if ($credential = sfEasyAuthUserCredentialPeer::retrieveByUserIdAndName($this->getId(), lcfirst($class)))
    {
      return $credential->getProfileId();
    }

    return null;
  }

  /**
   * Returns whether this user has a profile of a specified class
   *
   * @param string $class The name of a class related to a profile
   * @return boolean
   */
  protected function hasProfile($class)
  {
    return (bool)$this->getProfile($class);
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
        throw new RuntimeException("Username $username already taken");
      }
    }
    
    return parent::setUsername($username);
  }
  
  /**
   * Sets the user's password, hashing it beforehand if it hasn't already been hashed.
   * 
   * @param string $password
   * @param bool $skipPasswordHash Whether to force not hashing the password
   */
  public function setPassword($password, $skipPasswordHash=false)
  {
    // don't set the password if we've got the default text from the admin editor
    if (strcmp(self::PASSWORD_MASK, $password) !== 0)
    {
      // only hash the password if it hasn't been hashed already
      $hashedPassword  = (!$skipPasswordHash && ($this->getPassword() != $password)) ? 
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
   * Sets the default profile related to this object
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
   * @param string $htmlMessage The HTML message to send to the user (optional)
   * @param string $subject A subject that will override the default one configured
   * in the app.yml file
   */
  public function sendPasswordResetMessage($message, $htmlMessage='', $subject='')
  {
    $callable = sfConfig::get('app_sf_easy_auth_password_reset_mailer_callable');
    
    if (strpos($callable, '::') !== false)
    {
      $subject = ($subject) ? $subject :  
        sfConfig::get('app_sf_easy_auth_reset_email_subject');
      
      return call_user_func($callable, $this, $subject, $message, $htmlMessage);
    }
  }  
  
  /**
   * Sends a user an email with a link to confirm their email address and activate
   * their account
   * 
   * @param string $message The message to send to this user
   * @param string $htmlMessage The HTML message to send to the user (optional)
   * @param string $subject A subject that will override the default one configured
   * in the app.yml file
   */
  public function sendEmailConfirmationMessage($message, $htmlMessage='', $subject='')
  {
    $callable = sfConfig::get('app_sf_easy_auth_email_confirmation_mailer_callable');

    if (strpos($callable, '::') !== false)
    {
      $subject = ($subject) ? $subject :  
        sfConfig::get('app_sf_easy_auth_email_confirmation_subject');
      
      return call_user_func($callable, $this, $subject, $message, $htmlMessage);
    }
  }
  
  /**
   * Returns all credentials belonging to this user as a string
   * 
   * @return string
   */
  public function getCredentialsAsString()
  {
    $credentials = $this->getCredentials();
    
    sort($credentials);

    return implode(', ', $credentials);
  }

  /**
   * Returns an array of all possible credential types (found by querying the database)
   * that this user could be associated with.
   * 
   * @return array An array of string values
   */
  public function getPossibleCredentials()
  {
    $credentials = sfEasyAuthUserPeer::getDistinctAssignedCredentialsAsArray();

    foreach (sfEasyAuthUtils::arrayFlatten($this->parseCredentialInheritanceDefinition()) as $credential)
    {
      $credentials[$credential] = $credential;
    }

    // sort the array
    asort($credentials);

    return $credentials;
  }
  
  /**
   * Sets credentials for a user. Any credentials associated with a user before calling
   * this method, but that don't appear in the $credentials array will be removed.
   * Associated profiles will be deleted.
   *
   * The format of the $credentials array is expected to be as follows:
   *   * If a value in the array is not an array, it will be treated as a credential name - in which
   *     case a new credential will be associated with the user (unless this credential is already set
   *     for the user). No profile will be associated with this credential
   *   * If an array value is a 2-element array, the first value will be treated as the credential name,
   *     the second as a profile ID to associate with the credential. An exception will be thrown if
   *     the second value is not an integer. No association will be created if one already exists 
   *     between this user and the given credential.
   *
   * @param array An array of credentials to set for this user. Credentials currently associated
   * with the user will be deleted if they don't also appear in this array.
   */
  public function setCredentials(array $credentials)
  {
    // retrieve currently set credentials
    $credentialsToDelete = sfEasyAuthUserCredentialPeer::retrieveByUserId($this->getId());
    
    // remove credentials in the $credentials array from the $credentialsToDelete array
    for ($i=0; $i<count($credentials); $i++)
    {
      if (is_array($credentials[$i]) && count($credentials[$i]) !== 2)
      {
        throw new sfException("Arrays contained in the parameter to setCredentials must have 2 elements - " .
          ' a credential name and an integer profile ID. If you don\'t want to associate a profile with a ' .
          ' credential, just pass a scalar value in the array'
        );
      }

      $credentialName = (is_array($credentials[$i])) ? $credentials[$i][0] : $credentials[$i];

      for ($j=0; $j<count($credentialsToDelete); $j++)
      {
        if ($credentialName == $credentialsToDelete[$j]->getCredential())
        {
          unset($credentialsToDelete[$j]);
          unset($credentials[$i]);
          break;
        }
      }
    }

    // now delete remaining credentials - note, related profiles WILL also be deleted,
    foreach ($credentialsToDelete as $credential)
    {
      $credential->delete();
    }

    // now, add any remaining credentials
    foreach ($credentials as $credential)
    {
      $credentialName = (is_array($credential)) ? $credential[0] : $credential;
      $profileId = (is_array($credential)) ? $credential[1] : null;

      $this->addCredential($credentialName, $profileId);
    }
  } 
}
