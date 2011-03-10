<?
require_once 'configuration/configure.php';
require_once 'configuration/japha.php';
require_once 'global.php';

$db = DblFactory::getConn();

import('blargon.display.Panel');
import('blargon.display.Includes');
// this is only to get the language client function
import('blargon.display.News');
import('blargon.messages.*');
import('blargon.lang.Language');

import('blargon.util.FrontController');

$language = News::getClientLanguage();

if( $_COOKIE['bl_lang'] != $language )
{
	setcookie( 'bl_lang', $language );
	header('Location: index.php');
}

if( isset( $_COOKIE['uName'] ) )
{
	$include = new Includes( $language );
	$panel = new Panel( $language );
	
	$messageStack = new MessageStack();
	
	$user = new UserStatus();
	$user->checkStatus( $messageStack );
	
	FrontController::setHeader( $include->head() );
	FrontController::setPanel( $panel->showPanel() );
	FrontController::setFooter( $include->footer( null ) );
	FrontController::run( $messageStack, $language );
} 
else
{
  $config = ConfigFactory::getConfig();
  $lang = new Language( News::getClientLanguage(), 'login' );

  if( isset( $_POST['submit'] ) && $_POST['submit'] )
  {
    $query = $db->query('SELECT id, pass FROM '.$config->get('prefix').'_user WHERE user=\''.$_POST['user'].'\'') or die( $db->getError() );
    $result = $db->fetchObject( $query ); 
    if( $db->numRows( $db->query( 'select * from '.$config->get('prefix').'_attempts where userId=\''.$result->id.'\'') ) >= 5 )
    {
      header( 'Location: index.php?error='.$lang->message( 'general', 'locked' ).'.' );
      die();
    }
    if( md5( $_POST['pass'] ) == $result->pass )
    {
      $id = $db->fetchObject( $db->query('SELECT id FROM '.$config->get('prefix').'_user WHERE user=\''.$_POST['user'].'\'') );
      $db->query('delete from '.$config->get('prefix').'_attempts where userId=\''.$id->id.'\'' ) or die(mysql_error());
      $lvlQuery = $db->query('SELECT userLevel FROM '.$config->get('prefix').'_user WHERE user=\''.$_POST['user'].'\'');
      if( ( $level = $db->fetchObject( $lvlQuery ) ) && ( ( isset( $_POST['stayLogged'] ) && $_POST['stayLogged'] ) ) )
      {
        setcookie( 'pass', $_POST['pass'], time() + 29030400 );
        setcookie( 'uName', $_POST['user'], time() + 29030400 );
        setcookie( 'uLevel', $level->userLevel, time() + 29030400 );
      } 
      else 
      {
        setcookie( 'pass', $_POST['pass'] );
        setcookie( 'uName', $_POST['user'] );
        setcookie( 'uLevel', $level->userLevel );
      }
      header( 'Location: index.php' );
    }
    else
    {
      // Forward the user to an error page
      $db->query( 'insert into '.$config->get('prefix').'_attempts ( userId, time, addr ) values ( \''.$result->id.'\', \''.time().'\', \''.$_SERVER['REMOTE_ADDR'].'\' )' );
      sleep( 3 );
      setcookie( 'pass', '', time() - 60 );
      setcookie( 'uName', '', time() - 60 );
      setcookie( 'uLevel', '', time() - 60 );
      
      header( 'Location: index.php?error='.$lang->message( 'general', 'noCookie' ).'.' );
    }
  }
  ?>
  <html>
  <head>
  <title><?=$config->get('siteName')?></title>
  <link rel="stylesheet" href="templates/<?=$config->get('theme');?>/style/shell.css" type="text/css">
  </head>
  <body class="loginBody">
  <table height="100%" width="100%">
  <tr>
  <td align="center" valign="middle">
  <form action="index.php" method="post">
  <table class="loginTable" align="center">
    <tr>
      <td align="center" colspan="3"><img src="templates/<?=$config->get('theme');?>/images/logo_front.jpg"/></td>
    </tr>
    <tr>
      <td class="loginCell"><?=$lang->message( 'general', 'user' );?>:</td>
      <td colspan="2"><input type="text" maxlength="20" name="user" style="width:100%;" class="formInput"/></td>
    </tr>
    <tr>
      <td class="loginCell"><?=$lang->message( 'general', 'pass' );?></td>
      <td colspan="2"><input type="password" maxlength="20" name="pass" style="width:100%;" class="formInput"/></td>
    </tr>
    <tr>
      <td class="loginCell"><?=$lang->message( 'general', 'stayLog' );?>:</td>
      <td><input type="checkbox" name="stayLogged"/></td>
      <td><input type="submit" name="submit" value="<?=$lang->message( 'general', 'login' );?>" class="formInput"/></td>
    </tr>
  </table>
  </form>
  <div class="loginBody">ryan gantt <sup>2002-2009</sup></div>
  <?
  if( isset( $_GET['error'] ) )
  {
    echo "<p/><div class=\"loginError\">".$_GET['error']."</div>\n";
  }
  ?>
  </td>
  </tr>
  </table>
  </body>
  </html>
<?
}
?>