<?php


/**
 * This class adds structure of 'sf_easy_auth_user' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfEasyAuthPlugin.lib.model.map
 */
class sfEasyAuthUserMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfEasyAuthPlugin.lib.model.map.sfEasyAuthUserMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(sfEasyAuthUserPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(sfEasyAuthUserPeer::TABLE_NAME);
		$tMap->setPhpName('sfEasyAuthUser');
		$tMap->setClassname('sfEasyAuthUser');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('USERNAME', 'Username', 'VARCHAR', true, 50);

		$tMap->addColumn('PASSWORD', 'Password', 'VARCHAR', true, 32);

		$tMap->addColumn('EMAIL', 'Email', 'VARCHAR', true, 255);

		$tMap->addColumn('EMAIL_CONFIRMED', 'EmailConfirmed', 'BOOLEAN', false, null);

		$tMap->addColumn('SALT', 'Salt', 'VARCHAR', true, 32);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('LAST_LOGIN', 'LastLogin', 'TIMESTAMP', false, null);

		$tMap->addColumn('LAST_LOGIN_ATTEMPT', 'LastLoginAttempt', 'TIMESTAMP', false, null);

		$tMap->addColumn('FAILED_LOGINS', 'FailedLogins', 'INTEGER', false, null);

		$tMap->addColumn('ENABLED', 'Enabled', 'BOOLEAN', false, null);

		$tMap->addColumn('REMEMBER_KEY', 'RememberKey', 'VARCHAR', false, 42);

		$tMap->addColumn('REMEMBER_KEY_LIFETIME', 'RememberKeyLifetime', 'TIMESTAMP', false, null);

		$tMap->addColumn('AUTO_LOGIN_HASH', 'AutoLoginHash', 'VARCHAR', false, 32);

		$tMap->addColumn('PASSWORD_RESET_TOKEN', 'PasswordResetToken', 'VARCHAR', false, 12);

		$tMap->addColumn('PASSWORD_RESET_TOKEN_CREATED_AT', 'PasswordResetTokenCreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('HAS_EXTRA_CREDENTIALS', 'HasExtraCredentials', 'BOOLEAN', false, null);

		$tMap->addColumn('TYPE', 'Type', 'VARCHAR', false, 10);

		$tMap->addColumn('PROFILE_ID', 'ProfileId', 'INTEGER', false, null);

	} // doBuild()

} // sfEasyAuthUserMapBuilder
