<?php
namespace sedai\helper;

use blargon\factory\ConfigFactory;

class ConfigHelper extends Helper {
	protected $instance;
	
	public function __construct() {
		$this->getInstance();
	}
	
	public function getInstance() {
		$this->instance = ConfigFactory::getConfig();
	}
	
	public function get( $key ) {
		return $this->instance->get( $key );
	}
}