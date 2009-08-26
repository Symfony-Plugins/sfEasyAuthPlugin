<?php

/**
 * sfEasyAuthUserCredential form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasesfEasyAuthUserCredentialForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfEasyAuthUserBase', 'add_empty' => false)),
      'credential' => new sfWidgetFormInput(),
      'profile_id' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'sfEasyAuthUserCredential', 'column' => 'id', 'required' => false)),
      'user_id'    => new sfValidatorPropelChoice(array('model' => 'sfEasyAuthUserBase', 'column' => 'id')),
      'credential' => new sfValidatorString(array('max_length' => 60)),
      'profile_id' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_easy_auth_user_credential[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfEasyAuthUserCredential';
  }


}
