<?php
namespace blargon\lang;

use blargon\display\ConfigFactory;

class Language {
	protected $lang;
	protected $class;
	
	public function __construct( $class ) {
		$class = end( explode( '\\', $class ) );
		require dirname(__FILE__).'/../../../include/language/'.strtolower( $class ).'.php';
		$this->class = $class;
		$this->lang = $lang;
		$this->init();
	}
	
	private function init() {
		if( is_array( $this->lang ) ) {
			foreach( $this->lang as $key => $value ) {
				$this->$key = $value;
			}
		} else {
			throw new Exception('Could not load language information from language/'.strtolower( $this->class ).'.php, the file does not contain a language array.');
		}
	}
	
	private function getText( $type, $method, $key ) {
		if( isset( $this->{ $method }[ $type ][ $key ] ) ) {
			return $this->{ $method }[ $type ][ $key ];
		} else {
			return 'An error occurred.';
		}		
	}
	
	public function message( $method, $key ) {
		return $this->getText( 'message', $method, $key );
	}
	
	public function success( $method, $key ) {
		return $this->getText( 'success', $method, $key );
	}
	
	public function failure( $method, $key ) {
		return $this->getText( 'failure', $method, $key );
	}
	
	public function replaceGlobals( $text ) {
		require 'language/global.php';
		if( is_array( $global ) ) {
			foreach( $global as $var ) {
				foreach( $var as $key => $value ) {
					$text = str_ireplace( $key, $value, $text );
				}
			}
		} else {
			throw new Exception('Could not load language information from language/global.php, the file does not contain a language array.');
		}
		return $text;
	}
}