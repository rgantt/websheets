<?php
use blargon\factory\DblFactory;
use blargon\util\Configuration;

/** Websheets configuration directives */

$connect = array(
	'host' => 'localhost',
	'user' => 'root', 
	'pass' => '',
	'base' => 'websheets',
	// database table-name prefix for this installation
	'prefix' => 'websheets',
	// should stay as bl-MySQL unless you've got another driver
	'driver' => 'MySQL'
);

$prefix = $connect['prefix'];
$driver = $connect['driver'];

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

DblFactory::loadUp( $connect, $driver );