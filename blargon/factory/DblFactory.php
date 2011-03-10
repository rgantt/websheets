<?
package('blargon.factory');

import('blargon.jdbl.DblException');
import('blargon.jdbl.DataLayer');

class DblFactory
{
	static $init = false;
	static $info = array();
	static $conn;
	
	public static function loadUp( $info, $driver )
	{
		self::$info['connect'] = $info;
		self::$info['driver'] = $driver;
	}
	
	private static function init()
	{
		try
		{
			self::$conn = new DataLayer( self::$info['driver'] );	
			self::$conn->doConnect( self::$info['connect'] );
			self::$conn->selectDatabase( self::$info['connect']['base'] );
		}
		catch( DblException $e )
		{
			echo $e->getMessage();
		}
	}
	
	public static function getConn()
	{
		if( !self::$init )
		{
			self::init();
		}
		return self::$conn;
	}
}
?>
