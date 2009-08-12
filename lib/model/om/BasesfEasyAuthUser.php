<?php

/**
 * Base class that represents a row from the 'sf_easy_auth_user' table.
 *
 * 
 *
 * @package    plugins.sfEasyAuthPlugin.lib.model.om
 */
abstract class BasesfEasyAuthUser extends BaseObject  implements Persistent {


  const PEER = 'sfEasyAuthUserPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        sfEasyAuthUserPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the username field.
	 * @var        string
	 */
	protected $username;

	/**
	 * The value for the password field.
	 * @var        string
	 */
	protected $password;

	/**
	 * The value for the email field.
	 * @var        string
	 */
	protected $email;

	/**
	 * The value for the salt field.
	 * @var        string
	 */
	protected $salt;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;

	/**
	 * The value for the last_login field.
	 * @var        string
	 */
	protected $last_login;

	/**
	 * The value for the last_login_attempt field.
	 * @var        string
	 */
	protected $last_login_attempt;

	/**
	 * The value for the failed_logins field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $failed_logins;

	/**
	 * The value for the enabled field.
	 * Note: this column has a database default value of: true
	 * @var        boolean
	 */
	protected $enabled;

	/**
	 * The value for the remember_key field.
	 * @var        string
	 */
	protected $remember_key;

	/**
	 * The value for the remember_key_lifetime field.
	 * @var        string
	 */
	protected $remember_key_lifetime;

	/**
	 * The value for the auto_login_hash field.
	 * @var        string
	 */
	protected $auto_login_hash;

	/**
	 * The value for the has_extra_credentials field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $has_extra_credentials;

	/**
	 * The value for the type field.
	 * @var        string
	 */
	protected $type;

	/**
	 * The value for the profile_id field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $profile_id;

	/**
	 * @var        array SfEasyAuthUserCredentials[] Collection to store aggregation of SfEasyAuthUserCredentials objects.
	 */
	protected $collSfEasyAuthUserCredentialss;

	/**
	 * @var        Criteria The criteria used to select the current contents of collSfEasyAuthUserCredentialss.
	 */
	private $lastSfEasyAuthUserCredentialsCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Initializes internal state of BasesfEasyAuthUser object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->failed_logins = 0;
		$this->enabled = true;
		$this->has_extra_credentials = false;
		$this->profile_id = 0;
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [username] column value.
	 * 
	 * @return     string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Get the [password] column value.
	 * 
	 * @return     string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Get the [email] column value.
	 * 
	 * @return     string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Get the [salt] column value.
	 * 
	 * @return     string
	 */
	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [last_login] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getLastLogin($format = 'Y-m-d H:i:s')
	{
		if ($this->last_login === null) {
			return null;
		}


		if ($this->last_login === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->last_login);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->last_login, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [last_login_attempt] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getLastLoginAttempt($format = 'Y-m-d H:i:s')
	{
		if ($this->last_login_attempt === null) {
			return null;
		}


		if ($this->last_login_attempt === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->last_login_attempt);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->last_login_attempt, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [failed_logins] column value.
	 * 
	 * @return     int
	 */
	public function getFailedLogins()
	{
		return $this->failed_logins;
	}

	/**
	 * Get the [enabled] column value.
	 * 
	 * @return     boolean
	 */
	public function getEnabled()
	{
		return $this->enabled;
	}

	/**
	 * Get the [remember_key] column value.
	 * 
	 * @return     string
	 */
	public function getRememberKey()
	{
		return $this->remember_key;
	}

	/**
	 * Get the [optionally formatted] temporal [remember_key_lifetime] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getRememberKeyLifetime($format = 'Y-m-d H:i:s')
	{
		if ($this->remember_key_lifetime === null) {
			return null;
		}


		if ($this->remember_key_lifetime === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->remember_key_lifetime);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->remember_key_lifetime, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [auto_login_hash] column value.
	 * 
	 * @return     string
	 */
	public function getAutoLoginHash()
	{
		return $this->auto_login_hash;
	}

	/**
	 * Get the [has_extra_credentials] column value.
	 * 
	 * @return     boolean
	 */
	public function getHasExtraCredentials()
	{
		return $this->has_extra_credentials;
	}

	/**
	 * Get the [type] column value.
	 * 
	 * @return     string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Get the [profile_id] column value.
	 * 
	 * @return     int
	 */
	public function getProfileId()
	{
		return $this->profile_id;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [username] column.
	 * 
	 * @param      string $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setUsername($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->username !== $v) {
			$this->username = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::USERNAME;
		}

		return $this;
	} // setUsername()

	/**
	 * Set the value of [password] column.
	 * 
	 * @param      string $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setPassword($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->password !== $v) {
			$this->password = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::PASSWORD;
		}

		return $this;
	} // setPassword()

	/**
	 * Set the value of [email] column.
	 * 
	 * @param      string $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setEmail($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::EMAIL;
		}

		return $this;
	} // setEmail()

	/**
	 * Set the value of [salt] column.
	 * 
	 * @param      string $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setSalt($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->salt !== $v) {
			$this->salt = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::SALT;
		}

		return $this;
	} // setSalt()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->created_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = sfEasyAuthUserPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->updated_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->updated_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = sfEasyAuthUserPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Sets the value of [last_login] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setLastLogin($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->last_login !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->last_login !== null && $tmpDt = new DateTime($this->last_login)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->last_login = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = sfEasyAuthUserPeer::LAST_LOGIN;
			}
		} // if either are not null

		return $this;
	} // setLastLogin()

	/**
	 * Sets the value of [last_login_attempt] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setLastLoginAttempt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->last_login_attempt !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->last_login_attempt !== null && $tmpDt = new DateTime($this->last_login_attempt)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->last_login_attempt = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = sfEasyAuthUserPeer::LAST_LOGIN_ATTEMPT;
			}
		} // if either are not null

		return $this;
	} // setLastLoginAttempt()

	/**
	 * Set the value of [failed_logins] column.
	 * 
	 * @param      int $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setFailedLogins($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->failed_logins !== $v || $v === 0) {
			$this->failed_logins = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::FAILED_LOGINS;
		}

		return $this;
	} // setFailedLogins()

	/**
	 * Set the value of [enabled] column.
	 * 
	 * @param      boolean $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setEnabled($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->enabled !== $v || $v === true) {
			$this->enabled = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::ENABLED;
		}

		return $this;
	} // setEnabled()

	/**
	 * Set the value of [remember_key] column.
	 * 
	 * @param      string $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setRememberKey($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->remember_key !== $v) {
			$this->remember_key = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::REMEMBER_KEY;
		}

		return $this;
	} // setRememberKey()

	/**
	 * Sets the value of [remember_key_lifetime] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setRememberKeyLifetime($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->remember_key_lifetime !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->remember_key_lifetime !== null && $tmpDt = new DateTime($this->remember_key_lifetime)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->remember_key_lifetime = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = sfEasyAuthUserPeer::REMEMBER_KEY_LIFETIME;
			}
		} // if either are not null

		return $this;
	} // setRememberKeyLifetime()

	/**
	 * Set the value of [auto_login_hash] column.
	 * 
	 * @param      string $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setAutoLoginHash($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->auto_login_hash !== $v) {
			$this->auto_login_hash = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::AUTO_LOGIN_HASH;
		}

		return $this;
	} // setAutoLoginHash()

	/**
	 * Set the value of [has_extra_credentials] column.
	 * 
	 * @param      boolean $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setHasExtraCredentials($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->has_extra_credentials !== $v || $v === false) {
			$this->has_extra_credentials = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::HAS_EXTRA_CREDENTIALS;
		}

		return $this;
	} // setHasExtraCredentials()

	/**
	 * Set the value of [type] column.
	 * 
	 * @param      string $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setType($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->type !== $v) {
			$this->type = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::TYPE;
		}

		return $this;
	} // setType()

	/**
	 * Set the value of [profile_id] column.
	 * 
	 * @param      int $v new value
	 * @return     sfEasyAuthUser The current object (for fluent API support)
	 */
	public function setProfileId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->profile_id !== $v || $v === 0) {
			$this->profile_id = $v;
			$this->modifiedColumns[] = sfEasyAuthUserPeer::PROFILE_ID;
		}

		return $this;
	} // setProfileId()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			// First, ensure that we don't have any columns that have been modified which aren't default columns.
			if (array_diff($this->modifiedColumns, array(sfEasyAuthUserPeer::FAILED_LOGINS,sfEasyAuthUserPeer::ENABLED,sfEasyAuthUserPeer::HAS_EXTRA_CREDENTIALS,sfEasyAuthUserPeer::PROFILE_ID))) {
				return false;
			}

			if ($this->failed_logins !== 0) {
				return false;
			}

			if ($this->enabled !== true) {
				return false;
			}

			if ($this->has_extra_credentials !== false) {
				return false;
			}

			if ($this->profile_id !== 0) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->username = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->password = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->email = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->salt = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->created_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->updated_at = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->last_login = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->last_login_attempt = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->failed_logins = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->enabled = ($row[$startcol + 10] !== null) ? (boolean) $row[$startcol + 10] : null;
			$this->remember_key = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->remember_key_lifetime = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			$this->auto_login_hash = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
			$this->has_extra_credentials = ($row[$startcol + 14] !== null) ? (boolean) $row[$startcol + 14] : null;
			$this->type = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
			$this->profile_id = ($row[$startcol + 16] !== null) ? (int) $row[$startcol + 16] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 17; // 17 = sfEasyAuthUserPeer::NUM_COLUMNS - sfEasyAuthUserPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating sfEasyAuthUser object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfEasyAuthUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = sfEasyAuthUserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collSfEasyAuthUserCredentialss = null;
			$this->lastSfEasyAuthUserCredentialsCriteria = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BasesfEasyAuthUser:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfEasyAuthUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			sfEasyAuthUserPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfEasyAuthUser:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BasesfEasyAuthUser:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfEasyAuthUserPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(sfEasyAuthUserPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfEasyAuthUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfEasyAuthUser:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			sfEasyAuthUserPeer::addInstanceToPool($this);
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			if ($this->isNew() ) {
				$this->modifiedColumns[] = sfEasyAuthUserPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfEasyAuthUserPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += sfEasyAuthUserPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collSfEasyAuthUserCredentialss !== null) {
				foreach ($this->collSfEasyAuthUserCredentialss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = sfEasyAuthUserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collSfEasyAuthUserCredentialss !== null) {
					foreach ($this->collSfEasyAuthUserCredentialss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfEasyAuthUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUsername();
				break;
			case 2:
				return $this->getPassword();
				break;
			case 3:
				return $this->getEmail();
				break;
			case 4:
				return $this->getSalt();
				break;
			case 5:
				return $this->getCreatedAt();
				break;
			case 6:
				return $this->getUpdatedAt();
				break;
			case 7:
				return $this->getLastLogin();
				break;
			case 8:
				return $this->getLastLoginAttempt();
				break;
			case 9:
				return $this->getFailedLogins();
				break;
			case 10:
				return $this->getEnabled();
				break;
			case 11:
				return $this->getRememberKey();
				break;
			case 12:
				return $this->getRememberKeyLifetime();
				break;
			case 13:
				return $this->getAutoLoginHash();
				break;
			case 14:
				return $this->getHasExtraCredentials();
				break;
			case 15:
				return $this->getType();
				break;
			case 16:
				return $this->getProfileId();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = sfEasyAuthUserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUsername(),
			$keys[2] => $this->getPassword(),
			$keys[3] => $this->getEmail(),
			$keys[4] => $this->getSalt(),
			$keys[5] => $this->getCreatedAt(),
			$keys[6] => $this->getUpdatedAt(),
			$keys[7] => $this->getLastLogin(),
			$keys[8] => $this->getLastLoginAttempt(),
			$keys[9] => $this->getFailedLogins(),
			$keys[10] => $this->getEnabled(),
			$keys[11] => $this->getRememberKey(),
			$keys[12] => $this->getRememberKeyLifetime(),
			$keys[13] => $this->getAutoLoginHash(),
			$keys[14] => $this->getHasExtraCredentials(),
			$keys[15] => $this->getType(),
			$keys[16] => $this->getProfileId(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfEasyAuthUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUsername($value);
				break;
			case 2:
				$this->setPassword($value);
				break;
			case 3:
				$this->setEmail($value);
				break;
			case 4:
				$this->setSalt($value);
				break;
			case 5:
				$this->setCreatedAt($value);
				break;
			case 6:
				$this->setUpdatedAt($value);
				break;
			case 7:
				$this->setLastLogin($value);
				break;
			case 8:
				$this->setLastLoginAttempt($value);
				break;
			case 9:
				$this->setFailedLogins($value);
				break;
			case 10:
				$this->setEnabled($value);
				break;
			case 11:
				$this->setRememberKey($value);
				break;
			case 12:
				$this->setRememberKeyLifetime($value);
				break;
			case 13:
				$this->setAutoLoginHash($value);
				break;
			case 14:
				$this->setHasExtraCredentials($value);
				break;
			case 15:
				$this->setType($value);
				break;
			case 16:
				$this->setProfileId($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfEasyAuthUserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUsername($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPassword($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setEmail($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSalt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLastLogin($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setLastLoginAttempt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setFailedLogins($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setEnabled($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setRememberKey($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setRememberKeyLifetime($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setAutoLoginHash($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setHasExtraCredentials($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setType($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setProfileId($arr[$keys[16]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(sfEasyAuthUserPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfEasyAuthUserPeer::ID)) $criteria->add(sfEasyAuthUserPeer::ID, $this->id);
		if ($this->isColumnModified(sfEasyAuthUserPeer::USERNAME)) $criteria->add(sfEasyAuthUserPeer::USERNAME, $this->username);
		if ($this->isColumnModified(sfEasyAuthUserPeer::PASSWORD)) $criteria->add(sfEasyAuthUserPeer::PASSWORD, $this->password);
		if ($this->isColumnModified(sfEasyAuthUserPeer::EMAIL)) $criteria->add(sfEasyAuthUserPeer::EMAIL, $this->email);
		if ($this->isColumnModified(sfEasyAuthUserPeer::SALT)) $criteria->add(sfEasyAuthUserPeer::SALT, $this->salt);
		if ($this->isColumnModified(sfEasyAuthUserPeer::CREATED_AT)) $criteria->add(sfEasyAuthUserPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(sfEasyAuthUserPeer::UPDATED_AT)) $criteria->add(sfEasyAuthUserPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(sfEasyAuthUserPeer::LAST_LOGIN)) $criteria->add(sfEasyAuthUserPeer::LAST_LOGIN, $this->last_login);
		if ($this->isColumnModified(sfEasyAuthUserPeer::LAST_LOGIN_ATTEMPT)) $criteria->add(sfEasyAuthUserPeer::LAST_LOGIN_ATTEMPT, $this->last_login_attempt);
		if ($this->isColumnModified(sfEasyAuthUserPeer::FAILED_LOGINS)) $criteria->add(sfEasyAuthUserPeer::FAILED_LOGINS, $this->failed_logins);
		if ($this->isColumnModified(sfEasyAuthUserPeer::ENABLED)) $criteria->add(sfEasyAuthUserPeer::ENABLED, $this->enabled);
		if ($this->isColumnModified(sfEasyAuthUserPeer::REMEMBER_KEY)) $criteria->add(sfEasyAuthUserPeer::REMEMBER_KEY, $this->remember_key);
		if ($this->isColumnModified(sfEasyAuthUserPeer::REMEMBER_KEY_LIFETIME)) $criteria->add(sfEasyAuthUserPeer::REMEMBER_KEY_LIFETIME, $this->remember_key_lifetime);
		if ($this->isColumnModified(sfEasyAuthUserPeer::AUTO_LOGIN_HASH)) $criteria->add(sfEasyAuthUserPeer::AUTO_LOGIN_HASH, $this->auto_login_hash);
		if ($this->isColumnModified(sfEasyAuthUserPeer::HAS_EXTRA_CREDENTIALS)) $criteria->add(sfEasyAuthUserPeer::HAS_EXTRA_CREDENTIALS, $this->has_extra_credentials);
		if ($this->isColumnModified(sfEasyAuthUserPeer::TYPE)) $criteria->add(sfEasyAuthUserPeer::TYPE, $this->type);
		if ($this->isColumnModified(sfEasyAuthUserPeer::PROFILE_ID)) $criteria->add(sfEasyAuthUserPeer::PROFILE_ID, $this->profile_id);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfEasyAuthUserPeer::DATABASE_NAME);

		$criteria->add(sfEasyAuthUserPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of sfEasyAuthUser (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUsername($this->username);

		$copyObj->setPassword($this->password);

		$copyObj->setEmail($this->email);

		$copyObj->setSalt($this->salt);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setLastLogin($this->last_login);

		$copyObj->setLastLoginAttempt($this->last_login_attempt);

		$copyObj->setFailedLogins($this->failed_logins);

		$copyObj->setEnabled($this->enabled);

		$copyObj->setRememberKey($this->remember_key);

		$copyObj->setRememberKeyLifetime($this->remember_key_lifetime);

		$copyObj->setAutoLoginHash($this->auto_login_hash);

		$copyObj->setHasExtraCredentials($this->has_extra_credentials);

		$copyObj->setType($this->type);

		$copyObj->setProfileId($this->profile_id);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getSfEasyAuthUserCredentialss() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addSfEasyAuthUserCredentials($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     sfEasyAuthUser Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     sfEasyAuthUserPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new sfEasyAuthUserPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collSfEasyAuthUserCredentialss collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addSfEasyAuthUserCredentialss()
	 */
	public function clearSfEasyAuthUserCredentialss()
	{
		$this->collSfEasyAuthUserCredentialss = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collSfEasyAuthUserCredentialss collection (array).
	 *
	 * By default this just sets the collSfEasyAuthUserCredentialss collection to an empty array (like clearcollSfEasyAuthUserCredentialss());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initSfEasyAuthUserCredentialss()
	{
		$this->collSfEasyAuthUserCredentialss = array();
	}

	/**
	 * Gets an array of SfEasyAuthUserCredentials objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this sfEasyAuthUser has previously been saved, it will retrieve
	 * related SfEasyAuthUserCredentialss from storage. If this sfEasyAuthUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array SfEasyAuthUserCredentials[]
	 * @throws     PropelException
	 */
	public function getSfEasyAuthUserCredentialss($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(sfEasyAuthUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSfEasyAuthUserCredentialss === null) {
			if ($this->isNew()) {
			   $this->collSfEasyAuthUserCredentialss = array();
			} else {

				$criteria->add(SfEasyAuthUserCredentialsPeer::USER_ID, $this->id);

				SfEasyAuthUserCredentialsPeer::addSelectColumns($criteria);
				$this->collSfEasyAuthUserCredentialss = SfEasyAuthUserCredentialsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(SfEasyAuthUserCredentialsPeer::USER_ID, $this->id);

				SfEasyAuthUserCredentialsPeer::addSelectColumns($criteria);
				if (!isset($this->lastSfEasyAuthUserCredentialsCriteria) || !$this->lastSfEasyAuthUserCredentialsCriteria->equals($criteria)) {
					$this->collSfEasyAuthUserCredentialss = SfEasyAuthUserCredentialsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSfEasyAuthUserCredentialsCriteria = $criteria;
		return $this->collSfEasyAuthUserCredentialss;
	}

	/**
	 * Returns the number of related SfEasyAuthUserCredentials objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related SfEasyAuthUserCredentials objects.
	 * @throws     PropelException
	 */
	public function countSfEasyAuthUserCredentialss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(sfEasyAuthUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collSfEasyAuthUserCredentialss === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(SfEasyAuthUserCredentialsPeer::USER_ID, $this->id);

				$count = SfEasyAuthUserCredentialsPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(SfEasyAuthUserCredentialsPeer::USER_ID, $this->id);

				if (!isset($this->lastSfEasyAuthUserCredentialsCriteria) || !$this->lastSfEasyAuthUserCredentialsCriteria->equals($criteria)) {
					$count = SfEasyAuthUserCredentialsPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collSfEasyAuthUserCredentialss);
				}
			} else {
				$count = count($this->collSfEasyAuthUserCredentialss);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a SfEasyAuthUserCredentials object to this object
	 * through the SfEasyAuthUserCredentials foreign key attribute.
	 *
	 * @param      SfEasyAuthUserCredentials $l SfEasyAuthUserCredentials
	 * @return     void
	 * @throws     PropelException
	 */
	public function addSfEasyAuthUserCredentials(SfEasyAuthUserCredentials $l)
	{
		if ($this->collSfEasyAuthUserCredentialss === null) {
			$this->initSfEasyAuthUserCredentialss();
		}
		if (!in_array($l, $this->collSfEasyAuthUserCredentialss, true)) { // only add it if the **same** object is not already associated
			array_push($this->collSfEasyAuthUserCredentialss, $l);
			$l->setsfEasyAuthUser($this);
		}
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collSfEasyAuthUserCredentialss) {
				foreach ((array) $this->collSfEasyAuthUserCredentialss as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collSfEasyAuthUserCredentialss = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfEasyAuthUser:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfEasyAuthUser::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BasesfEasyAuthUser
