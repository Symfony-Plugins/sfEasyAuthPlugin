<?php

/**
 * sfEasyAuth log-in form.
 *
 * @package    .
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfEasyAuthLoginForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'username'  => new sfWidgetFormInput(),
      'password' => new sfWidgetFormInputPassword(),
      'remember' => new sfWidgetFormInputCheckbox(),
    ));

    // use a better formatter than the default on provided by symfony
    $oDecorator = new sfWidgetFormSchemaFormatterDiv($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('div', $oDecorator);
    $this->getWidgetSchema()->setFormFormatterName('div');
    
    $this->widgetSchema->setLabels(array(
      'username' => 'User name',
      'remember' => 'Remember me'
    ));

    $this->widgetSchema->setNameFormat('login[%s]');

    $this->setValidators(array(
      'username' => new sfValidatorString(array('required' => true)),
      'password' => new sfValidatorString(array('required' => true)),
      'remember' => new sfValidatorBoolean()
      ));
  }
}
