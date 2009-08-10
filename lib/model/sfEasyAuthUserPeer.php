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
}
