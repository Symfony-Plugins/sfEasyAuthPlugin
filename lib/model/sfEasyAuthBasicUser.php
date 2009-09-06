<?php


/**
 * Skeleton subclass for representing a row from one of the subclasses of the 'sf_easy_auth_user' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    plugins.sfEasyAuthPlugin.lib.model
 */
class sfEasyAuthBasicUser extends sfEasyAuthBasicUserLocal {

	/**
	 * Constructs a new sfEasyAuthBasicUser class, setting the type column to sfEasyAuthUserPeer::CLASSKEY_USER.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->setType(sfEasyAuthUserPeer::CLASSKEY_BASICUSER);
	}

} // sfEasyAuthBasicUser
