<?php
namespace blargon\user;

use blargon\factory\DblFactory;

/**
 * As of right now, there are no member variables in this class -- they are
 * all written to and read from the database on command. I'm not sure if this
 * is the best way to do it -- it might be more wise to read/write them only
 * every n calls.
 */
abstract class User {
	protected $db;
	
	protected $user;
	protected $pass;
	
	private $prefix;
	
	public function __construct( $name, $pass ) {
		global $prefix;
		$this->prefix = $prefix;
		$this->db = DblFactory::getConn();
		$this->user = $name;
		$this->pass = $pass;
	}
	
	private function doRead( $field ) {
		$result = $this->db->fetchObject( $this->db->query( 'select '.$field.' from '.$this->prefix.'_user where user=\''.$this->user.'\' and pass=\''.$this->pass.'\'' ) );
		return $result->$field;
	}
	
	private function doWrite( $field, $value ) {
		return $this->db->query( 'update '.$this->prefix.'_user set '.$field.' = \''.$value.'\' where user=\''.$this->user.'\' and pass=\''.$this->pass.'\'' );
	}
	
	public function setPass( $pass ) {
		$this->doWrite( 'password', md5( $pass ) );
		$this->pass = md5( $pass );
	}
	
	public function getPass() {
		return $this->pass;
	}
	
	public function getUser() {
		return $this->user;
	}
	
	public function getId() {
		return $this->doRead('id');
	}
	
	public function getLevel() {
		return $this->doRead('userLevel');
	}
	
	public function getAlias() {
		return $this->doRead('alias');
	}
	
	public function getEmail() {
		return $this->doRead('email');
	}
	
	public function getTitle() {
		return $this->doRead('title');
	}
	
	public function getAvatar() {
		return $this->doRead('avatar');
	}
	
	public function setLevel( $level ) {
		return $this->doWrite( 'userLevel', $level );
	}
	
	public function setAlias( $alias ) {
		return $this->doWrite( 'alias', $alias );
	}
	
	public function setEmail( $email ) {
		return $this->doWrite( 'email', $email );
	}
	
	public function setTitle( $title ) {
		return $this->doWrite( 'title', $title );
	}
	
	public function setAvatar( $avatar ) {
		return $this->doWrite( 'avatar', $avatar );
	}
}