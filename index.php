<?php
use blargon\factory\DblFactory;
use blargon\display\Panel;
use blargon\display\Includes;
use blargon\display\News;
use blargon\messages\MessageStack;
use blargon\lang\Language;
use blargon\util\FrontController;
use blargon\factory\ConfigFactory;
use blargon\user\UserStatus;

require_once dirname(__FILE__).'/config.php';

$db = DblFactory::getConn();
ConfigFactory::setDb( $db );

// is this language stuff really necessary?
$language = News::getClientLanguage();
if( $_COOKIE['bl_lang'] != $language ) {
	setcookie( 'bl_lang', $language );
	header('Location: index.php');
}

// whoa, not actually authenticating here
if( isset( $_COOKIE['uName'] ) ) {
	$include = new Includes( $language );
	$panel = new Panel( $language );
	
	$messageStack = new MessageStack();
	
	$user = new UserStatus();
	$user->checkStatus( $messageStack );
	
	FrontController::setHeader( $include->head() );
	FrontController::setPanel( $panel->showPanel() );
	FrontController::setFooter( $include->footer( null ) );
	FrontController::run( $messageStack, $language );
} else {
	header('Location: login.php');
}