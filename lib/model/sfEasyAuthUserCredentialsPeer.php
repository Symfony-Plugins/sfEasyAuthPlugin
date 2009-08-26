<?php

class sfEasyAuthUserCredentialsPeer extends BasesfEasyAuthUserCredentialsPeer
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
    $query = $connection->query('SELECT `credential` FROM `sf_easy_auth_user_credentials` ' . 
      'UNION SELECT `type` FROM `sf_easy_auth_user`');

    $credentials = array();
    
    while ($credential = $query->fetch())
    {
      $credentials[] = $credential['credential'];
    }
    
    return $credentials;    
  }  
}
