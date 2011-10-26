<?php
package('sedai.replacer');

import('sedai.helper.*');

class SedaiReplacer
{
	protected $haystack;
	protected $helper;
	protected $format;
	
	protected $class;
	protected $method;
	
	protected $variables = array();
	
	protected $replaces = array();
	
	public function __construct( $haystack, $format )
	{
		$this->haystack = $haystack;
		$this->format = $format;
	}
	
	public function setClass( $class )
	{
		$this->class = $class;
	}
	
	public function setMethod( $method )
	{
		$this->method = $method;
	}
	
	public function getHaystack()
	{
		return $this->haystack;
	}
	
	public function setHaystack( $haystack )
	{
		$this->haystack = $haystack;
	}
	
	public function addVariable( $name, $value )
	{
		$this->variables[ $name ] = $value;
	}
	
	public function addVariables( $vars )
	{
		foreach( $vars as $key => $value )
		{
			$this->addVariable( $key, $value );
		}
	}
	
	public function getHelper( $type )
	{
		switch( $type )
		{
			case 'config':
				return new ConfigHelper();
				break;
			case 'lang':
				return new LanguageHelper( $this->class, $this->method );
				break;
			case 'var':
				$vh = new VariableHelper();
				foreach( $this->variables as $key => $value )
				{
					$vh->set( $key, $value );
				}
				return $vh;
				break;
			case 'user':
				return new UserHelper();
				break;
		}
	}
	
	public function addReplace( $cmd )
	{
		$this->replaces[] = $cmd;
	}
	
	public function replace()
	{
		foreach( $this->replaces as $cmd )
		{
			$str = str_replace( $this->format[0], '', $cmd );
			$str = str_replace( $this->format[2], ':', $str );
			$method = explode( ':', $str ); // method0 for obj, method1 for key
			$this->setHaystack( str_replace( $cmd.$this->format[4], $this->getHelper( $method[0] )->get( $method[1] ), $this->getHaystack() ) );
		}
		return $this;
	}
	
	public function view()
	{
		return $this->getHaystack();
	}
}