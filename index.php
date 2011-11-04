<?php
use blargon\display\Panel;
use blargon\display\Includes;
use blargon\display\News;
use blargon\messages\MessageStack;
use blargon\util\FrontController;
use blargon\user\UserStatus;

require_once dirname(__FILE__).'/config.php';

/** ROCK-SOLID AUTHENTICATION */
if( isset( $_COOKIE['uName'] ) ) {
	$include = new Includes();
	$panel = new Panel();
	$messageStack = new MessageStack();
	$user = new UserStatus();
	
	$user->checkStatus( $messageStack );
	
	FrontController::setHeader( $include->head() );
	FrontController::setPanel( $panel->showPanel() );
	FrontController::setFooter( $include->footer( null ) );
	FrontController::run( $messageStack );
} else {
	header('Location: login.php');
}