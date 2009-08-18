<?php
/**
 * Redirection filter.
 * 
 * This filter examines all requested urls for GET parameters that indicate that we
 * should redirect the user, and will do so if they are present.
 * 
 * @author al
 *
 */
class sfEasyAuthRedirectFilter extends sfFilter
{
  /**
   * Redirects users to the specified local url
   * 
   * @param $filterChain
   */
  public function execute($filterChain)
  {
    if ($this->isFirstCall())
    {
      // check whether the GET parameters 'redir' is present. 
      if (in_array('redir', array_keys($_GET)))
      {
        $request = $this->getContext()->getRequest();
        
        // parse the url, stripping out the host name to make sure we'll only 
        // redirect users to local urls
        $redirUrl = urldecode($request->getGetParameter('redir'));
        
        // extract only the path part - but there shouldn't be anything else
        $redirUrl = parse_url($redirUrl, PHP_URL_PATH);

        // if we're in the dev env, prepend the name of the controller to the url
        if (sfConfig::get('sf_environment') != 'prod')
        {
          $redirUrl = sfConfig::get('app_controller') . '/' . ltrim($redirUrl, '/');
        }
        
        // get the original query string
        $queryString = parse_url($request->getUri(), PHP_URL_QUERY);
        
        // add it to the end of the redirection url
        $redirUrl = ($queryString) ? $redirUrl . '?' . $queryString : $redirUrl;
        
        // strip out the GET parameter, and redirect them
        $url = sfEasyAuthUtils::removeGetParametersFromUrl(
          $redirUrl, 
          array('redir')
        ); 

        return $this->getContext()->getController()->redirect($url);
      }
    }
    
    $filterChain->execute();
  }
}