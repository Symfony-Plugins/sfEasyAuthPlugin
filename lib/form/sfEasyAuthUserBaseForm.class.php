<?php

/**
 * sfEasyAuthUser form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfEasyAuthUserBaseForm extends BasesfEasyAuthUserBaseForm
{
  public function configure()
  {
    unset($this['salt'],
          $this['created_at'],
          $this['updated_at'],
          $this['auto_login_hash'],
          $this['password_reset_token'],
          $this['password_reset_token_created_at'],
          $this['profile_id']);
          
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
    
    $this->widgetSchema['extra_credentials'] = new sfWidgetFormChoice(array(
      'choices' => sfEasyAuthUserCredentialsPeer::retrieveAllCredentials(),
      'expanded' => true,
      'multiple' => true
    ));
    
    // select the options that should be selected
    $this->widgetSchema['extra_credentials']->setDefault(sfContext::getInstance()->getUser()->getAuthUser()->getCredentials());
    
    // set up the validator
    $this->setValidator('extra_credentials', 
      new sfValidatorChoice(
        array(
          'choices' => sfEasyAuthUserCredentialsPeer::retrieveAllCredentials(),
          'multiple' => true
        )
      )
    );
  }
  
  /**
   * Overrides the save method to correctly handle extra credentials
   * 
   * @param $con Database connection
   */
  public function save($con=null)
  {
    if ($return = parent::save($con))
    {
      $credentials = $this->values['extra_credentials'];
    }
  }
}
