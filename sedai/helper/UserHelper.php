<?php
package('sedai.helper');

import('sedai.helper.Helper');

class UserHelper extends Helper
{
	private $user;
	
	public function getInstance()
	{ 
		$this->user = UserFactory::getUser( $_COOKIE['uName'], md5( $_COOKIE['pass'] ) );
	}
	
	public function set( $key, $value )
	{
		$method = 'set'.ucfirst( $key );
		$this->user->$method( $value );
	}
	
	public function get( $key )
	{
		$method = 'get'.ucfirst( $key );
		return $this->user->$method();
	}
}