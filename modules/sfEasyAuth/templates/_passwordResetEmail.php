Hi,

Please click on the link below to log in to <?php echo sfConfig::get('app_site_name') ?>
and reset your password:

    <?php 
    echo 'http://www.example.com?' . http_build_query(
      array(
        'id' => $user->getId(), 
        'alh' => $user->getAutoLoginHash(),
        'token' => $user->getPasswordResetToken()
      )
    ); ?>
    
Thanks,
<?php echo sfConfig::get('app_sf_easy_auth_reset_from_name')?>