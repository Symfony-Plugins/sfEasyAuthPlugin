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
class sfEasyAuthCompany extends sfEasyAuthCompanyLocal {

	/**
	 * Constructs a new sfEasyAuthCompany class, setting the type column to sfEasyAuthUserBasePeer::CLASSKEY_COMPANY.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->setType(sfEasyAuthUserBasePeer::CLASSKEY_COMPANY);
	}

} // sfEasyAuthCompany
