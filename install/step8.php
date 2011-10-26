<?php
function doAction()
{
	global $lang, $config, $db, $prefix;
	
	require_once '../configuration/configure.php';
	
	$db = DblFactory::getConn();
	
	if( $_POST['password'] == $_POST['repeatPass'] )
	{
		$pass = md5( $_POST['password'] );
		$db->query('insert into '.$prefix.'_user ( user, pass, userLevel ) values ( \''.$_POST['userName'].'\', \''.$pass.'\', \'3\' )');
		$content = $lang->success( 'step8', 'User' );
	}
	else
	{
		header('Location: index.php?page=5&error=There%20was%20an%20error.%20Please%20try%20again.');
	}
	
	return array( $content, $errors, true );
}