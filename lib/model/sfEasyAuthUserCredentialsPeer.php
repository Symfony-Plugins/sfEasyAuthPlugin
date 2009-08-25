<?php

class SfEasyAuthUserCredentialsPeer extends BaseSfEasyAuthUserCredentialsPeer
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

  }  
}
