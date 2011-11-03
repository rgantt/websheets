<?php
/** Database configuration */
$connect = array(
	'host' => 'localhost',
	'user' => 'root', 
	'pass' => '',
	'base' => 'websheets',
	'prefix' => 'websheets'
);

/* DO NOT modify anything below this line */
use blargon\factory\DblFactory;
use blargon\factory\ConfigFactory;

$sedai = array(
	'includeDir' => 'include/view', // all templates will be loaded from this directory by default
	'format' => '{@},{obj},{->},{key},{;}' // sets the parsing format to check for calls like @obj->key
);

/** register a classloader and then fall back on japha's */
spl_autoload_register( function ( $class ) {
	if( file_exists( dirname(__FILE__)."/lib/{$class}.php" ) ) {
		include_once dirname(__FILE__)."/lib/{$class}.php";
	}
});
require_once dirname(__FILE__).'/../japha/japha.php';

DblFactory::load( $connect );
$db = DblFactory::getConn();
ConfigFactory::setDb( $db );