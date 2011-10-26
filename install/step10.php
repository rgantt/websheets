<?php
use blargon\factory\DblFactory;

function doAction() {
	global $lang, $prefix;
	$errors = 0;
	
	$db = DblFactory::getConn();
	$q = $db->query('insert into '.$prefix.'_template ( template, user ) values ( \''.$_POST['template'].'\', 0 )');
	if( $q ) {
		$content = '<p/>'.$lang->success( 'step10', 'query' );
	} else {
		$content = '<p/>'.$lang->failure( 'step10', 'query' );
		$errors++;
	}
	return array( $content, $errors, true );
}