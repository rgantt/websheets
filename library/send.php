<?php
require(dirname(__FILE__) . '/configure.php');
require(dirname(__FILE__) . '/connect.php');
require(dirname(__FILE__) . '/class/main.php');
$admin = new Mainclass();
$admin->header();
if($_GET['send'] == ''){
?>
<form action="send.php?post=<? echo"{$_GET['post']}"; ?>&send=yes" method="post">
<table>
	<tr>
		<td>Your Email:</td>
		<td align="left"><input type="text" name="yourEmail" length="20" maxlength="50"/></td>
	</tr>
	<tr>
		<td>Friends Email:</td>
		<td align="left"><input type="text" name="friendEmail" length="20" maxlength="50"/></td>
	</tr>
	<tr>
		<td>Personalized Message:</td>
		<td><textarea name="message" cols="40" rows="15">Insert Message Here</textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="submit" value="Send"/></td>
	</tr>
</table>
</form>
<?php
} else {
$getPost = mysql_query("SELECT * FROM an_news WHERE id='{$_GET['post']}'") or die(mysql_error());
$post = mysql_fetch_object($getPost);
$getConf = mysql_query("SELECT * FROM an_config") or die(mysql_error());
$conf = mysql_fetch_object($getConf);
$post->news = str_replace("<br />", "\n", $post->news);
$friendEmail = "{$_POST['friendEmail']}";
$yourEmail = "{$_POST['yourEmail']}";
$personal = "{$_POST['message']}";
$subject = "News from $conf->pageTitle";
$header = "From: $yourEmail";

$message = "$personal\n";
$message .= "$post->subject\n";
$message .= "Posted On: $post->time\n";
$message .= "Posted By: $post->user\n";
$message .= "Message: $post->news\n";
$message .= "This newspost from $conf->pageTitle was sent courtesy of $yourEmail.";

mail($friendEmail, $subject, $message, $header) or die("can't send mail");
print("The news was successfully sent.<br/><a href=\"$conf->siteUrl\">Back to the News</a>");

}
$admin->footer();