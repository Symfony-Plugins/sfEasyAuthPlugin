<?php use_stylesheet('/sfEasyAuthPlugin/css/auth.css') ?>

<div id="loginForm">
  <?php if ($sf_user->hasFlash('message')): ?>
  <div class="notice">
    <?php echo $sf_user->getFlash('message'); ?>
  </div>
  <?php endif ?>

  <form action="<?php echo url_for('@sf_easy_auth_login') ?>" method="post">
    <?php echo $form ?>

    <input type="submit" value="Log in" />
  </form>
</div>