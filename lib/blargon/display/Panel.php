<?php
namespace blargon\display;

use japha\lang\StringBuffer;
use blargon\factory\DblFactory;

/**
 * $Id: Panel.php,v 1.4 2005/07/11 19:26:13 blargon Exp $
 *
 * Provides a method to display the menu, and render it according to the userLevel
 * of the currently logged in client.
 *
 * @author Ryan Gantt
 * @version $Revision: 1.4 $
 */
class Panel extends Display {
	/**
	 * Formats a hypertext reference so that it can be put into the menu (basically
	 * just here to save space in the menu method).
	 *
	 * @param url Uri relative to the index
	 * @param text The text to display in the link
	 * @param req The level required to actually display the link
	 * @return String A link to the control panel area specified by url
	 */
	function link( $url, $text, $req ) {
		return ( ( $req <= $this->user->getLevel() ) ? '<li><a href="index.php?go='.$url.'" target="_self">'.$text.'</a></li>' : '' );
	}
	
	/**
	 * Completely Hardcoded. Eww.
	 *
	 * Formats links to all of the possible control panel areas, taking into
	 * account the level of the current user, and the permissions allowed with
	 * respect to that level.
	 *
	 * @return String The control panel menu
	 */
	function showPanel() {
		$c = new StringBuffer();
		$c->append("<ul>");
		$c->append( $this->link( 'news&page=edit', $this->lang->message( 'showPanel', 'articles' ), 1 ) );
		$c->append( $this->link( 'category&page=add', $this->lang->message( 'showPanel', 'categories' ), 3 ) );
		$c->append( $this->link( 'template&page=main', $this->lang->message( 'showPanel', 'template' ), 3 ) );
		$c->append( $this->link( 'user&page=add', $this->lang->message( 'showPanel', 'users:add' ), 2 ) );
		$c->append( $this->link( 'user&page=remove', $this->lang->message( 'showPanel', 'users:edit' ), 3 ) );
		$c->append( $this->link( 'comments&page=viewPosts', $this->lang->message( 'showPanel', 'comments' ), 2 ) );
		$c->append( $this->link( 'configuration&page=edit', $this->lang->message( 'showPanel', 'configuration' ), 3 ) );
		$c->append( $this->link( 'user&page=edit', $this->lang->message( 'showPanel', 'profile' ), 1 ) );
		$c->append( $this->link( 'logout', $this->lang->message( 'showPanel', 'logout' ), 1 ) );
		$c->append("</ul>");
		
		$replacer = $this->template->setMethod( 'panel' );
		$replacer->addVariable( 'menu', $c->toString() );
		return $this->template->createViewer( $replacer );
	}
}