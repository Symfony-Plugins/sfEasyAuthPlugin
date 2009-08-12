<?php

/**
 * sfEasyAuthUser form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasesfEasyAuthUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'username'              => new sfWidgetFormInput(),
      'password'              => new sfWidgetFormInput(),
      'email'                 => new sfWidgetFormInput(),
      'salt'                  => new sfWidgetFormInput(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'last_login'            => new sfWidgetFormDateTime(),
      'last_login_attempt'    => new sfWidgetFormDateTime(),
      'failed_logins'         => new sfWidgetFormInput(),
      'enabled'               => new sfWidgetFormInputCheckbox(),
      'remember_key'          => new sfWidgetFormInput(),
      'remember_key_lifetime' => new sfWidgetFormDateTime(),
      'auto_login_hash'       => new sfWidgetFormInput(),
      'has_extra_credentials' => new sfWidgetFormInputCheckbox(),
      'type'                  => new sfWidgetFormInput(),
      'profile_id'            => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorPropelChoice(array('model' => 'sfEasyAuthUser', 'column' => 'id', 'required' => false)),
      'username'              => new sfValidatorString(array('max_length' => 50)),
      'password'              => new sfValidatorString(array('max_length' => 32)),
      'email'                 => new sfValidatorString(array('max_length' => 255)),
      'salt'                  => new sfValidatorString(array('max_length' => 32)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
      'last_login'            => new sfValidatorDateTime(array('required' => false)),
      'last_login_attempt'    => new sfValidatorDateTime(array('required' => false)),
      'failed_logins'         => new sfValidatorInteger(array('required' => false)),
      'enabled'               => new sfValidatorBoolean(array('required' => false)),
      'remember_key'          => new sfValidatorString(array('max_length' => 42, 'required' => false)),
      'remember_key_lifetime' => new sfValidatorDateTime(array('required' => false)),
      'auto_login_hash'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'has_extra_credentials' => new sfValidatorBoolean(array('required' => false)),
      'type'                  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'profile_id'            => new sfValidatorInteger(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'sfEasyAuthUser', 'column' => array('username'))),
        new sfValidatorPropelUnique(array('model' => 'sfEasyAuthUser', 'column' => array('email'))),
        new sfValidatorPropelUnique(array('model' => 'sfEasyAuthUser', 'column' => array('remember_key'))),
      ))
    );

    $this->widgetSchema->setNameFormat('sf_easy_auth_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfEasyAuthUser';
  }


}
