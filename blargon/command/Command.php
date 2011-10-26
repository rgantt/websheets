<?php
package('blargon.command');

abstract class Command
{
	protected $page;
	protected $method;
	protected $class;
	protected $stack;
	
	public function __construct( $method, MessageStack $stack, $language )
	{
		$this->method = $method;
		$this->stack = $stack;
		$this->page = new StringBuffer();
		$this->init( $language );
	}
	
	public function execute()
	{
		try
		{
			$this->page->append( $this->class->{ $this->method }() );
		}
		catch( Exception $e )
		{
			$this->stack->push( new Message( '<span style="color:red;">'.$e->getMessage().'</span>', 1 ) );
		}
	}
	
	public function getView()
	{
		return new PageContent( $this->page->toString() );
	}
	
	abstract public function init( $lang );
}