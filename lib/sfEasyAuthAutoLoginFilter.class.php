<?php
/**
 * Auto-login filter for sfEasyAuth.
 * 
 * This filter examines all requested urls for GET parameters that indicate that we
 * should auto-log the user in. If these are present, it will attempt to 
 * authenticate a user and log them in without displaying a log in form. If successful,
 * users will be redirected to the page they were attempting to access.
 * 
 * @author al
 * @see sfEasyAuthAutoLoginFilter::execute
 *
 */
class sfEasyAuthAutoLoginFilter extends sfFilter
{
  /**
   * Automatically logs users in who have correctly set 'uid' and 'alh' parameters
   * in the url
   * 
   * @param $filterChain
   */
  public function execute($filterChain)
  {
    if ($this->isFirstCall())
    {
      // check whether the GET parameters 'uid' and 'alh' are present. 
      if (in_array('uid', array_keys($_GET)) && in_array('alh', array_keys($_GET)))
      {
        // continue down the filter chain if the user is already logged in
        if ($user = $this->getContext()->getUser())
        {
          if ($user->isAuthenticated())
          {
            return $filterChain->execute();
          }

          $request = $this->getContext()->getRequest();

          // if we're here, we've got an auto-login link, so try to log the user in.
          if ($user->authenticateAutoLogin($request->getGetParameter('uid'), $request->getGetParameter('alh')))
          {
            // if it worked, redirect the user to the current page so they are seemlessly 
            // logged in
            
            // strip out the id and hash, and redirect them to the same url - we need
            // to do this otherwise users won't end up where they wanted to go, and
            // browsers will be confused if a resource redirects to itself, GET params
            // and all
            $query = array();
            
            parse_str($_SERVER['QUERY_STRING'], $query);

            // remove the unneeded parameters
            unset($query['uid']);
            unset($query['alh']);
            
            $queryString = http_build_query($query);
            
            // rebuild the url
            $url = preg_replace("/\??{$_SERVER['QUERY_STRING']}/", '', $request->getUri());

            $url = ($queryString) ? $url . '?' . $queryString : $url;
            
            return $this->getContext()->getController()->redirect($url);
          }
        }
      }
    }
    
    $filterChain->execute();
  }
}