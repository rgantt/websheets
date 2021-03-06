<?php
namespace blargon\util;

use blargon\messages\MessageStack;

class FrontController {
	static $header;
	static $panel;
	static $footer;
	
	public static function setHeader( $header ) {
		self::$header = $header;
	}
	
	public static function setPanel( $panel ) {
		self::$panel = $panel;
	}
	
	public static function setFooter( $footer ) {
		self::$footer = $footer;
	}
	
	public static function run( MessageStack $stack ) {
		// Class will be in the format of <something>Command, like CategoryCommand
		$class = "blargon\command\\".ucfirst( ( isset( $_GET['go'] ) && ( $_GET['go'] != null ) ) ? $_GET['go'] : 'news' ).'Command';
		$method = ( isset( $_GET['page'] ) ? $_GET['page'] : 'show' );
		if( !isset( $_GET['go'] ) || !$_GET['go'] ) $method = 'edit'; // default page is news::edit
		
		$command = new $class( $method, $stack );
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