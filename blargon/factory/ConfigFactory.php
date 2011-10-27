<?php
namespace blargon\factory;

use blargon\util\Configuration;
use \PDO;
use \PDOException;

class ConfigFactory {
	static $conf = false;
	static $db = null;
	
	private static function init() {
		if( !( self::$db instanceof PDO ) ) {
			throw new PDOException("Cannot initialize configuration without a data object");
		} else {
			self::$conf = new Configuration( self::$db );
		}
	}
	
	public static function setDb( PDO $db ) {
		self::$db = $db;
		self::init();
	}
	
	public static function getConfig() {
		if( self::$conf === false ) {
			self::init();
		}
		return self::$conf;
	}
}