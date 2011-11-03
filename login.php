<?php
use blargon\display\News;
use blargon\lang\Language;
use blargon\factory\ConfigFactory;
use blargon\factory\DblFactory;

require_once dirname(__FILE__).'/config.php';

$db = DblFactory::getConn();
ConfigFactory::setDb( $db );
$config = ConfigFactory::getConfig();
$lang = new Language( "en-us", 'login' );

if( isset( $_POST['submit'] ) && $_POST['submit'] ) {
	$result = $db->query('SELECT id, pass FROM '.$config->get('prefix').'_user WHERE user=\''.$_POST['user'].'\'')->fetchObject();
	if( $db->query( 'select * from '.$config->get('prefix').'_attempts where userId=\''.$result->id.'\'')->rowCount() >= 5 ) {
		header( 'Location: login.php?error='.$lang->message( 'general', 'locked' ).'.' );
		die();
	}
	if( md5( $_POST['pass'] ) == $result->pass ) {
		$id = $db->query('SELECT id FROM '.$config->get('prefix').'_user WHERE user=\''.$_POST['user'].'\'')->fetchObject();
		$db->query('delete from '.$config->get('prefix').'_attempts where userId=\''.$id->id.'\'' ) or die(mysql_error());
		$level = $db->query('SELECT userLevel FROM '.$config->get('prefix').'_user WHERE user=\''.$_POST['user'].'\'')->fetchObject();
		if( ( isset( $_POST['stayLogged'] ) && $_POST['stayLogged'] ) ) {
			setcookie( 'pass', $_POST['pass'], time() + 29030400 );
			setcookie( 'uName', $_POST['user'], time() + 29030400 );
			setcookie( 'uLevel', $level->userLevel, time() + 29030400 );
		} else {
			setcookie( 'pass', $_POST['pass'] );
			setcookie( 'uName', $_POST['user'] );
			setcookie( 'uLevel', $level->userLevel );
		}
		header( 'Location: index.php' );
	} else {
		// Forward the user to an error page
		$db->query( 'insert into '.$config->get('prefix').'_attempts ( userId, time, addr ) values ( \''.$result->id.'\', \''.time().'\', \''.$_SERVER['REMOTE_ADDR'].'\' )' );
		sleep( 3 );
		setcookie( 'pass', '', time() - 60 );
		setcookie( 'uName', '', time() - 60 );
		setcookie( 'uLevel', '', time() - 60 );
		header( 'Location: login.php?error='.$lang->message( 'general', 'noCookie' ).'.' );
	}
}
?>
<html>
	<head>
		<title><?php echo $config->get('siteName')?></title>
		<link rel="stylesheet" href="include/view/style/shell.css" type="text/css">
	</head>
	<body class="loginBody">
		<table height="100%" width="100%">
			<tr>
				<td align="center" valign="middle">
					<form action="login.php" method="post">
						<table class="loginTable" align="center">
							<tr>
								<td align="center" colspan="3"><img src="include/view/images/logo_front.jpg"/></td>
							</tr>
							<tr>
								<td class="loginCell"><?php echo $lang->message( 'general', 'user' );?>:</td>
								<td colspan="2"><input type="text" maxlength="20" name="user" style="width:100%;" class="formInput"/></td>
							</tr>
							<tr>
								<td class="loginCell"><?php echo $lang->message( 'general', 'pass' );?></td>
								<td colspan="2"><input type="password" maxlength="20" name="pass" style="width:100%;" class="formInput"/></td>
							</tr>
							<tr>
								<td class="loginCell"><?php echo $lang->message( 'general', 'stayLog' );?>:</td>
								<td><input type="checkbox" name="stayLogged"/></td>
								<td><input type="submit" name="submit" value="<?php echo $lang->message( 'general', 'login' );?>" class="formInput"/></td>
							</tr>
						</table>
					</form>
					<div class="loginBody">ryan gantt <sup>2002-2011</sup></div>
					<?php
					if( isset( $_GET['error'] ) ) {
						echo "<p/><div class=\"loginError\">".$_GET['error']."</div>\n";
					}
					?>
				</td>
			</tr>
		</table>
	</body>
</html>