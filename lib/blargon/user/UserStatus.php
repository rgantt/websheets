<?php
namespace blargon\user;

use blargon\factory\DblFactory;
use blargon\factory\ConfigFactory;
use blargon\messages\MessageStack;

class UserStatus {
	private $db;
	private $config;
	
	public function __construct() {
		$this->db = DblFactory::getConn();
		$this->config = ConfigFactory::getConfig();
	}
	
	public function checkStatus( MessageStack $stack ) {
		$this->checkAttempts( $stack );
	}
	
	public function checkAttempts( MessageStack $stack ) {
		$query = $this->db->query('select distinct userId from '.$this->config->get('prefix').'_attempts where userId > 0');
		while( $row = $query->fetchObject() ) {
			$attempts = $this->db->query( 'select id from '.$this->config->get('prefix').'_attempts where userId=\''.$row->userId.'\'' )->rowCount();
			if( $attempts >= $this->config->get('maxAttempts') ) {
				$name = $this->db->query( 'select user from '.$this->config->get('prefix').'_user where id=\''.$row->userId.'\'' )->fetchObject();
				$stack->push( new Message( $name->user.'\'s account is currently locked from attempting too many false logins.', 3 ) );
			}
		}
	}
}