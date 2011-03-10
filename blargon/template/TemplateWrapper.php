<?
package('blargon.template');

import('sedai.*');

class TemplateWrapper
{
	private $sedai;
	public $variable;
	
	public function __construct( $name )
	{
		$this->sedai = new Sedai( $name );
	}
	
	public function setClass( $class )
	{
		$this->sedai->setClass( $class );
	}
	
	public function setMethod( $method )
	{
		$this->sedai->setMethod( $method );
		return $this->createReplacer();
	}
	
	public function addVariable( $key, $value )
	{
		$this->variable[ $key ] = $value;
	}
	
	public function addVariables( $values )
	{
		foreach( $values as $key => $value )
		{
			$this->addVariable( $key, $value );
		}
	}
	
	public function createParser()
	{
		return $this->sedai->templateParser();
	}
	
	public function createReplacer()
	{
		$parser = $this->sedai->templateParser();
		$b = $this->sedai->templateReplacer( $parser );
		if( is_array( $this->variable ) )
		{
			foreach( $this->variable as $key => $value )
			{
				$b->addVariable( $key, $value );
			}
		}
		return $b;
	}
	
	public function createViewer( SedaiReplacer $replacer )
	{
		$replacer->replace();
		return $replacer->view();
	}
}
?>
