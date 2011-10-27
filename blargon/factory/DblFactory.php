<?php
namespace blargon\factory;

use blargon\jdbl\DataLayer;
use \PDO;
use \PDOException;

class DblFactory {
	private static $param = null;
	private static $conn = null;
	
	public static function getConn() {
		if( is_null( self::$conn ) ) {
			self::init();
		}
		return self::$conn;
	}
	
	public static function load( $connect ) {
		self::$param = $connect;
	}
	
	private static function init() {
		try {
			self::$conn = new PDO("mysql:host=".self::$param['host'].";dbname=".self::$param['base'], self::$param['user'], self::$param['pass'] );	
		} catch( PDOException $e ) {
			echo $e->getMessage();
		}
	}
}