<?
package('sedai.helper');

import('blargon.lang.Language');

class LanguageHelper
{
	private $class;
	private $method;
	
	public function __construct( $class, $method )
	{
		$this->class = $class;
		$this->method = $method;
		$this->getInstance();
	}
	
	public function getInstance()
	{
		$this->instance = new Language( $_COOKIE['bl_lang'], $this->class );
	}
	
	public function get( $key )
	{
		return $this->instance->message( $this->method, $key );
	}
}
?>
