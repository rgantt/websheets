<?php
use blargon\factory\DblFactory;

function doAction() {
	global $lang, $config, $db, $connect;
	$prefix = $connect['prefix'];
	
	$db = DblFactory::getConn();
	
	if( $_POST['password'] == $_POST['repeatPass'] ) {
		$pass = md5( $_POST['password'] );
		$template = <<<END
<table>	
	<tr>
		<td>{subject}</td>
		<td>{time}</td>
	</tr>
	<tr>
		<td colspan="2">{news}</td>
	</tr>
	<tr>
		<td><a href="mailto:{email}">{news}</a></td>
		<td>{category}</td>
	</tr>
</table>
END;
		$db->query('insert into '.$prefix.'_user ( user, pass, userLevel ) values ( \''.$_POST['userName'].'\', \''.$pass.'\', \'3\' )');
		$db->query('insert into '.$prefix.'_template ( template, user ) values ( \''.$template.'\', 0 )');
		
		header('Location: ../index.php');
	} else {
		header('Location: index.php?page=5&error=There%20was%20an%20error.%20Please%20try%20again.');
	}
	return array( $content, $errors, true );
}