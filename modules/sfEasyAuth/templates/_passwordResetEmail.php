Hi,

Please click on the link below to log in to <?php echo sfConfig::get('app_site_name') ?>
and reset your password:

    <?php 
    // need to make a helper for creating auto-login links
    echo sfConfig::get('app_sf_easy_auth_base_url') . url_for('@sf_easy_auth_password_reset_set_password') . '?' . 
      http_build_query(
        array(
          'uid' => $user->getId(), 
          'alh' => $user->getAutoLoginHash(),
          'token' => $user->getPasswordResetToken()
        )
      ); ?>
    
Thanks,
<?php echo sfConfig::get('app_sf_easy_auth_reset_from_name')?>