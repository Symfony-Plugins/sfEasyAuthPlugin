<?php

/**
 * sfEasyAuthUser filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class sfEasyAuthUserFormFilter extends BasesfEasyAuthUserFormFilter
{
  public function configure()
  {
    $this->useFields(array('username', 'email', 'locked_by_admins'));

    $credentials = array_merge(array('' => 'Any'), sfEasyAuthUserCredentialPeer::getAllCredentialsAsArray());

    $this->widgetSchema['credential'] = new sfWidgetFormChoice(
      array(
        'choices' => $credentials,
        'expanded' => false
      )
    );

    $this->validatorSchema['credential'] = new sfValidatorChoice(
      array(
        'choices' => $credentials,
        'required' => false
      )
    );
  }

  /**
   * Support filtering by credential
   *
   * @param Criteria $criteria
   * @param <type> $field
   * @param <type> $values
   */
  public function addCredentialColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (empty($values))
    {
      return $criteria;
    }

    $criteria->addJoin(sfEasyAuthUserPeer::ID, sfEasyAuthUserCredentialPeer::USER_ID);

    $criteria->add(sfEasyAuthUserCredentialPeer::CREDENTIAL, $values);

    return $criteria;
  }
  
  /**
   * Trims whitespace from the email address
   */
  public function convertEmailValue($value)
  {
    foreach ($value as $k => $v)
    {
      $value[$k] = trim($v);
    }
    
    return $value;
  }
  
  /**
   * Trims whitespace from the user name
   */
  public function convertUsernameValue($value)
  {
    foreach ($value as $k => $v)
    {
      $value[$k] = trim($v);
    }
    
    return $value;
  }
}
