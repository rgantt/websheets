<?php
/** Websheets configuration directives */

$connect = array(
	'host' => 'localhost',
	'user' => 'root', 
	'pass' => '1m2i3d4f',
	'base' => 'websheets',
	// database table-name prefix for this installation
	'prefix' => 'websheets',
	// should stay as bl-MySQL unless you've got another driver
	'driver' => 'bl-MySQL'
);

$prefix = $connect['prefix'];
$driver = $connect['driver'];

/** Sedai configuration directives */

$includeDir = 'templates'; // all templates will be loaded from this directory by default
$format = '{@},{obj},{->},{key},{;}'; // sets the parsing format to check for calls like @obj->key

/* Beginning the database connection */

require_once dirname(__FILE__).'/japha.php';

import('blargon.factory.DblFactory');
import('blargon.util.Configuration');

DblFactory::loadUp( $connect, $driver );
DblFactory::getConn();