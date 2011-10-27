<?php
package('blargon.messages');

import('japha.lang.StringBuffer');

class Message
{
	protected $message;
	protected $minLevel;
	
	public function __construct( $message, $min )
	{
		$this->message = new StringBuffer( $message );
		$this->minLevel = $min;
	}
	
	public function setMessage( $message )
	{
		$this->message = new StringBuffer( $message );
	}
	
	public function getMessage()
	{
		return $this->message;
	}
	
	public function setMinLevel( $level )
	{
		$this->minLevel = $level;
	}
	
	public function getMinLevel()
	{
		return $this->minLevel;
	}
}