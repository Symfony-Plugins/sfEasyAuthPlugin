<?php

/**
 * sfEasyAuthUserBase form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasesfEasyAuthUserBaseForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                              => new sfWidgetFormInputHidden(),
      'username'                        => new sfWidgetFormInput(),
      'password'                        => new sfWidgetFormInput(),
      'email'                           => new sfWidgetFormInput(),
      'email_confirmed'                 => new sfWidgetFormInputCheckbox(),
      'salt'                            => new sfWidgetFormInput(),
      'created_at'                      => new sfWidgetFormDateTime(),
      'updated_at'                      => new sfWidgetFormDateTime(),
      'last_login'                      => new sfWidgetFormDateTime(),
      'last_login_attempt'              => new sfWidgetFormDateTime(),
      'failed_logins'                   => new sfWidgetFormInput(),
      'locked_by_admins'                => new sfWidgetFormInputCheckbox(),
      'remember_key'                    => new sfWidgetFormInput(),
      'remember_key_lifetime'           => new sfWidgetFormDateTime(),
      'auto_login_hash'                 => new sfWidgetFormInput(),
      'password_reset_token'            => new sfWidgetFormInput(),
      'password_reset_token_created_at' => new sfWidgetFormDateTime(),
      'has_extra_credentials'           => new sfWidgetFormInputCheckbox(),
      'type'                            => new sfWidgetFormInput(),
      'profile_id'                      => new sfWidgetFormInput(),
      'sb_user_marketing_question_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'SbMarketingQuestion')),
      'sb_user_offer_use_list'          => new sfWidgetFormPropelChoiceMany(array('model' => 'SbOffer')),
      'sb_user_mailing_list_list'       => new sfWidgetFormPropelChoiceMany(array('model' => 'SbMailingList')),
      'sb_user_competition_answer_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'SbCompetition')),
    ));

    $this->setValidators(array(
      'id'                              => new sfValidatorPropelChoice(array('model' => 'sfEasyAuthUserBase', 'column' => 'id', 'required' => false)),
      'username'                        => new sfValidatorString(array('max_length' => 50)),
      'password'                        => new sfValidatorString(array('max_length' => 32)),
      'email'                           => new sfValidatorString(array('max_length' => 255)),
      'email_confirmed'                 => new sfValidatorBoolean(array('required' => false)),
      'salt'                            => new sfValidatorString(array('max_length' => 32)),
      'created_at'                      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                      => new sfValidatorDateTime(array('required' => false)),
      'last_login'                      => new sfValidatorDateTime(array('required' => false)),
      'last_login_attempt'              => new sfValidatorDateTime(array('required' => false)),
      'failed_logins'                   => new sfValidatorInteger(array('required' => false)),
      'locked_by_admins'                => new sfValidatorBoolean(array('required' => false)),
      'remember_key'                    => new sfValidatorString(array('max_length' => 42, 'required' => false)),
      'remember_key_lifetime'           => new sfValidatorDateTime(array('required' => false)),
      'auto_login_hash'                 => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'password_reset_token'            => new sfValidatorString(array('max_length' => 12, 'required' => false)),
      'password_reset_token_created_at' => new sfValidatorDateTime(array('required' => false)),
      'has_extra_credentials'           => new sfValidatorBoolean(array('required' => false)),
      'type'                            => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'profile_id'                      => new sfValidatorInteger(array('required' => false)),
      'sb_user_marketing_question_list' => new sfValidatorPropelChoiceMany(array('model' => 'SbMarketingQuestion', 'required' => false)),
      'sb_user_offer_use_list'          => new sfValidatorPropelChoiceMany(array('model' => 'SbOffer', 'required' => false)),
      'sb_user_mailing_list_list'       => new sfValidatorPropelChoiceMany(array('model' => 'SbMailingList', 'required' => false)),
      'sb_user_competition_answer_list' => new sfValidatorPropelChoiceMany(array('model' => 'SbCompetition', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'sfEasyAuthUserBase', 'column' => array('username'))),
        new sfValidatorPropelUnique(array('model' => 'sfEasyAuthUserBase', 'column' => array('email'))),
      ))
    );

    $this->widgetSchema->setNameFormat('sf_easy_auth_user_base[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfEasyAuthUserBase';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['sb_user_marketing_question_list']))
    {
      $values = array();
      foreach ($this->object->getSbUserMarketingQuestions() as $obj)
      {
        $values[] = $obj->getQuestionId();
      }

      $this->setDefault('sb_user_marketing_question_list', $values);
    }

    if (isset($this->widgetSchema['sb_user_offer_use_list']))
    {
      $values = array();
      foreach ($this->object->getSbUserOfferUses() as $obj)
      {
        $values[] = $obj->getOfferId();
      }

      $this->setDefault('sb_user_offer_use_list', $values);
    }

    if (isset($this->widgetSchema['sb_user_mailing_list_list']))
    {
      $values = array();
      foreach ($this->object->getSbUserMailingLists() as $obj)
      {
        $values[] = $obj->getMailingListId();
      }

      $this->setDefault('sb_user_mailing_list_list', $values);
    }

    if (isset($this->widgetSchema['sb_user_competition_answer_list']))
    {
      $values = array();
      foreach ($this->object->getSbUserCompetitionAnswers() as $obj)
      {
        $values[] = $obj->getCompetitionId();
      }

      $this->setDefault('sb_user_competition_answer_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveSbUserMarketingQuestionList($con);
    $this->saveSbUserOfferUseList($con);
    $this->saveSbUserMailingListList($con);
    $this->saveSbUserCompetitionAnswerList($con);
  }

  public function saveSbUserMarketingQuestionList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['sb_user_marketing_question_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(SbUserMarketingQuestionPeer::USER_ID, $this->object->getPrimaryKey());
    SbUserMarketingQuestionPeer::doDelete($c, $con);

    $values = $this->getValue('sb_user_marketing_question_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new SbUserMarketingQuestion();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setQuestionId($value);
        $obj->save();
      }
    }
  }

  public function saveSbUserOfferUseList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['sb_user_offer_use_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(SbUserOfferUsePeer::USER_ID, $this->object->getPrimaryKey());
    SbUserOfferUsePeer::doDelete($c, $con);

    $values = $this->getValue('sb_user_offer_use_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new SbUserOfferUse();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setOfferId($value);
        $obj->save();
      }
    }
  }

  public function saveSbUserMailingListList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['sb_user_mailing_list_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(SbUserMailingListPeer::USER_ID, $this->object->getPrimaryKey());
    SbUserMailingListPeer::doDelete($c, $con);

    $values = $this->getValue('sb_user_mailing_list_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new SbUserMailingList();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setMailingListId($value);
        $obj->save();
      }
    }
  }

  public function saveSbUserCompetitionAnswerList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['sb_user_competition_answer_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(SbUserCompetitionAnswerPeer::USER_ID, $this->object->getPrimaryKey());
    SbUserCompetitionAnswerPeer::doDelete($c, $con);

    $values = $this->getValue('sb_user_competition_answer_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new SbUserCompetitionAnswer();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setCompetitionId($value);
        $obj->save();
      }
    }
  }

}
