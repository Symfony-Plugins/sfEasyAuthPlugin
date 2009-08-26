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
  /**
   * @var sfEasyAuthUser $eaUser The easy auth user this form represents
   */
  protected $eaUser;
  
  public function configure()
  {
    unset($this['salt'],
          $this['created_at'],
          $this['updated_at'],
          $this['auto_login_hash'],
          $this['has_extra_credentials'],
          $this['password_reset_token'],
          $this['password_reset_token_created_at'],
          $this['profile_id']);
          
    if (!$eaUser = sfEasyAuthUserBasePeer::retrieveByPk($this->getObject()->getId()))
    {
      throw new RuntimeException("No user exists with ID " . $this->getObject()->getId());
    }
    
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
      'choices' => $eaUser->getPossibleExtraCredentials(),
      'expanded' => true,
      'multiple' => true
    ));

    // select the options that should be selected
    $this->widgetSchema['extra_credentials']->setDefault($eaUser->getCredentials());
    
    $this->getWidgetSchema()->setHelps(
      array('type' => 'You may not edit this')
    );
    
    // set up the validator
    $this->setValidator('extra_credentials', 
      new sfValidatorChoice(
        array(
          'choices' => $eaUser->getPossibleExtraCredentials(),
          'multiple' => true,
          'required' => false
        )
      )
    );
    
    $this->eaUser = $eaUser;
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
      // save extra credentials
      $extraCredentials = (is_array($this->values['extra_credentials'])) ? 
        $this->values['extra_credentials'] : array();
      $this->eaUser->saveExtraCredentials($extraCredentials);
    }
  }
}
