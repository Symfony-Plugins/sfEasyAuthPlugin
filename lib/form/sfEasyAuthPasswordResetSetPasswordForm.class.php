<?php

/**
 * sfEasyAuth password reset form allows users to set a new password.
 * 
 * This form must be instantiated passing the following options:
 * 
 *   * token - the value of a password reset token
 *
 * @package    .
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfEasyAuthPasswordResetSetPasswordForm extends sfForm
{
  public function configure()
  {
    // make sure the reset token was set as an option so we can embed it in a hidden
    // field in case the form is invalid
    if (strlen($this->getOption('token')) === 0)
    {
      throw new RuntimeException("Error, no token set.");
    }
    
    $this->setWidgets(array(
      'token' => new sfWidgetFormInputHidden(array('default' => $this->getOption('token'))),
      'password'  => new sfWidgetFormInputPassword(),
      'confirm_password' => new sfWidgetFormInputPassword(),
    ));

    // use a better formatter than the default on provided by symfony
    $oDecorator = new sfEasyAuthWidgetFormSchemaFormatterDiv($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('div', $oDecorator);
    $this->getWidgetSchema()->setFormFormatterName('div');
    
    $this->widgetSchema->setNameFormat('pw_reset[%s]');

    $this->setValidators(
      array(
        'token' => new sfValidatorString(
          array('min_length' => 12, 'max_length' => 12)
        ),
        'password' => new sfValidatorString(
          array('min_length' => 4, 'max_length' => 50), 
          array('required' => 'Please enter a password',
            'min_length' => 'Your password is too short. Please enter one at least %min_length% characters.',
            'max_length' => 'Your password is too long. Please enter one between %min_length% and %max_length%.'
          )
        ),
        'confirm_password' => new sfValidatorString(
          array('min_length' => 4, 'max_length' => 50), 
          // set blank messages since there is no point duplicating the messages from the 
          // first password field
          array('required' => ' ',
            'min_length' => ' ',
            'max_length' => ' '
          )
        )
      )
    );
    
    // make sure both passwords match
    $this->validatorSchema->setPostValidator(
      new sfValidatorSchemaCompare(
        'confirm_password',  
        '==', 
        'password',
        array(),
        array('invalid' => "Your passwords don't match")
        )
    );
  }
}
