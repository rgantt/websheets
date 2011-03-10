<?
package('blargon.class');

import('japha.lang.Class');
import('blargon.jdbl.DblException');
import('blargon.jdbl.drivers.*');

/**
 * $Id: DataLayer.php,v 1.1.1.1 2005/07/06 17:28:53 blargon Exp $
 *
 * Wrapper class for database drivers... Ensures that we don't call functions 
 * that the drivers don't have
 *
 * All member variables are private, since this is the class that should be
 * called to take care of all database functions.
 *
 * @author Ryan Gantt
 * @version $Revision: 1.1.1.1 $
 */
class DataLayer
{
	/**
	 * Name of the driver, so that it could potentially be changed
	 * dynamically by 1) updating the name 2) sparking a function that
	 * checks the current data source against the name and makes the switch
	 *
	 * @private
	 */
	private $driverName;
	
	/**
	 * Instance of Database which is specific to a certain DBMS.
	 *
	 * @private
	 */
	private $driverInstance;
	
	/**
	 * Construtor -- takes a driver name as the paramater and tries to create
	 * a new instance of that driver to use throughout the class.
	 *
	 * @throws DblException If there is an invalid driver or the driver can't connect
	 * @param driver The name of the driver, defaults to bl-MySQL
	 */
	public function __construct( $driver = 'bl-MySQL' )
	{
		$parts = explode( '-', $driver );
		try
		{
			$this->createDriver( $parts[1] );
		}
		catch( DblException $e )
		{
			throw $e;
		}
	}
	
	/**
	 * Uses japha reflection to create a new instance of the database driver
	 * class.
	 *
	 * @throws DblException When there is an error creating the driver
	 * @param driverName the Classname of the driver
	 */
	function createDriver( $driverName )
	{
		if( class_exists( $driverName ) )
		{
			$cls = _Class::forName( $driverName );
			$ct = $cls->getConstructor();
			$this->driverInstance = $ct->newInstance();
		}
		else
		{
			throw new DblException('Could not create a new instance of the database driver');
		}
	}
	
	/**/
	/**/
	/* Wrapper functions for the database drivers */
	/**/
	/**/
	
	function driverInfo()
	{
		return $this->driverInstance->driver_info();
	}
	
	function doConnect( $info = array() )
	{
		return $this->driverInstance->connect( $info );
	}
	
	function selectDatabase( $dbName )
	{
		return $this->driverInstance->select_db( $dbName );
	}
	
	function query( $query, $conn = '' )
	{
		return $this->driverInstance->query( $query );
	}
	
	function numRows( $query )
	{
		return $this->driverInstance->num_rows( $query );
	}
	
	function fetchObject( $query )
	{
		return $this->driverInstance->fetch_object( $query );
	}
	
	function getConnection()
	{
		return $this->driverInstance->get_connection();
	}
	
	function getError()
	{
		return $this->driverInstance->get_error();
	}
}
?>