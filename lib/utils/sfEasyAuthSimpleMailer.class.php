<?php
/**
 * Simple class for sending emails. Uses PHP's 'mail' function
 * 
 * @author al
 *
 */
class sfEasyAuthSimpleMailer
{
  /**
   * Sends an email containing $message to $user
   * 
   * @param sfEasyAuthUser $user The recipient user
   * @param string $subject The message subject
   * @param string $message The message to send
   */
  public static function mail(sfEasyAuthUser $user, $subject, $message)
  {
    // i18n if necessary
    if (sfConfig::get('app_sf_easy_auth_use_i18n'))
    {
      $subject = sfContext::getInstance()->getI18n()->__($subject);
    }

    // send the email
    return self::mail($user->getEmail(), $subject, $message);
  }
}