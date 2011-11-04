<?php
namespace blargon\display;

use blargon\factory\DblFactory;
use blargon\exception\InvalidQueryException;

/**
 * This class controls all of the functions related to news -- adding, editing, 
 * displaying, et cetera.
 *
 * It presently contains the rendering routine for extracting the news from the
 * database and displaying it to the news page. I'm not sure if that will
 * remain in here for long, but for now it's O.K. If it's not broken, don't
 * fix it.
 */
class News extends Display {	
	/**
	 * Checks whether or not the current user has their own template. If
	 * per-user templates are turned on, this method is called to see if the
	 * user has defined their own template yet. If not, they are given a choice
	 * of whether to use the global default or define their own
	 *
	 * @param id int The user if of the person currently accessing the panel
	 * @return int The number of templates that the user currently has defined
	 */
	function userHasTemplate( $id ) {
		return $this->pqh->execute( 'userHasTemplate', array( $this->config->get('prefix'), $id ) )->rowCount();
	}
	
	/**
	 * Selects the appropriate template for the current user. If per-user
	 * templates are enabled, this method will first extract the user id from
	 * the current user name (which is passed in as parameter 0), and then
	 * check the configuration of the per-user templates. If per-user are turned
	 * on, then the method will load the user's template; if not, the global
	 * template (stored under the guise of user 0, or the person who installed).
	 *
	 * @param userName string The name of the user who is accessing the system
	 * @return string The correct template
	 */
	function loadTemplate( $userName ) {
		$id = $this->pqh->execute( 'loadTemplate', array( $userName ), 'getUserId' )->fetchObject();
		if( ( $this->config->get('perUserTemplates') == 'yes' ) && $this->userHasTemplate( $id->id ) ) {
			$temp = $this->pqh->execute( 'loadTemplate', array( $this->config->get('prefix'), $id->id ), 'loadUserTemplate' )->fetchObject();
		} else {
			$temp = $this->pqh->execute( 'loadTemplate', array( $this->config->get('prefix') ), 'loadDefaultTemplate' )->fetchObject();
		}
		return $temp->template;
	}
	
	/**
	 * Returns the maximum number of posts that can be displayed on a single 
	 * page.
	 *
	 * @return int The number of posts per page
	 */
	function getMaxPosts() {
		return $this->config->get('postsPerPage');
	}
	
	/**
	 * This is one of the few methods that has survived throughout the entire
	 * lifetime of blargon (formerly argonnews). It get's all of the information
	 * about the emoticons out of the database (saved as "string" => "image")
	 * and loads them into two arrays, and then returns an array that holds
	 * those two arrays.
	 *
	 * @return array Array containing the array of emotes and that of images
	 */
	function loadEmotes() {
		$emotes = array();
		$images = array();
		$query = $this->pqh->execute( 'loadEmotes' );
		while( $row = $query->fetchObject() ) {
			$emotes[] = $row->emote;
			$images[] = '<img src="http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/'.$this->config->get('installDir').'/images/emoticon/'.$row->image.'" alt=""/>';
		}
		return array( $emotes, $images );
	}
	
	/**
	 * This method does all of the dirty work of displaying the news to the main
	 * news page. It is not used in the administration area at all, which is why
	 * I think it needs to be separated out... eventually.
	 *
	 * Kind of a hacky trick that occurs in this function is the username that
	 * gets passed in. We sometimes want per-user blogs, so we want to only
	 * select those entries which a certain user have created. So, to do this,
	 * in the *only* file that calls this method, I've put in logic to figure
	 * out whether we want a "blog" or a news system. If we want a blog, the
	 * user will call showBlog("userName"), and if they want news, they call
	 * either showNews() or showBlog(). If the userName parameter to this
	 * function is empty, then the method below is called with the only parameter
	 * as '%', which, as those familiar with SQL know, will essentially nullify
	 * the < select ... where user like '$userName' > clause when we grab the
	 * news, resulting in all the news being displayed.
	 *
	 * @param userName The name of the user who is
	 * @return string The entire page of news
	 */
	function replaces( $userName ) {	
		$content = '';
		$resultNews = $this->pqh->execute( 'replaces', array( $this->config->get('prefix'), $userName, $this->getMaxPosts() ), 'resultNews' );
		if( $resultNews->rowCount() == 0 ) {
			$replacer = $this->template->setMethod( 'replaces' );
			return $this->template->createViewer( $replacer );
		}
		list( $chars, $images ) = $this->loadEmotes();
		while( $show = $resultNews->fetchObject() ) {
			$newsplate = $this->loadTemplate( $show->user );
			$numComments = $this->pqh->execute( 'replaces', array( $show->id ), 'numComments' )->rowCount();
			$nUser = $this->pqh->execute( 'replaces', array( $show->user ), 'nUser' )->fetchObject();
			$obCats = $this->pqh->execute( 'replaces', array( $show->cat ), 'obCats' )->fetchObject();
			
			$show->news = str_ireplace( $chars, $images, $show->news );
			
			$keys = array( '{listen}', '{mood}', '{subject}', '{numcom}', '{addcom}', '{seecom}', '{alias}', '{name}', '{email}', '{time}', '{category}', '{caticon}', '{avatar}', '{news}', '{print}', '{send}' );
			$values = array( $show->listeningTo, $show->mood, $show->subject, $numComments, "<a href=\"".$_SERVER['PHP_SELF']."?comments=add&amp;post=".$show->id."\">add comment</a>", "<a href=\"".$_SERVER['PHP_SELF']."?comments=see&amp;post=".$show->id."\">see comments</a>", $nUser->alias, $show->user, $nUser->email, gmdate( $this->config->get('timeFormat'), ( $show->time + ( 3600 * $this->config->get('timeOffset') ) ) ), $obCats->name, "<img src=\"".$this->config->get('installDir')."/images/categories/".$obCats->image."\" alt=\"\"/>", "<img src=\"".$this->config->get('installDir')."/images/avatar/".$nUser->avatar."\" alt=\"\"/>",$show->news, "/".$this->config->get('installDir')."/print.php?post=".$show->id."", "/".$this->config->get('installDir')."/send.php?post=".$show->id."" );
			
			$newsplate  = str_ireplace( $keys, $values, $newsplate );
			$content .= $newsplate;
		}
		return $content;
	}
	
	/**
	 * Need a way to get this to show up without displaying the whole template
	 */
	public function showAll() {
		echo $this->replaces('%');
	}
	
	/**
	 * This is where we actually insert the news article into the database. I'm
	 * not entirely sure why I have two separate methods doing this.
	 *
	 * @return string A confirmation message
	 */
	function build() {
		if( ( $_POST['newsMessage'] == '' ) || ( strtolower( $_POST['newsMessage'] ) == 'story' ) ) {
			throw new InvalidDataTypeException( $this->lang->failure( 'buildNews', 'nullMessage' ) );
		} else if( ( $_POST['subject'] == '' ) || ( strtolower( $_POST['subject'] ) == 'subject' ) ) {
			throw new InvalidDataTypeException( $this->lang->failure( 'buildNews', 'nullSubject' ) );
		} else if( $_POST['catGet'] == 'Choose Category' ) {
			throw new InvalidDataTypeException( $this->lang->failure( 'buildNews', 'chooseCategory' ) );
		}
		
		if( isset( $_POST['submit'] ) && $_POST['submit'] ) {
			$this->pqh->execute( 'buildNews', array( 
					$_POST['time'], 
					$_POST['subject'], 
					$_POST['user'], 
					$_POST['catGet'], 
					addslashes( $_POST['newsMessage'] ) 
				) 
			);
			return $this->lang->success( 'buildNews', 'default' );
		} else {
			return $this->lang->failure( 'buildNews', 'default' );
		}
	}
	
	/**
	 * Here is where we actually display the screen that allows users to add
	 * news to the database. It's very simple; the only dynamic thing that we
	 * show is the categories so that the user can select from them. We also
	 * need to figure out if mood entry is turned on, and display the box
	 * according to what we find.
	 *
	 * If there haven't been any categories defined yet, an error is thrown
	 * and the user must go to the configuration area before they are allowed
	 * to add news
	 *
	 * @return string The page where users can add news
	 */
	function add() {
		$catList = '';
		$getCats = $this->pqh->execute( 'addNews' );
		while( $cats = $getCats->fetchObject() ) {
				$catList .= "<option value=\"".$cats->id."\">".$cats->name."</option>";
		}
		if( $getCats->rowCount() == 0 ) {
			return $this->lang->message( 'addNews', 'addCats' );
		} else {
			$vars = array( 
				'time' => time(), 
				'catList' => $catList 
			);
			$replacer = $this->template->setMethod( 'addNews' );
			$replacer->addVariables( $vars );
			return $this->template->createViewer( $replacer );
		}
	}
	
	/**
	 * Despite the name, this is the page where all of the news entries are shown
	 * in descending order with the links to "Edit" or "Delete" next to them.
	 *
	 * Should be fairly straightforward -- The only really illogical thing that
	 * I've done in this method is to limit the query to 10 results (0,9). This
	 * means that if you have more than 10 entries displayed on a news page, you
	 * aren't going to be able to edit the ones past 10. Sorry. I'll fix it.
	 *
	 * @return string The page which shows the news entries and their options
	 */
	function edit() {
		$articles = "<ul>";
		$getNews = $this->pqh->execute( 'editNews' );
		while( $row = $getNews->fetchObject() ) {
			$date = date( $this->config->get('timeFormat'), $row->time );
			$articles .= <<<END
			
				<li><a href="?go=news&page=readlEdit&edit={$row->id}">{$row->subject}</a> by {$row->user} on {$date}</li>
END;
		}
		$articles .= "</ul>";
		
		$replacer = $this->template->setMethod( 'editNews' );
		$replacer->addVariable( 'articles', $articles );
		return $this->template->createViewer( $replacer );
	}
	
	/**
	 * This is where the template to actually edit the selected news entry is
	 * displayed.
	 *
	 * @return string The edit news boxes filled with the news you've selected
	 */
	function realEdit() {
		$row = $this->pqh->execute( 'realEditNews', array( $_GET['edit'] ), 'row' )->fetchObject();
		$cats = $this->pqh->execute( 'realEditNews', array( $row->cat ), 'cats' )->fetchObject();
		
		$vars = array( 
			'subject' => $row->subject, 
			'id' => $row->id, 
			'author' => $row->user, 
			'category' => $cats->name, 
			'news' => $row->news 
		);
		
		$replacer = $this->template->setMethod( 'realEdit' );
		$replacer->addVariables( $vars );
		return $this->template->createViewer( $replacer );
	}
	
	/**
	 * There is a lot of logic in this function, which is somewhat counter-
	 * intuitive. What actually happens is fairly simple: When the user
	 * checks "save" on the edit news page, blargon has to figure out whether
	 * they have the delete or keep button selected. Depending on this, there
	 * is one fork in the logic. Then, we have to figure out if there was an
	 * error writing to the database. There never will be an error with the
	 * current system, unless someone just turns off MySQL in the middle of a
	 * query. This is in place for future database backends, such as XML.
	 *
	 * @return string A confirmation message telling whether the save was good
	 */
	function saveEdit() {
		if( isset( $_REQUEST['delete'] ) && $_REQUEST['delete'] == 'yes' ) {
			$this->pqh->execute( 'saveEditNews', array( $_REQUEST['id'] ), 'delete' );	
			return $this->lang->success( 'saveEdit', 'delete' ). '<br><a href="index.php">Back to Control Panel</a>';
		} else {
			$this->pqh->execute( 'saveEditNews', array( $_POST['news'], $_POST['subject'], $_POST['id'] ), 'update' );
			return $this->lang->success( 'saveEdit', 'modify' ) . '<br><a href="index.php">Back to Control Panel</a>';
		} 
	}
	
	/**
	 * This useless function just calls this.replaces() and displays all of the
	 * news. Very pointless, really. I don't believe it's ever used within the
	 * program.
	 *
	 * @return string All of the news from this.replaces()
	 */
	function view() {
		return $this->replaces('%');
	}
}