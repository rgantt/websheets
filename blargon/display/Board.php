<?
package('blargon');

import('blargon.display.Display');
import('blargon.factory.*');

/**
 * $Id: Board.php,v 1.5 2005/07/11 19:33:45 blargon Exp $
 *
 * This is the class that controls the user message board that's displayed
 * on the main control panel page. It's a fairly straightforward class, mainly
 * because most of the actual logic is in a separate file, called (at this time)
 * board.php in the main directory.
 *
 * @author Ryan Gantt
 * @version $Date: 2005/07/11 19:33:45 $
 */
class Board extends Display
{
	/**
	 * Returns the name of the site from the configuration
	 *
	 * @return string The name of the web site
	 */
	public function getSiteName()
	{
		return $this->config->get('siteName');
	}
	
	/**
	 * Shows the board to the public, including the name of the site and all of
	 * the entries in their own iframe (to limit the amount of space it takes)
	 *
	 * @return string The user message board with site title
	 */
	public function show()
	{
		$replacer = $this->template->setMethod( 'board' );
		$replacer->addVariable( 'title', $this->getSiteName() );
		$replacer->addVariable( 'entries', $this->getEntries() );
		return $this->template->createViewer( $replacer );
	}
	
	/**
	 * Returns the html code for an iframe which contains the user message board
	 *
	 * @return string HTML code for an iframe with the message board inside
	 */
	public function getEntries()
	{
		return '<iframe class="boardTableCell" src="board.php?language='.$this->language.'" style="border:1px solid #ffffff; width:100%; height:295px;"></iframe>';
	}
	
	/**
	 * This is the method that is called when you actually post to the board
	 *
	 * @return string A confirmation message about your shout
	 */
	public function saveEntry()
	{
		$put = $this->pqh->execute( 'saveEntry', array( time(), $this->user->getId(), $_POST['message'] ) );
		if( $put )
		{
			return $this->lang->success( 'saveEntry', 'default' );
		}
		else
		{
			return $this->lang->failure( 'saveEntry', 'default' ) . $this->db->getError();
		}
	}
	
	/**
	 * A planned administration area for the board, which would include such 
	 * things as a language filter, a way to delete posts, to resize the iframe,
	 * to change the styles, etc.
	 *
	 * @return string An error message, because this feature doesn't exist.
	 */
	public function admin()
	{
		return $this->lang->message( 'adminBoard', 'default' );
	}
}
?>