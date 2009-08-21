<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * sfEasyAuthUserBase filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasesfEasyAuthUserBaseFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'username'                        => new sfWidgetFormFilterInput(),
      'password'                        => new sfWidgetFormFilterInput(),
      'email'                           => new sfWidgetFormFilterInput(),
      'email_confirmed'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'salt'                            => new sfWidgetFormFilterInput(),
      'created_at'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'last_login'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'last_login_attempt'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'failed_logins'                   => new sfWidgetFormFilterInput(),
      'locked_by_admins'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'remember_key'                    => new sfWidgetFormFilterInput(),
      'remember_key_lifetime'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'auto_login_hash'                 => new sfWidgetFormFilterInput(),
      'password_reset_token'            => new sfWidgetFormFilterInput(),
      'password_reset_token_created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'has_extra_credentials'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'type'                            => new sfWidgetFormFilterInput(),
      'profile_id'                      => new sfWidgetFormFilterInput(),
      'sb_user_marketing_question_list' => new sfWidgetFormPropelChoice(array('model' => 'SbMarketingQuestion', 'add_empty' => true)),
      'sb_user_mailing_list_list'       => new sfWidgetFormPropelChoice(array('model' => 'SbMailingList', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'username'                        => new sfValidatorPass(array('required' => false)),
      'password'                        => new sfValidatorPass(array('required' => false)),
      'email'                           => new sfValidatorPass(array('required' => false)),
      'email_confirmed'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'salt'                            => new sfValidatorPass(array('required' => false)),
      'created_at'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'last_login'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'last_login_attempt'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'failed_logins'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'locked_by_admins'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'remember_key'                    => new sfValidatorPass(array('required' => false)),
      'remember_key_lifetime'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'auto_login_hash'                 => new sfValidatorPass(array('required' => false)),
      'password_reset_token'            => new sfValidatorPass(array('required' => false)),
      'password_reset_token_created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'has_extra_credentials'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'type'                            => new sfValidatorPass(array('required' => false)),
      'profile_id'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sb_user_marketing_question_list' => new sfValidatorPropelChoice(array('model' => 'SbMarketingQuestion', 'required' => false)),
      'sb_user_mailing_list_list'       => new sfValidatorPropelChoice(array('model' => 'SbMailingList', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_easy_auth_user_base_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addSbUserMarketingQuestionListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(SbUserMarketingQuestionPeer::USER_ID, sfEasyAuthUserBasePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(SbUserMarketingQuestionPeer::QUESTION_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(SbUserMarketingQuestionPeer::QUESTION_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addSbUserMailingListListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(SbUserMailingListPeer::USER_ID, sfEasyAuthUserBasePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(SbUserMailingListPeer::MAILING_LIST_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(SbUserMailingListPeer::MAILING_LIST_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'sfEasyAuthUserBase';
  }

  public function getFields()
  {
    return array(
      'id'                              => 'Number',
      'username'                        => 'Text',
      'password'                        => 'Text',
      'email'                           => 'Text',
      'email_confirmed'                 => 'Boolean',
      'salt'                            => 'Text',
      'created_at'                      => 'Date',
      'updated_at'                      => 'Date',
      'last_login'                      => 'Date',
      'last_login_attempt'              => 'Date',
      'failed_logins'                   => 'Number',
      'locked_by_admins'                => 'Boolean',
      'remember_key'                    => 'Text',
      'remember_key_lifetime'           => 'Date',
      'auto_login_hash'                 => 'Text',
      'password_reset_token'            => 'Text',
      'password_reset_token_created_at' => 'Date',
      'has_extra_credentials'           => 'Boolean',
      'type'                            => 'Text',
      'profile_id'                      => 'Number',
      'sb_user_marketing_question_list' => 'ManyKey',
      'sb_user_mailing_list_list'       => 'ManyKey',
    );
  }
}
