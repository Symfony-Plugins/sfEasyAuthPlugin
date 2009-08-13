<?php use_stylesheet('/sfEasyAuthPlugin/css/auth.css') ?>
<?php use_javascript('/sfEasyAuthPlugin/js/auth.js') ?>

<div id="authContainer">
  <?php if ($sf_user->hasFlash('message')): ?>
  <div class="notice">
    <?php echo $sf_user->getFlash('message'); ?>
  </div>
  <?php endif ?>

  <form action="<?php echo url_for('@sf_easy_auth_login') ?>" method="post">
    <?php echo $loginForm ?>

    <input type="submit" value="Log in" />
  </form>

  <a href="#pwResetForm" class="subtle 
  <?php echo (strpos($_SERVER['REQUEST_URI'], sfConfig::get('app_sf_easy_auth_reset_user_not_found_url_token') . '=true') === false) ? 
    '' : 'hidden' ?>" id="pwResetLink">Reset your password</a>
  
  <form action="<?php echo url_for('@sf_easy_auth_password_reset') ?>" 
    method="post" class="
    <?php echo (strpos($_SERVER['REQUEST_URI'], sfConfig::get('app_sf_easy_auth_reset_user_not_found_url_token') . '=true') === false) ? 
      'hidden' : '' ?>" 
    id="pwResetForm" name="pw_reset">
    <?php echo $resetForm ?>
    
    <!-- input type="text" id="pw_reset_email" name="pw_reset[email]" /-->
    <input type="submit" value="Reset password" />
  </form>
</div>
