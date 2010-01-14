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
    $connection = Propel::getConnection();
    
    // we need to use a custom query to perform a UNION
    $query = $connection->query('SELECT `credential` FROM `' . sfEasyAuthUserCredentialPeer::TABLE_NAME . '` ' . 
      'UNION SELECT `type` FROM `sf_easy_auth_user`');

    $credentials = array();
    
    while ($credential = $query->fetch())
    {
      $credentials[$credential['credential']] = $credential['credential'];
    }
    
    return $credentials;    
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

    return self::doSelect($c);
  }
}
