<?php
package('sedai.helper');

import('sedai.helper.Helper');

class VariableHelper extends Helper
{
	protected $vars = array();
	
	public function getInstance()
	{ 
		$this->vars = array(); 
	}
	
	public function set( $key, $value )
	{
		$this->vars[ $key ] = $value;
	}
	
	public function get( $key )
	{
		if( isset( $this->vars[ $key ] ) )
		{
			return $this->vars[ $key ];
		}
	}
}