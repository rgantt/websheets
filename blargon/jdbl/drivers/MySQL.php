<?php
namespace blargon\jdbl\drivers;

use japhax\sql\Database;

/**
* $Id: MySQL.php,v 1.1.1.1 2005/07/06 17:28:53 blargon Exp $
*
* This is the database layer that will definately see the most use throughout the users of the script.
* It contains all of the major functions that php has for mysql databases, and should be more than
* adequate for our needs
*
* @author Ryan Gantt
* @version $Revision: 1.1.1.1 $ $Date: 2005/07/06 17:28:53 $
*/
class MySQL extends Database {
	/**
	* The current command for MySQL. Changes with every method call
	*
	* @var
	*/
	protected $queryString;
	protected $linkId;
	protected $resultId;

	/**
	* Constructor does nothing but call an existing method to connect.
	*
	* @param host hostname of the database
	* @param user username for the database
	* @param pass password for the database
	* @access public
	*/
	function __construct(){}

	/**
	* Initiates the connection to a mysql database.
	*
	* @param host hostname for mysql connection. 'localhost' is fine in most cases
	* @param user username for mysql connection.
	* @param pass password for mysql connection.
	* @return boolean true iff the connection was successful
	* @exception DatabaseException::CouldNotConnect if connection is unsuccessful
	* @access public
	*/
	function connect( $login = array() ) {
		$linkId = mysql_connect( $login['host'], $login['user'], $login['pass'] );
		if( $linkId ) {
			$this->linkId = $linkId;
			return $this->linkId;
		} else {
			return false;
		}
	}

	/**
	* Selects a MySQL database to work with
	*
	* @param dbName the name of the database
	* @return boolean true if the database was successfully selected
	* @exception DatabaseException::SelectDatabase if the database was unsuccessful in being selected
	* @access public
	*/
	function select_db( $dbName ) {
		if(mysql_select_db($dbName, $this->linkId)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Run a query command on the database
	*
	* @param query the command query to execute on the database
	* @return queryId if the command was legally and successfully executed on the database
	* @exception DatabaseException::BadQueryString if the query is unescaped or otherwise unacceptable for database use
	* @access public
	*/
	function query( $query ) {
		$queryId = mysql_query( $query, $this->linkId ) or die(mysql_error());
		if( !$queryId ) {
			return false;
		} else {
			$this->resultId = $queryId;
			return $queryId;
		}
	}

	/**
	* Unset, Unlink, Destroy, Delete (Gets rid of) a MySQL database connection
	*
	* @param linkId the connection to close, defaults to the default connection
	* @access public
	*/
	function close() {
		return mysql_close( $this->linkId );
	}

	// apparently this does in fact return only one row at a time
	function fetch_object( $query ) {
		return mysql_fetch_object( $query );
	}

	function fetch_row( $query ) {
		return mysql_fetch_row( $query );
	}

	/**
	* Count the number of result rows generated by a mysql query command
	*
	* @param query the command to execute that will generate rows (hopefully, if its a legal string)
	* @return int the number of result rows
	* @exception DatabaseException::GetNumRows if for some reason the query string is illegal or we can't access mysql_* functions for some reason
	* @access public
	*/
	function num_rows( $query ) {
		return mysql_num_rows( $query );
	}

	function fetch_array( $query ) {
		return;
	}

	function num_fields() {
		return;
	}

	function get_error() {
		return mysql_error( $this->linkId );
	}

	function get_connection() {
		return $this->linkId;
	}
}