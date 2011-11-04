<?php
use blargon\factory\DblFactory;

require_once dirname(__FILE__).'/tablesQuery.php';
require_once dirname(__FILE__).'/insertsQuery.php';

function doAction() {
	global $lang, $config, $db, $q, $inserts, $connect;
	$prefix = $connect['prefix'];
	$errors = 0;
	
	$db = DblFactory::getConn();
	
	foreach( $q as $key => $value ) {
		$qu = $db->query( str_replace( '{0}', $prefix, $value ) );
		if( $qu ) {
			$content .= greenIt( ucfirst( $key ).$lang->message( 'step6', 'wasAdded' ) ).'<br/>';
		} else {
			$content .= redIt( ucfirst( $key ).$lang->message( 'step6', 'wasNot' ) ).'<br/>';
			$errors++;
		}
	}
	
	$content .= '<p/>';
	
	foreach( $inserts as $key => $value ) {
		$qu = $db->query( str_replace( '{0}', $prefix, $value ) );
		if( !$qu ) {
			$errors++;
		}
	}
	
	if( $errors == 0 ) {
		$content .= '<p/>'.$lang->message( 'general', 'continue' ).'<p/>';
	} else {
		$content .= '<p/>'.$lang->message( 'step4', 'fix' ).'<p/>';
	}
	
	return array( $content, $errors, true );
}

function greenIt( $message ) {
	return '<span style="color:green;">'.$message.'</span>';
}

function redIt( $message ) {
	return '<span style="color:red;">'.$message.'</span>';
}