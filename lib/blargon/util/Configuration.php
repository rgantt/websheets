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
		global $connect, $language, $version, $sedai;
		$this->cache['prefix'] = $connect['prefix'];
		$this->cache['language'] = $language;
		$this->cache['version'] = $version;
		$this->cache['template_dir'] = $sedai['includeDir'];
	}
	
	public function cache() {
		$query = $this->db->query( 'select * from '.$this->get('prefix').'_config' );
		while( $row = $query->fetchObject() ) {
			$this->cache[ strtolower( $row->entry ) ] = $row->value;
		}
	}
	
	public function set( $name, $value ) {
		return $this->db->query( 'update '.$this->cache['prefix'].'_config set value = \''.$value.'\' where entry = \''.$name.'\'' );
	}
	
	public function get( $name ) {
		if( isset( $this->cache[ strtolower( $name ) ] ) ) {
			return $this->cache[ strtolower( $name ) ];
		}
		return '';
	}
}