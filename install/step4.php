<?php
function doAction() {
	global $lang, $config, $connect;
	$errors = 0;
	$content = '';
	
	if( function_exists('mysql_connect') ) {
		$content .= greenIt( $lang->success( 'step4', 'MySQLExists' ) ).'<br/>';
	} else {
		$content .= redIt( $lang->failure( 'step4', 'MySQLVersion' ) ).'<br/>';
		$errors++;
	}
	
	$v = explode( '.', mysql_get_server_info() );
	if( ( $v[0] >= 4 ) || $v ) {
		$content .= greenIt( $lang->success( 'step4', 'MySQLVersion' ) ).'<br/>';
	} else {
		$content .= redIt( $lang->failure( 'step4', 'MySQLVersion' ) ).'<br/>';
		$errors++;
	}
	
	if( ( $connect['user'] == '#' ) || ( $connect['host'] == '#' ) || ( $connect['pass'] == '#' ) || ( $connect['base'] == '#' ) ) {
		$content .= redIt( $lang->failure( 'step4', 'Configuration' ) ).'<br/>';
		$errors++;
	} else {
		$content .= greenIt( $lang->success( 'step4', 'Configuration' ) ).'<br/>';
	}
	
	if( $errors == 0 ) {
		$content .= '<p/>'.$lang->message( 'general', 'continue' ).'<p/>';
	} else {
		$content .= '<p/>'.$lang->message( 'step4', 'fix' ).'<p/>';
	}
	
	return array( $content, $errors );
}

function greenIt( $message ) {
	return '<span style="color:green;">'.$message.'</span>';
}

function redIt( $message ) {
	return '<span style="color:red;">'.$message.'</span>';
}