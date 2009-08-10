<?php

/**
 * Base static class for performing query and update operations on the 'sf_easy_auth_user' table.
 *
 * 
 *
 * @package    plugins.sfEasyAuthPlugin.lib.model.om
 */
abstract class BasesfEasyAuthUserPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'sf_easy_auth_user';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'plugins.sfEasyAuthPlugin.lib.model.sfEasyAuthUser';

	/** The total number of columns. */
	const NUM_COLUMNS = 14;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** the column name for the ID field */
	const ID = 'sf_easy_auth_user.ID';

	/** the column name for the USERNAME field */
	const USERNAME = 'sf_easy_auth_user.USERNAME';

	/** the column name for the PASSWORD field */
	const PASSWORD = 'sf_easy_auth_user.PASSWORD';

	/** the column name for the SALT field */
	const SALT = 'sf_easy_auth_user.SALT';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'sf_easy_auth_user.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'sf_easy_auth_user.UPDATED_AT';

	/** the column name for the LAST_LOGIN field */
	const LAST_LOGIN = 'sf_easy_auth_user.LAST_LOGIN';

	/** the column name for the LAST_LOGIN_ATTEMPT field */
	const LAST_LOGIN_ATTEMPT = 'sf_easy_auth_user.LAST_LOGIN_ATTEMPT';

	/** the column name for the FAILED_LOGINS field */
	const FAILED_LOGINS = 'sf_easy_auth_user.FAILED_LOGINS';

	/** the column name for the ENABLED field */
	const ENABLED = 'sf_easy_auth_user.ENABLED';

	/** the column name for the REMEMBER_KEY field */
	const REMEMBER_KEY = 'sf_easy_auth_user.REMEMBER_KEY';

	/** the column name for the REMEMBER_KEY_LIFETIME field */
	const REMEMBER_KEY_LIFETIME = 'sf_easy_auth_user.REMEMBER_KEY_LIFETIME';

	/** the column name for the HAS_EXTRA_CREDENTIALS field */
	const HAS_EXTRA_CREDENTIALS = 'sf_easy_auth_user.HAS_EXTRA_CREDENTIALS';

	/** the column name for the TYPE field */
	const TYPE = 'sf_easy_auth_user.TYPE';

	/** A key representing a particular subclass */
	const CLASSKEY_ADMIN = 'admin';

	/** A key representing a particular subclass */
	const CLASSKEY_SFEASYAUTHADMIN = 'admin';

	/** A class that can be returned by this peer. */
	const CLASSNAME_ADMIN = 'plugins.sfEasyAuthPlugin.lib.model.sfEasyAuthAdmin';

	/** A key representing a particular subclass */
	const CLASSKEY_BASICUSER = 'basicUser';

	/** A key representing a particular subclass */
	const CLASSKEY_SFEASYAUTHBASICUSER = 'basicUser';

	/** A class that can be returned by this peer. */
	const CLASSNAME_BASICUSER = 'plugins.sfEasyAuthPlugin.lib.model.sfEasyAuthBasicUser';

	/**
	 * An identiy map to hold any loaded instances of sfEasyAuthUser objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array sfEasyAuthUser[]
	 */
	public static $instances = array();

	/**
	 * The MapBuilder instance for this peer.
	 * @var        MapBuilder
	 */
	private static $mapBuilder = null;

	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Username', 'Password', 'Salt', 'CreatedAt', 'UpdatedAt', 'LastLogin', 'LastLoginAttempt', 'FailedLogins', 'Enabled', 'RememberKey', 'RememberKeyLifetime', 'HasExtraCredentials', 'Type', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'username', 'password', 'salt', 'createdAt', 'updatedAt', 'lastLogin', 'lastLoginAttempt', 'failedLogins', 'enabled', 'rememberKey', 'rememberKeyLifetime', 'hasExtraCredentials', 'type', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::USERNAME, self::PASSWORD, self::SALT, self::CREATED_AT, self::UPDATED_AT, self::LAST_LOGIN, self::LAST_LOGIN_ATTEMPT, self::FAILED_LOGINS, self::ENABLED, self::REMEMBER_KEY, self::REMEMBER_KEY_LIFETIME, self::HAS_EXTRA_CREDENTIALS, self::TYPE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'username', 'password', 'salt', 'created_at', 'updated_at', 'last_login', 'last_login_attempt', 'failed_logins', 'enabled', 'remember_key', 'remember_key_lifetime', 'has_extra_credentials', 'type', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Username' => 1, 'Password' => 2, 'Salt' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, 'LastLogin' => 6, 'LastLoginAttempt' => 7, 'FailedLogins' => 8, 'Enabled' => 9, 'RememberKey' => 10, 'RememberKeyLifetime' => 11, 'HasExtraCredentials' => 12, 'Type' => 13, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'username' => 1, 'password' => 2, 'salt' => 3, 'createdAt' => 4, 'updatedAt' => 5, 'lastLogin' => 6, 'lastLoginAttempt' => 7, 'failedLogins' => 8, 'enabled' => 9, 'rememberKey' => 10, 'rememberKeyLifetime' => 11, 'hasExtraCredentials' => 12, 'type' => 13, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::USERNAME => 1, self::PASSWORD => 2, self::SALT => 3, self::CREATED_AT => 4, self::UPDATED_AT => 5, self::LAST_LOGIN => 6, self::LAST_LOGIN_ATTEMPT => 7, self::FAILED_LOGINS => 8, self::ENABLED => 9, self::REMEMBER_KEY => 10, self::REMEMBER_KEY_LIFETIME => 11, self::HAS_EXTRA_CREDENTIALS => 12, self::TYPE => 13, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'username' => 1, 'password' => 2, 'salt' => 3, 'created_at' => 4, 'updated_at' => 5, 'last_login' => 6, 'last_login_attempt' => 7, 'failed_logins' => 8, 'enabled' => 9, 'remember_key' => 10, 'remember_key_lifetime' => 11, 'has_extra_credentials' => 12, 'type' => 13, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
	);

	/**
	 * Get a (singleton) instance of the MapBuilder for this peer class.
	 * @return     MapBuilder The map builder for this peer
	 */
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new sfEasyAuthUserMapBuilder();
		}
		return self::$mapBuilder;
	}
	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 * @throws     PropelException - if the specified name could not be found in the fieldname mappings.
	 */
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	/**
	 * Returns an array of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	/**
	 * Convenience method which changes table.column to alias.column.
	 *
	 * Using this method you can maintain SQL abstraction while using column aliases.
	 * <code>
	 *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
	 *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
	 * </code>
	 * @param      string $alias The alias for the current table.
	 * @param      string $column The column name for current table. (i.e. sfEasyAuthUserPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(sfEasyAuthUserPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad="true" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      criteria object containing the columns to add.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfEasyAuthUserPeer::ID);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::USERNAME);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::PASSWORD);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::SALT);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::CREATED_AT);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::UPDATED_AT);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::LAST_LOGIN);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::LAST_LOGIN_ATTEMPT);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::FAILED_LOGINS);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::ENABLED);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::REMEMBER_KEY);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::REMEMBER_KEY_LIFETIME);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::HAS_EXTRA_CREDENTIALS);

		$criteria->addSelectColumn(sfEasyAuthUserPeer::TYPE);

	}

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
		// we may modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(sfEasyAuthUserPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			sfEasyAuthUserPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(sfEasyAuthUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}


    foreach (sfMixer::getCallables('BasesfEasyAuthUserPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BasesfEasyAuthUserPeer', $criteria, $con);
    }


		// BasePeer returns a PDOStatement
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}
	/**
	 * Method to select one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     sfEasyAuthUser
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = sfEasyAuthUserPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	/**
	 * Method to do selects.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return sfEasyAuthUserPeer::populateObjects(sfEasyAuthUserPeer::doSelectStmt($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
	 *
	 * Use this method directly if you want to work with an executed statement durirectly (for example
	 * to perform your own object hydration).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con The connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     PDOStatement The executed PDOStatement object.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BasesfEasyAuthUserPeer:doSelectStmt:doSelectStmt') as $callable)
    {
      call_user_func($callable, 'BasesfEasyAuthUserPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(sfEasyAuthUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			sfEasyAuthUserPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		// BasePeer returns a PDOStatement
		return BasePeer::doSelect($criteria, $con);
	}
	/**
	 * Adds an object to the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doSelect*()
	 * methods in your stub classes -- you may need to explicitly add objects
	 * to the cache in order to ensure that the same objects are always returned by doSelect*()
	 * and retrieveByPK*() calls.
	 *
	 * @param      sfEasyAuthUser $value A sfEasyAuthUser object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool(sfEasyAuthUser $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getId();
			} // if key === null
			self::$instances[$key] = $obj;
		}
	}

	/**
	 * Removes an object from the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doDelete
	 * methods in your stub classes -- you may need to explicitly remove objects
	 * from the cache in order to prevent returning objects that no longer exist.
	 *
	 * @param      mixed $value A sfEasyAuthUser object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof sfEasyAuthUser) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or sfEasyAuthUser object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
				throw $e;
			}

			unset(self::$instances[$key]);
		}
	} // removeInstanceFromPool()

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
	 * @return     sfEasyAuthUser Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
	 * @see        getPrimaryKeyHash()
	 */
	public static function getInstanceFromPool($key)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if (isset(self::$instances[$key])) {
				return self::$instances[$key];
			}
		}
		return null; // just to be explicit
	}
	
	/**
	 * Clear the instance pool.
	 *
	 * @return     void
	 */
	public static function clearInstancePool()
	{
		self::$instances = array();
	}
	
	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     string A string version of PK or NULL if the components of primary key in result array are all null.
	 */
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
		// If the PK cannot be derived from the row, return NULL.
		if ($row[$startcol + 0] === null) {
			return null;
		}
		return (string) $row[$startcol + 0];
	}

	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = sfEasyAuthUserPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = sfEasyAuthUserPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
		
				// class must be set each time from the record row
				$cls = sfEasyAuthUserPeer::getOMClass($row, 0);
				$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				sfEasyAuthUserPeer::addInstanceToPool($obj, $key);
			} // if key exists
		}
		$stmt->closeCursor();
		return $results;
	}

  static public function getUniqueColumnNames()
  {
    return array(array('username'), array('remember_key'));
  }
	/**
	 * Returns the TableMap related to this peer.
	 * This method is not needed for general use but a specific application could have a need.
	 * @return     TableMap
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	/**
	 * The returned Class will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @param      array $row PropelPDO result row.
	 * @param      int $colnum Column to examine for OM class information (first is 0).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getOMClass($row, $colnum)
	{
		try {

			$omClass = null;
			$classKey = $row[$colnum + 13];

			switch($classKey) {

				case self::CLASSKEY_ADMIN:
					$omClass = self::CLASSNAME_ADMIN;
					break;

				case self::CLASSKEY_BASICUSER:
					$omClass = self::CLASSNAME_BASICUSER;
					break;

				default:
					$omClass = self::CLASS_DEFAULT;

			} // switch

		} catch (Exception $e) {
			throw new PropelException('Unable to get OM class.', $e);
		}
		return $omClass;
	}

	/**
	 * Method perform an INSERT on the database, given a sfEasyAuthUser or Criteria object.
	 *
	 * @param      mixed $values Criteria or sfEasyAuthUser object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BasesfEasyAuthUserPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfEasyAuthUserPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(sfEasyAuthUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from sfEasyAuthUser object
		}

		if ($criteria->containsKey(sfEasyAuthUserPeer::ID) && $criteria->keyContainsValue(sfEasyAuthUserPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.sfEasyAuthUserPeer::ID.')');
		}


		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollBack();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfEasyAuthUserPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfEasyAuthUserPeer', $values, $con, $pk);
    }

    return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a sfEasyAuthUser or Criteria object.
	 *
	 * @param      mixed $values Criteria or sfEasyAuthUser object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BasesfEasyAuthUserPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfEasyAuthUserPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(sfEasyAuthUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(sfEasyAuthUserPeer::ID);
			$selectCriteria->add(sfEasyAuthUserPeer::ID, $criteria->remove(sfEasyAuthUserPeer::ID), $comparison);

		} else { // $values is sfEasyAuthUser object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfEasyAuthUserPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfEasyAuthUserPeer', $values, $con, $ret);
    }

    return $ret;
  }

	/**
	 * Method to DELETE all rows from the sf_easy_auth_user table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(sfEasyAuthUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(sfEasyAuthUserPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a sfEasyAuthUser or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or sfEasyAuthUser object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      PropelPDO $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(sfEasyAuthUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			sfEasyAuthUserPeer::clearInstancePool();

			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof sfEasyAuthUser) {
			// invalidate the cache for this single object
			sfEasyAuthUserPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key



			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfEasyAuthUserPeer::ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
				// we can invalidate the cache for this single object
				sfEasyAuthUserPeer::removeInstanceFromPool($singleval);
			}
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);

			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given sfEasyAuthUser object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      sfEasyAuthUser $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(sfEasyAuthUser $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfEasyAuthUserPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfEasyAuthUserPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(sfEasyAuthUserPeer::DATABASE_NAME, sfEasyAuthUserPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfEasyAuthUserPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     sfEasyAuthUser
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = sfEasyAuthUserPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(sfEasyAuthUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(sfEasyAuthUserPeer::DATABASE_NAME);
		$criteria->add(sfEasyAuthUserPeer::ID, $pk);

		$v = sfEasyAuthUserPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      PropelPDO $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(sfEasyAuthUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(sfEasyAuthUserPeer::DATABASE_NAME);
			$criteria->add(sfEasyAuthUserPeer::ID, $pks, Criteria::IN);
			$objs = sfEasyAuthUserPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BasesfEasyAuthUserPeer

// This is the static code needed to register the MapBuilder for this table with the main Propel class.
//
// NOTE: This static code cannot call methods on the sfEasyAuthUserPeer class, because it is not defined yet.
// If you need to use overridden methods, you can add this code to the bottom of the sfEasyAuthUserPeer class:
//
// Propel::getDatabaseMap(sfEasyAuthUserPeer::DATABASE_NAME)->addTableBuilder(sfEasyAuthUserPeer::TABLE_NAME, sfEasyAuthUserPeer::getMapBuilder());
//
// Doing so will effectively overwrite the registration below.

Propel::getDatabaseMap(BasesfEasyAuthUserPeer::DATABASE_NAME)->addTableBuilder(BasesfEasyAuthUserPeer::TABLE_NAME, BasesfEasyAuthUserPeer::getMapBuilder());

