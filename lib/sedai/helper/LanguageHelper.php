<?php
namespace sedai\helper;

use blargon\lang\Language;

class LanguageHelper {
	private $class;
	private $method;
	private $instance;
	
	public function __construct( $class, $method ) {
		$this->class = $class;
		$this->method = $method;
		$this->getInstance();
	}
	
	public function getInstance() {
		if( $this->instance === null ) {
			$this->instance = new Language( $this->class );
		}
		return $this->instance;
	}
	
	public function get( $key ) {
		return $this->instance->message( $this->method, $key );
	}
}