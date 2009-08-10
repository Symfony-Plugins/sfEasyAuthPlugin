<?php

/*
 * Based on sfGuardCreateUserTask
 */

/**
 * Create a new user.
 *
 * @package    symfony
 * @subpackage task
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardCreateUserTask.class.php 13761 2008-12-05 10:14:51Z fabien $
 */
class sfEasyAuthCreateUserTask extends sfPropelBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('username', sfCommandArgument::REQUIRED, 'The user name'),
      new sfCommandArgument('password', sfCommandArgument::REQUIRED, 'The password'),
      new sfCommandArgument('type', sfCommandArgument::REQUIRED, 'The type of user'),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
    ));

    $this->namespace = 'easyAuth';
    $this->name = 'create-user';
    $this->briefDescription = 'Creates a user';

    $this->detailedDescription = <<<EOF
The [easyAuth:create-user|INFO] task creates a user:

  [./symfony easyAuth:create-user al pw\$\$word user|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $class = 'sfEasyAuth' . ucfirst(trim($arguments['type'])); 
    $user = new $class();
    $user->setUsername($arguments['username']);
    $user->setPassword($arguments['password']);
    $user->save();

    $this->logSection('easyAuth', sprintf('Create %s user "%s"', $arguments['type'], $arguments['username']));
  }
}
