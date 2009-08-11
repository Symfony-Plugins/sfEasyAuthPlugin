<?php use_stylesheet('/sfEasyAuthPlugin/css/auth.css') ?>
<?php use_javascript('/sfEasyAuthPlugin/js/auth.js') ?>

<div id="loginFormContainer">
  <?php if ($sf_user->hasFlash('message')): ?>
  <div class="notice">
    <?php echo $sf_user->getFlash('message'); ?>
  </div>
  <?php endif ?>

  <form action="<?php echo url_for('@sf_easy_auth_login') ?>" method="post">
    <?php echo $form ?>

    <input type="submit" value="Log in" />
  </form>

  <a href="#pwResetForm" class="subtle" id="pwResetLink">Reset your password</a>
  
  <form action="<?php echo url_for('@sf_easy_auth_password_reset') ?>" 
    method="post" class="hidden" id="pwResetForm">
    <label for="email">Please enter your email address</label>
    <input type="text" id="pw_reset_email" name="pw_reset[email]" />
    <input type="submit" value="Reset password" />
  </form>
</div>