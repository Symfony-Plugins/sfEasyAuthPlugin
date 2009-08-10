<?php

/**
 * sfEasyAuthUser form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfEasyAuthUserForm extends BasesfEasyAuthUserForm
{
  public function configure()
  {
    unset($this['salt'],
          $this['remember_key']);
          
    $this->widgetSchema->setHelps(array(
      'password' => 'Use this box to set a new password for the user.'
    ));
          
    $this->widgetSchema['password'] = new sfWidgetFormInputConfigurable(array(
      'value' => ($this->isNew()) ? '' : sfEasyAuthUser::PASSWORD_MASK
    ));
    
    $this->widgetSchema['type'] = new sfWidgetFormChoice(array(
      'choices' => sfEasyAuthUserPeer::getTypes(),
      'expanded' => true
    ));

  }
}
