<?php
/**
 * Utility methods for the plugin
 * 
 * @author al
 *
 */
class sfEasyAuthUtils
{
  /**
   * Creates a random string of the specified length
   * 
   * @param int $length The length of the string to generate
   * @return string
   */
  public static function randomString($length=10)
  {
    if ($length != intval($length) || $length < 0)
    {
      throw new InvalidParameterException("$length is not a valid number or parameter");
    }
    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';    

    for ($i=0; $i<$length; $i++) 
    {
      $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }

    return $string;
  }
}