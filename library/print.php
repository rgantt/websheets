<?
require(dirname(__FILE__) . '/configure.php');
require(dirname(__FILE__) . '/connect.php');

function replaces()
	{
	//Gets the defualt template
	$template = mysql_query("SELECT template FROM an_template") or DIE("template " . mysql_error());
	$temp = mysql_fetch_object($template);
	//Gets the news posts and info
	$resultNews = mysql_query("SELECT id, cat, news, subject, time, user FROM an_news WHERE id='{$_GET['post']}'") or DIE("news " . mysql_error());	
	//Gets the emote replaces going
	$path = "/argonnews/emotes";
	$result = mysql_query("SELECT emote, image FROM an_emoticons") or DIE("emote " . mysql_error());
		//Puts the emotes in an array
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		$emotes[] = $row['emote'];
		$images[] = "<img alt=\"\" src='". $path . "/" . $row['image'] . "'/>";
		}
		while($show = mysql_fetch_object($resultNews)){
		//Puts the default template in a variable, so we can use the real template later
		$this->newsplate = $temp->template;
		//Gets the user information for each post
		$resultUser = mysql_query("SELECT user, email, avatar, userLevel, alias FROM an_user WHERE user='$show->user'");
		$nUser = mysql_fetch_object($resultUser);
		//Selects all the categories, and adds them to the news
		$selectCats = mysql_query("SELECT * FROM an_cats WHERE id='$show->cat'") or DIE(mysql_error());
		$obCats = mysql_fetch_object($selectCats) or print("CAT OBJECT ERROR");
		//These are where the templates are replaced with MySQL info
		$show->news = str_replace($emotes, $images, $show->news);
		$this->newsplate = eregi_replace("<#SUBJECT#>", $show->subject, $this->newsplate);
		$this->newsplate = eregi_replace("<#ADDCOM#>", "/argonnews/news.php?comments=add&post=$show->id", $this->newsplate);
		$this->newsplate = eregi_replace("<#SEECOM#>", "/argonnews/news.php?comments=see&post=$show->id", $this->newsplate);
		$this->newsplate = eregi_replace("<#ALIAS#>", $nUser->alias, $this->newsplate);
		$this->newsplate = eregi_replace("<#NAME#>", $show->user, $this->newsplate);
		$this->newsplate = eregi_replace("<#EMAIL#>", $nUser->email, $this->newsplate);
		$this->newsplate = eregi_replace("<#TIME#>", $show->time, $this->newsplate);
		$this->newsplate = eregi_replace("<#CATEGORY#>", $obCats->catName, $this->newsplate);
		$this->newsplate = eregi_replace("<#CATICON#>", "<img src=\"/argonnews/caticon/$obCats->catImage\" alt=\"\"/>", $this->newsplate);
		$this->newsplate = eregi_replace("<#AVATAR#>", $nUser->avatar, $this->newsplate);
		$this->newsplate = eregi_replace("<#NEWS#>", $show->news, $this->newsplate);
		$this->newsplate = eregi_replace("<#PRINT#>", "/argonnews/print.php?post=$show->id", $this->newsplate);
		$this->newsplate = eregi_replace("<#SEND#>", "/argonnews/send.php?post=$show->id", $this->newsplate);
		//Prints the news
		print $this->newsplate;
		//Restores the original template so we can use it for the next post
		$this->newsplate = $temp->template;
		}
	}


	replaces();
?>	