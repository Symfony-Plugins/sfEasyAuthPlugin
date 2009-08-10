<?php use_stylesheet('/sfEasyAuthPlugin/css/auth.css') ?>
<?php use_helper('I18N') ?>

<h1><?php echo __("Additional privileges required") ?></h1>
<p><?php echo __("The resource you are trying to access requires additional privileges. Please
     enter your details below to acquire them.") ?></p>
     
<div id="loginForm">
  <?php if ($sf_user->hasFlash('message')): ?>
  <div class="notice">
    <?php echo $sf_user->getFlash('message'); ?>
  </div>
  <?php endif ?>

  <form action="<?php echo url_for('@sf_easy_auth_secure') ?>" method="post">
    <?php echo $form ?>

    <input type="submit" value="Log in" />
  </form>
</div>