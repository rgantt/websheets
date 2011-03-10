<?
$config = ConfigFactory::getConfig();

require_once 'blargon/display/Site.php';

class Comments
{
	protected $db;
	protected $siteUrl;
	protected $action;
	protected $config;
	protected $temp;

	function Comments( $action )
	{
		global $prefix, $path;
		if( !is_null( $prefix ) && !is_null( $path ) )
		{
			$this->prefix = $prefix;
			$this->path = $path;
		}
		$this->init();
		$this->action = $action;
		$this->db = DblFactory::getConn();
		$this->config = ConfigFactory::getConfig();
		$this->siteUrl = '';
	}
	
	public function init()
	{
		$this->temp = new TemplateWrapper();
		$this->temp->setClass('Display');
	}
	
	function doAction()
	{
		return $this->{$this->action}();
	}
	
	function save()
	{
		if( $_POST['subject'] == '' )
		{
			die("You must enter a subject for your post!");
		}
		$query = $this->db->query("INSERT INTO ".$this->prefix."_comment ( postId, userName, subject, comment, addr, parent ) VALUES ('".$_GET['post']."', '".$_POST['yourName']."', '".$_POST['subject']."', '".$_POST['comments']."', '".$_SERVER['REMOTE_ADDR']."', '".$_POST['parent']."')");
		if($query == TRUE)
		{
			return "Your comment was successfully added to post ".$_GET['post'].". Please choose one of the following links.<br/><a href=\"".$this->siteUrl."\">View all News</a><br/><a href=\"".$_SERVER['PHP_SELF']."?comments=see&post=".$_GET['post']."\">View your comment</a>";
		} 
		else 
		{
			return "Unknown error: Your comment could not be added to the database.<br/><a href=\"".$_SERVER['PHP_SELF']."\">Back to Main News Page</a>";
		}
	}
	
	function add() 
	{
		$vars = array( 'site' => $this->siteUrl, 'page' => $_SERVER['PHP_SELF'], 'post' => $_GET['post'], 'parent' => $_GET['parent'] );
		$this->temp->setMethod( 'addComment' );
		$parser = $this->temp->createParser( 'templates/Solstice' );
		$replacer = $this->temp->createReplacer( $parser );
		$replacer->addVariables( $vars );
		return $this->temp->createViewer( $replacer );
	} 
	
	function getCommentsLevel( $post, $parent, $count )
	{
		$pad = 50 * $count;
		$format .= '<p style="padding-left: '.$pad.'pt;"><a href="'.$_SERVER['PHP_SELF'].'?comments=read&post='.$_GET['post'].'&id={id}\">{subject}</a><p/>';
		
		$content = '';
		$query = $this->db->query('select * from '.$this->config->get('prefix').'_comment where postId=\''.$post.'\' and parent=\''.$parent.'\' order by id desc');
		if( $this->db->numRows( $query ) > 0 )
		{
			while( $level = $this->db->fetchObject( $query ) )
			{
				$content .= str_replace( '{id}', $level->id, str_replace( '{subject}', $level->subject, $format ) );
				$nextLevel = $this->db->query('select * from '.$this->config->get('prefix').'_comment where postId=\''.$post.'\' and parent=\''.$level->id.'\'');
				if( $this->db->numRows( $nextLevel ) > 0 )
				{
					$content .= $this->getCommentsLevel( $post, $level->id, $count + 1 );
				}
			}
		}
		return '<tr><td>'.$content.'</td></tr>';
	}
	
	function see()
	{
		$getQuery = $this->db->query("SELECT * FROM ".$this->config->get('prefix')."_comment WHERE postId = '".$_GET['post']."' and parent='0' ORDER BY id DESC");
		$getRows = $this->db->numRows( $getQuery );
		
		if( $getRows != 0 )
		{
			$content = '<table cellpadding="0" cellspacing="0">';
			$content = $this->getCommentsLevel( $_GET['post'], 0, 0 );
			$content .= "<tr><td><p/></td></tr><tr><td><a href=\"".$_SERVER['PHP_SELF']."\">Return to News</a></td></tr></table>";
		} 
		else 
		{
			$content = "There are no comments for post ".$_GET['post'].". Would you like to post a comment?<br/><a href=\"".$_SERVER['PHP_SELF']."\">Return to News</a><br/><a href=\"".$_SERVER['PHP_SELF']."?comments=add&post=".$_GET['post']."\">Add a Comment</a>";
		}
		return $content;
	} 
	
	function read()
	{
		$comment = $this->db->fetchObject( $this->db->query("SELECT * FROM ".$this->prefix."_comment WHERE id = '".$_GET['id']."'") );
		$vars = array( 'userName' => $comment->userName, 'subject' => $comment->subject, 'comment' => $comment->comment, 'url' => $_SERVER['PHP_SELF'], 'post' => $_GET['post'], 'id' => $comment->id );
		
		$this->temp->setMethod( 'readComment' );
		$parser = $this->temp->createParser( 'templates/Solstice' );
		$replacer = $this->temp->createReplacer( $parser );
		$replacer->addVariables( $vars );
		return $this->temp->createViewer( $replacer );
	}
}
?>