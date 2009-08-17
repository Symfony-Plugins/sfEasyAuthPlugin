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
  
  /**
   * Removes parameters from a query string
   * 
   * @param string $queryString
   * @param array $params An array of GET parameter keys to remove from the query string
   * @return string The url with the GET parameters removed
   */
  public static function removeGetParametersFromUrl($url, array $params)
  {
    $query = array();

    $queryString = parse_url($url, PHP_URL_QUERY);
    
    // parse the query string
    parse_str($queryString, $query);

    // remove the unneeded parameters
    foreach ($params as $param)
    {
      if (isset($query[$param]))
      {
        unset($query[$param]);
      }
    }

    $newQueryString = http_build_query($query);

    // rebuild the url
    $fullUrl = preg_replace("!\??{$queryString}!", '', $url);

    $fullUrl = ($newQueryString) ? $fullUrl . '?' . $newQueryString : $fullUrl;
    
    return $fullUrl;
  }
}