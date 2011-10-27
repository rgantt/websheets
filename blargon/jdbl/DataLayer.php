<?php
namespace blargon\jdbl;

use japha\lang\_Class;
use blargon\jdbl\DblException;
use blargon\jdbl\drivers\MySQL;
use \PDO;
use \PDOStatement;

/**
 * Wrapper class for database drivers... Ensures that we don't call functions 
 * that the drivers don't have
 *
 * All member variables are private, since this is the class that should be
 * called to take care of all database functions.
 */
class DataLayer {
	/**
	 * Instance of PDO which is specific to a certain DBMS.
	 */
	private $driverInstance;
	
	/**
	 * Construtor -- takes a driver name as the paramater and tries to create
	 * a new instance of that driver to use throughout the class.
	 *
	 * @throws DblException If there is an invalid driver or the driver can't connect
	 * @param driver The name of the driver, defaults to bl-MySQL
	 */
	public function __construct( PDO $conn ) {
		$this->driverInstance = $conn;
	}
	
	/**
	 * Uses japha reflection to create a new instance of the database driver
	 * class.
	 *
	 * @throws DblException When there is an error creating the driver
	 * @param driverName the Classname of the driver
	 */
	function createDriver( $driverName ) {
		// don't call autoload if we can't find it
		if( class_exists( $driverName ) ) {
			$cls = _Class::forName( $driverName );
			$ct = $cls->getConstructor();
			$this->driverInstance = $ct->newInstance();
		} else {
			throw new DblException('Could not create a new instance of the database driver');
		}
	}
	
	function driverInfo() {
		return $this->driverInstance->driver_info();
	}
	
	function query( $queryString ) {
		return $this->driverInstance->query( $queryString );
	}
	
	function numRows( PDOStatement $query ) {
		return $query->rowCount();
	}
	
	function fetchObject( PDOStatement $query ) {
		return $query->fetchObject();
	}
	
	function getConnection() {
		return $this->driverInstance;
	}
	
	function getError() {
		return $this->driverInstance->errorInfo();
	}
}