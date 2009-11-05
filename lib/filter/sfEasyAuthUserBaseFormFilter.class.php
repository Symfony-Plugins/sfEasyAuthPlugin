<?php

/**
 * sfEasyAuthUser filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class sfEasyAuthUserBaseFormFilter extends BasesfEasyAuthUserBaseFormFilter
{
  public function configure()
  {
    $this->widgetSchema['type'] = new sfWidgetFormChoice(array(
      'choices' => array_merge(array('' => 'Any'), sfEasyAuthUserPeer::getTypes()),
      'expanded' => false
    ));
  }
  
  /**
   * Trims whitespace from the email address
   */
  public function convertEmailValue($value)
  {
    foreach ($value as $k => $v)
    {
      $value[$k] = trim($v);
    }
    
    return $value;
  }
  
  /**
   * Trims whitespace from the user name
   */
  public function convertUsernameValue($value)
  {
    foreach ($value as $k => $v)
    {
      $value[$k] = trim($v);
    }
    
    return $value;
  }
}
