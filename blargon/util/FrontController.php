<?php
import('blargon.util.PageContent');

import('blargon.command.*');

class FrontController
{
	static $header;
	static $panel;
	static $footer;
	
	public static function setHeader( $header )
	{
		self::$header = $header;
	}
	
	public static function setPanel( $panel )
	{
		self::$panel = $panel;
	}
	
	public static function setFooter( $footer )
	{
		self::$footer = $footer;
	}
	
	public static function run( MessageStack $stack, $language )
	{
		// Class will be in the format of <something>Command, like CategoryCommand
		$class = ucfirst( ( isset( $_GET['go'] ) && ( $_GET['go'] != null ) ) ? $_GET['go'] : 'board' ).'Command';
		$method = ( isset( $_GET['page'] ) ? $_GET['page'] : 'show' );
		
		$command = new $class( $method, $stack, $language );
		$command->execute();
		$view = $command->getView();
		$view->setHeader( self::$header );
		$view->setPanel( self::$panel );
		$messages = ( ( $stack->isEmpty() ) ? null : $view->messageViewer( $stack ) );
		$view->setMessages( $messages );
		$view->setFooter( self::$footer );
		$view->render();
	}
}