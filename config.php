<?php
use blargon\factory\DblFactory;
use blargon\util\Configuration;

/** Database configuration directives */

$connect = array(
	'host' => 'localhost',
	'user' => 'root', 
	'pass' => '',
	'base' => 'websheets',
	// database table-name prefix for this installation
	'prefix' => 'websheets',
	'driver' => 'MySQL'
);

$prefix = $connect['prefix'];

/** Sedai configuration directives */

$sedai = array(
	'includeDir' => 'templates', // all templates will be loaded from this directory by default
	'format' => '{@},{obj},{->},{key},{;}' // sets the parsing format to check for calls like @obj->key
);

/** Set up the class autoloader */

spl_autoload_register( function ( $class ) {
	if( file_exists( dirname(__FILE__)."/{$class}.php" ) ) {
		include_once dirname(__FILE__)."/{$class}.php";
	} else {
		//echo "could not find {$class} in websheets load path";
	}
});

/** Attempt to include Japha's classloader */

require_once dirname(__FILE__).'/../japha/japha.php';

/* Beginning the database connection */

// just got with MySQL for now
DblFactory::load( $connect );

/** uhhh */

function installedLanguage( $lang ) {
	if( is_dir( 'language/'.$lang ) ) {
		return true;
	}
	return false;
}