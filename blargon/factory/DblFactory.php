<?php
namespace blargon\factory;

use blargon\jdbl\DblException;
use blargon\jdbl\DataLayer;

class DblFactory {
	static $info = array();
	static $conn = null;
	
	public static function getConn() {
		if( is_null( self::$conn ) ) {
			self::init();
		}
		return self::$conn;
	}
	
	public static function loadUp( $info, $driver ) {
		self::$info['connect'] = $info;
		self::$info['driver'] = $driver;
	}
	
	private static function init() {
		try {
			self::$conn = new DataLayer( self::$info['driver'] );	
			self::$conn->doConnect( self::$info['connect'] );
			self::$conn->selectDatabase( self::$info['connect']['base'] );
		} catch( DblException $e ) {
			echo $e->getMessage();
		}
	}
}