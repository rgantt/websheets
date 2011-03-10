<?
$connect['host'] = "localhost"; // Host for ArgonNews database.. It's usually localhost
$connect['user'] = "root";    	// Username for ArgonNews database
$connect['pass'] = "1m2i3d4f"; 	// Password for ArgonNews database
$connect['base'] = "websheets";  	// Database where ArgonNews is installed

// If ArgonNews is located at www.yourdomain.com/argonnews, then "argonnews" would be the value
$direct = "websheets";	//Directory where argonnews is located
// This should only be changed if you have multiple installations of ArgonNews on the same database
$prefix = "blargon";	//Table prefix for this install of ArgonNews
// This should stay as "bl-MySQL" unless you've purchased another database driver.
$driver = "bl-MySQL";

// --------------------------------- //
// Beginning the database connection //
// --------------------------------- //

require_once 'japha.php';

import('blargon.factory.DblFactory');
import('blargon.util.Configuration');

DblFactory::loadUp( $connect, $driver );
DblFactory::getConn();
?>