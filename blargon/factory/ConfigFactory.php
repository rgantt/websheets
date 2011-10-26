<?php
namespace blargon\factory;

use blargon\util\Configuration;

class ConfigFactory {
	static $conf = false;
	
	private static function init() {
		self::$conf = new Configuration();
	}
	
	public static function getConfig() {
		if( self::$conf === false ) {
			self::init();
		}
		return self::$conf;
	}
}