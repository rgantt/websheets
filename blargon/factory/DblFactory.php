<?php
namespace blargon\factory;

use blargon\jdbl\DblException;
use blargon\jdbl\DataLayer;

class DblFactory {
	private static $handle = null;
	private static $conn = null;
	
	public static function getConn() {
		if( is_null( self::$conn ) ) {
			self::init();
		}
		return self::$conn;
	}
	
	public static function load( $handle ) {
		self::$handle = $handle;
	}
	
	private static function init() {
		try {
			self::$conn = new DataLayer( self::$handle );	
		} catch( DblException $e ) {
			echo $e->getMessage();
		}
	}
}