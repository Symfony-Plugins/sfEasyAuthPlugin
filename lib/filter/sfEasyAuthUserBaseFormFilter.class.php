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
}
