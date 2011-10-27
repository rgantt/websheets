<?php
namespace blargon\util;

use blargon\factory\DblFactory;
use \PDO;

class Configuration {
	private $db;
	private $cache = array();
	
	public function __construct( PDO $db ) {
		$this->db = $db;
		$this->hardCache();
		$this->cache();
	}
	
	public function hardCache() {
		global $prefix, $language, $version, $sedai;
		$this->cache['prefix'] = $prefix;
		$this->cache['language'] = $language;
		$this->cache['version'] = $version;
		$this->cache['template_dir'] = $sedai['includeDir'];
	}
	
	public function cache() {
		$query = $this->db->query( 'select * from '.$this->cache['prefix'].'_config' );
		while( $row = $query->fetchObject() ) {
			$this->cache[ strtolower( $row->entry ) ] = $row->value;
		}
	}
	
	function set( $name, $value ) {
		return $this->db->query( 'update '.$this->cache['prefix'].'_config set value = \''.$value.'\' where entry = \''.$name.'\'' );
	}
	
	function get( $name ) {
		if( isset( $this->cache[ strtolower( $name ) ] ) ) {
			return $this->cache[ strtolower( $name ) ];
		}
		return '';
	}
}