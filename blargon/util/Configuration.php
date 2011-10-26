<?php
package('blargon');

import('blargon.factory.DblFactory');

class Configuration
{
	private $db;
	private $cache = array();
	
	public function __construct()
	{
		$this->db = DblFactory::getConn();
		$this->hardCache();
		$this->cache();
	}
	
	public function hardCache()
	{
		global $prefix, $language, $version, $blargonUrl;
		$this->cache['prefix'] = $prefix;
		$this->cache['language'] = $language;
		$this->cache['version'] = $version;
		$this->cache['blargonUrl'] = $blargonUrl;
	}
	
	public function cache()
	{
		$query = $this->db->query( 'select * from '.$this->cache['prefix'].'_config' );
		while( $row = $this->db->fetchObject( $query ) )
		{
			$this->cache[ strtolower( $row->entry ) ] = $row->value;
		}
	}
	
	function set( $name, $value )
	{
		return $this->db->query( 'update '.$this->cache['prefix'].'_config set value = \''.$value.'\' where entry = \''.$name.'\'' );
	}
	
	function get( $name )
	{
		if( isset( $this->cache[ strtolower( $name ) ] ) )
		{
			return $this->cache[ strtolower( $name ) ];
		}
		return '';
	}
}