<?php

class sfEasyAuthUserPeer extends BasesfEasyAuthUserPeer
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
   * Retrieves a user by a credential and profile id
   *
   * @param string $credential The name of a credential
   * @param int $profileId A profile ID
   * @return object|null
   */
  public static function retrieveByCredentialAndProfileId($credential, $profileId)
  {
    $c = new Criteria();
    $c->addJoin(self::ID, sfEasyAuthUserCredentialPeer::USER_ID);
    $c->add(sfEasyAuthUserCredentialPeer::CREDENTIAL, $credential);
    $c->add(sfEasyAuthUserCredentialPeer::PROFILE_ID, $profileId);

    return self::doSelectOne($c);
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
