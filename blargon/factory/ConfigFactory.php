<?
package('blargon.factory');

import('blargon.util.Configuration');

class ConfigFactory
{
	static $init = false;
	static $conf;
	
	private static function init()
	{
		self::$conf = new Configuration();
	}
	
	public static function getConfig()
	{
		if( !self::$init )
		{
			self::init();
		}
		return self::$conf;
	}
}
?>
