<?php

class sfEasyAuthUserBasePeer extends BasesfEasyAuthUserBasePeer
{
  /**
   * Retrieve a user by their remember me key
   * 
   * @param string $remember
   * @return mixed
   */
  public static function retrieveByRememberKey($remember)
  {
    $c = new Criteria();
    $c->add(self::REMEMBER_KEY, $remember);
    
    return self::doSelectOne($c);
  }
  
  /**
   * Retrieve a user by their user name
   * 
   * @param string $username
   * @return mixed
   */
  public static function retrieveByUsername($username)
  {
    $c = new Criteria();
    $c->add(self::USERNAME, $username);
    
    return self::doSelectOne($c);
  }

  /**
   * Retrieve all users of a given type
   *
   * @param string $type
   * @return mixed
   */
  public static function retrieveByType($type)
  {
    $c = new Criteria();
    $c->add(self::TYPE, $type);

    return self::doSelect($c);
  }

  /**
   * Retrieve a user by a profile id, or null if no user exists
   * with that profile id
   *
   * @param int $profileId
   * @return mixed
   */
  public static function retrieveByProfileId($profileId)
  {
    // first, try to retrieve a user whose default profile id is $profileId
    $c = new Criteria();
    $c->add(self::PROFILE_ID, $profileId);

    if ($user = self::doSelect($c))
    {
      return $user;
    }

    // if no user was returned, search the extra credentials table
    $c = new Criteria();
    $c->addJoin(self::PROFILE_ID, sfEasyAuthUserCredentialPeer::ID);
    $c->add(sfEasyAuthUserCredentialPeer::PROFILE_ID, $profileId);

    return self::doSelect($c);
  }

  /**
   * Retrieve a user by their email address
   * 
   * @param string $email
   * @return mixed
   */
  public static function retrieveByEmail($email)
  {
    $c = new Criteria();
    $c->add(self::EMAIL, $email);
    
    return self::doSelectOne($c);
  }
  
  /**
   * Returns an array of possible user types
   * 
   * @return array
   */
  public static function getTypes()
  {
    $types = array();
    $authReflector = new ReflectionClass('sfEasyAuthUser');
    
    foreach (scandir(dirname(__FILE__)) as $file)
    {
      $file = pathinfo($file, PATHINFO_FILENAME);
      
      if (strpos($file, 'sfEasyAuth') === 0 && strpos($file, 'Peer') === false)
      {
        // make sure the class inherits from sfEasyAuthUser
        $reflector = new ReflectionClass($file);
        if ($reflector->isSubClassOf($authReflector))
        {
          $type = str_replace('sfEasyAuth', '', $file);
          $typeName = preg_replace('/^(.)/e', 'strtolower("$1")', $type);
          $types[$typeName] = $type;
        }
      }
    }

    return $types;
  }
  
  /**
   * Retrieves a user by ID and auto-log-in hash
   * @param int $id
   * @param string $hash
   * @return mixed
   */
  public static function retrieveByIdAndAutoLoginHash($id, $hash)
  {
    $c = new Criteria();
    $c->add(self::ID, $id);
    $c->add(self::AUTO_LOGIN_HASH, $hash);
    
    return self::doSelectOne($c);
  }
}
