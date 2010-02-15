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
          $this['has_credentials'],
          $this['password_reset_token'],
          $this['password_reset_token_created_at'],
          $this['profile_id']);
          
    if (!$eaUser = sfEasyAuthUserPeer::retrieveByPk($this->getObject()->getId()))
    {
      throw new RuntimeException("No user exists with ID " . $this->getObject()->getId());
    }
    
    $this->widgetSchema->setHelps(array(
      'password' => 'Use this box to set a new password for the user.'
    ));
          
    $this->widgetSchema['password'] = new sfWidgetFormInputConfigurable(array(
      'value' => ($this->isNew()) ? '' : sfEasyAuthUser::PASSWORD_MASK
    ));

    $this->widgetSchema['credentials'] = new sfWidgetFormChoice(array(
      'choices' => $eaUser->getPossibleCredentials(),
      'expanded' => true,
      'multiple' => true
    ));

    $this->widgetSchema->setHelp('credentials', 'Warning: Deleting a credential for which this user has a profile ' .
      ' will delete the profile too.');

    // select the options that should be selected
    $this->widgetSchema['credentials']->setDefault($eaUser->getCredentials());
    
    // set up the validator
    $this->setValidator('credentials',
      new sfValidatorChoice(
        array(
          'choices' => $eaUser->getPossibleCredentials(),
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
      // set credentials
      $credentials = (is_array($this->values['credentials'])) ?
        $this->values['credentials'] : array();
      $this->eaUser->setCredentials($credentials);
    }
  }
}
