<?php

/*
 * Based on sfGuardRouting from sfGuardPlugin
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardRouting.class.php 13346 2008-11-25 19:10:17Z FabianLange $
 */
class sfEasyAuthRouting
{
  /**
   * Listens to the routing.load_configuration event.
   *
   * @param sfEvent An sfEvent instance
   */
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $r = $event->getSubject();

    // preprend our routes
    $r->prependRoute('sf_easy_auth_login', new sfRoute('/login', array('module' => 'sfEasyAuth', 'action' => 'login')));
    $r->prependRoute('sf_easy_auth_logout', new sfRoute('/logout', array('module' => 'sfEasyAuth', 'action' => 'logout')));
    $r->prependRoute('sf_easy_auth_secure', new sfRoute('/secure', array('module' => 'sfEasyAuth', 'action' => 'secure')));
    $r->prependRoute('sf_easy_auth_password_reset', new sfRoute('/pw_reset', array('module' => 'sfEasyAuth', 'action' => 'passwordReset')));
  }

  static public function addRouteForAdminUser(sfEvent $event)
  {
    $event->getSubject()->prependRoute('sf_easy_auth_user', new sfPropelRouteCollection(array(
      'name'                 => 'sf_easy_auth_user',
      'model'                => 'sfEasyAuthUser',
      'module'               => 'sfEasyAuthUser',
      'prefix_path'          => 'sf_easy_auth_user',
      'with_wildcard_routes' => true,
      'requirements'         => array(),
    )));
  }
}
