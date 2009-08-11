<?php


/**
 * This class adds structure of 'sf_easy_auth_user_credentials' table to 'propel' DatabaseMap object.
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
class SfEasyAuthUserCredentialsMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfEasyAuthPlugin.lib.model.map.SfEasyAuthUserCredentialsMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(SfEasyAuthUserCredentialsPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(SfEasyAuthUserCredentialsPeer::TABLE_NAME);
		$tMap->setPhpName('SfEasyAuthUserCredentials');
		$tMap->setClassname('SfEasyAuthUserCredentials');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'sf_easy_auth_user', 'ID', true, null);

		$tMap->addColumn('CREDENTIAL', 'Credential', 'VARCHAR', true, 60);

		$tMap->addColumn('PROFILE_ID', 'ProfileId', 'INTEGER', false, null);

	} // doBuild()

} // SfEasyAuthUserCredentialsMapBuilder
