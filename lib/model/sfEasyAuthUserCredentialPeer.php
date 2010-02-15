<?php

class sfEasyAuthUserCredentialPeer extends BasesfEasyAuthUserCredentialPeer
{
  /**
   * Queries the user_credentials and user table to find all types and credentials that 
   * have been set
   * 
   * @return array
   */
  public static function retrieveAllCredentials()
  {
    $c = new Criteria();
    $c->setDistinct();

    return self::doSelect($c);
  }

  /**
   * Retrieves an sfEasyAuthUserCredential object by user ID and credential name
   *
   * @param int $userId An easy auth user ID
   * @param string $credentialName The name of a credential, e.g. 'editor'
   * @return array|null
   */
  public static function retrieveByUserIdAndName($userId, $credentialName)
  {
    $c = new Criteria();
    $c->add(self::USER_ID, $userId);
    $c->add(self::CREDENTIAL, $credentialName);

    return self::doSelectOne($c);
  }

  /**
   * Retrieve all credentials for a user
   *
   * @param int $userId A user id to find credentials for
   * @return array
   */
  public static function retrieveByUserId($userId)
  {
    $c = new Criteria();
    $c->add(self::USER_ID, $userId);

    return self::doSelect($c);
  }
}
