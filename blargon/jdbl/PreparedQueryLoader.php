<?
package('blargon.jdbl');

import('blargon.factory.ConfigFactory');
import('blargon.exception.QueryNotFoundException');

class PreparedQueryLoader
{
	protected $config;
	protected $class;
	protected $method;
	
	protected $queryTable;
	
	public function __construct( $class, $method )
	{
		$this->config = ConfigFactory::getConfig();
		$this->class = $class;
		$this->method = $method;
		
		$this->loadMethodQueries( $this->config->get('installDir') );
	}
	
	public function loadMethodQueries()
	{
		require 'include/queries/'.$this->class.'/'.$this->method.'.php';
		$this->queryTable =& $q;
	}
	
	public function getQueryByKey( $key )
	{
		if( $this->queryTable[ $key ] )
		{
			return ( string ) $this->queryTable[ $key ];
		}
		throw new QueryNotFoundException('Could not find query for method '.$this->method.' with key '.$key.'!');
	}
}
?>
