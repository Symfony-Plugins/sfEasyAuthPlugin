<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SfEasyAuthUserCredentials filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfEasyAuthUserCredentialsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormPropelChoice(array('model' => 'sfEasyAuthUser', 'add_empty' => true)),
      'credential' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfEasyAuthUser', 'column' => 'id')),
      'credential' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_easy_auth_user_credentials_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfEasyAuthUserCredentials';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'user_id'    => 'ForeignKey',
      'credential' => 'Text',
    );
  }
}
