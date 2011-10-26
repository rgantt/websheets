<?php
package('blargon');

import('blargon.display.Display');
import('blargon.factory.DblFactory');

/**
 * $Id: Comments.php,v 1.13 2005/07/14 16:58:45 blargon Exp $
 *
 * This might just be the most dirty class in all of blargon. I'm not even sure
 * why it's in a class right now, to be honest. Basically every single piece of
 * logic needed to administer everything about comments is held in this one
 * single method.
 *
 * One of the goals of the next major release is a complete rewrite (or just a
 * reworking) of the comments engine.
 *
 * @author Ryan Gantt
 * @version $Date: 2005/07/14 16:58:45 $
 */
class Comments extends Display
{
	/**
	 * Shows a list of all of the news entries in the database (regardless of whether
	 * they have any comments attached to them or not), and lists the amount of comments
	 * that they have attached to them. It also lists the id number, although that is
	 * not useful to anyone.
	 *
	 * @return String The HTML of the list
	 */
	function viewPosts()
	{
		$trueComs = $this->db->numRows( $this->pqh->execute( 'viewPostsComments', array(), 'trueComs' ) );
		$max = $this->config->get('numPosts');
		$getPosts = $this->pqh->execute( 'viewPostsComments', array(), 'getPosts' );		
		
		$content = '';
		while( $post = $this->db->fetchObject( $getPosts ) )
		{
			$comCount = $this->db->numRows( $this->pqh->execute( 'viewPostsComments', array( $post->id ), 'comCount' ) );
			$content .= "<tr>\n\t<td class=\"listTableCell\">".$post->id."</td>\n\t\t<td class=\"listTableCell\"><a href=\"index.php?go=comments&page=view&postid=".$post->id."\">".$post->subject."</a></td>\n\t\t<td class=\"listTableCell\">".$comCount."</td>\n\t</tr>";
		}
		
		$replacer = $this->template->setMethod( 'viewPosts' );
		$replacer->addVariable( 'listPosts', $content );
		return $this->template->createViewer( $replacer );
	}
	
	function isBanned( $ip )
	{
		return $this->db->numRows( $this->db->query('select id from '.$this->config->get('prefix').'_banned where addr=\''.$ip.'\'') );
	}
	
	function ban()
	{
		switch( $_GET['type'] )
		{
			case 1:
				$this->db->query('insert into '.$this->config->get('prefix').'_banned ( addr ) values ( \''.$_GET['ip'].'\' )');
				return 'ip banned.';
				break;
			case 0:
				$this->db->query('delete from '.$this->config->get('prefix').'_banned where addr=\''.$_GET['ip'].'\'');
				return 'ip unbanned.';
				break;
		}
	}
	
	function doRed( $text )
	{
		return '<span style="color:red;">'.$text.'</span>';
	}

	function doGreen( $text )
	{
		return '<span style="color:green;">'.$text.'</span>';
	}
	
	function ip()
	{
		$content = 'The status of this ip is: ';
		if( $this->isBanned( $_GET['ip'] ) )
		{
			$content .= $this->doRed('banned.');
			$content .= '<p/><a href="index.php?go=comments&page=ban&type=0&ip='.$_GET['ip'].'">unban this ip</a>';
		}
		else
		{
			$content .= $this->doGreen('allowed.');
			$content .= '<p/><a href="index.php?go=comments&page=ban&type=1&ip='.$_GET['ip'].'">ban this ip</a>';
		}
		return $content;
	}
	
	/**
	 * Shows a list of links to the comments attached to a certain news entry. If there are
	 * no comments for the news entry, it will display a message confirming that fact.
	 *
	 * @return String The HTML list of the comments
	 */
	function view()
	{
		$getComments = $this->pqh->execute( 'viewComment', array( $_GET['postid'] ) );
		$content .= "<table>";
		if( $this->db->numRows( $getComments ) == 0)
		{
			return $this->lang->message( 'doComments', 'noComments' );
		} 
		else 
		{
			while( $comment = $this->db->fetchObject( $getComments ) )
			{
				$content .= '<tr><td><a href="index.php?go=comments&page=edit&postid='.$_GET['postid'].'&id='.$comment->id.'">'.$comment->subject.'</a> (<a href="index.php?go=comments&page=ip&ip='.$comment->addr.'">'.$comment->addr.'</a>)</td></tr>';
			}
		}
		return $content . "</table>";
	}
	
	/**
	 * Displays the actual information about the comment in form fields so that it
	 * is easily editable by someone with the correct permissions.
	 *
	 * @return String An HTML form with the fields filled in with the comment data
	 */
	function edit()
	{
		$coms = $this->db->fetchObject( $this->pqh->execute( 'editComment', array( $_GET['id'] ) ) );
		$vars = array( 'post' => $coms->post, 'id' => $coms->id, 'userName' => $coms->userName, 'subject' => $coms->subject, 'comment' => ereg_replace( '<br />', '\n', $coms->comment ) );
		$replacer = $this->template->setMethod( 'edit' );
		$replacer->addVariables( $vars );
		return $this->template->createViewer( $replacer );
	}
	
	/**
	 * Updates the information from editing a comment, and saves it in the database
	 *
	 * This method will either update the information, or delete it, based on the value
	 * of the global HTTP variable "keep".
	 *
	 * @return String A message regarding the successful deletion or edit of the comment
	 */
	function save()
	{
		if($_POST['keep'] == 'keep')
		{
			$this->pqh->execute( 'saveComment', array( $_POST['subject'], nl2br( $_POST['comments'] ), $_GET['id'] ), 'update' );
			return $this->lang->success( 'doComments', 'edited' );
		} 
		else 
		{
			$this->pqh->execute( 'saveComment', array( $_GET['id'] ), 'delete' );
			return $this->lang->success( 'doComments', 'deleted' );	
		}
	}
}