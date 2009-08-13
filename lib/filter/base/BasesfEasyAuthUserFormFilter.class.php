<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * sfEasyAuthUser filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasesfEasyAuthUserFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'username'                        => new sfWidgetFormFilterInput(),
      'password'                        => new sfWidgetFormFilterInput(),
      'email'                           => new sfWidgetFormFilterInput(),
      'salt'                            => new sfWidgetFormFilterInput(),
      'created_at'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'last_login'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'last_login_attempt'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'failed_logins'                   => new sfWidgetFormFilterInput(),
      'enabled'                         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'remember_key'                    => new sfWidgetFormFilterInput(),
      'remember_key_lifetime'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'auto_login_hash'                 => new sfWidgetFormFilterInput(),
      'password_reset_token'            => new sfWidgetFormFilterInput(),
      'password_reset_token_created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'has_extra_credentials'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'type'                            => new sfWidgetFormFilterInput(),
      'profile_id'                      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'username'                        => new sfValidatorPass(array('required' => false)),
      'password'                        => new sfValidatorPass(array('required' => false)),
      'email'                           => new sfValidatorPass(array('required' => false)),
      'salt'                            => new sfValidatorPass(array('required' => false)),
      'created_at'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'last_login'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'last_login_attempt'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'failed_logins'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'enabled'                         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'remember_key'                    => new sfValidatorPass(array('required' => false)),
      'remember_key_lifetime'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'auto_login_hash'                 => new sfValidatorPass(array('required' => false)),
      'password_reset_token'            => new sfValidatorPass(array('required' => false)),
      'password_reset_token_created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'has_extra_credentials'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'type'                            => new sfValidatorPass(array('required' => false)),
      'profile_id'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('sf_easy_auth_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfEasyAuthUser';
  }

  public function getFields()
  {
    return array(
      'id'                              => 'Number',
      'username'                        => 'Text',
      'password'                        => 'Text',
      'email'                           => 'Text',
      'salt'                            => 'Text',
      'created_at'                      => 'Date',
      'updated_at'                      => 'Date',
      'last_login'                      => 'Date',
      'last_login_attempt'              => 'Date',
      'failed_logins'                   => 'Number',
      'enabled'                         => 'Boolean',
      'remember_key'                    => 'Text',
      'remember_key_lifetime'           => 'Date',
      'auto_login_hash'                 => 'Text',
      'password_reset_token'            => 'Text',
      'password_reset_token_created_at' => 'Date',
      'has_extra_credentials'           => 'Boolean',
      'type'                            => 'Text',
      'profile_id'                      => 'Number',
    );
  }
}
