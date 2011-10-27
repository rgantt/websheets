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
	 * Checks the configuration setting and returns a boolean regarding
	 * whether to show the links for two independent templates.
	 *
	 * @return boolean Whether or not to show per-user template options
	 */
	function perUserTemplates()	{
		return ( ( $this->config->get('perUserTemplates') == 'yes' ) ? true : false );
	}
	
	/**
	 * Formats a hypertext reference so that it can be put into the menu (basically
	 * just here to save space in the menu method).
	 *
	 * @param url Uri relative to the index
	 * @param text The text to display in the link
	 * @param req The level required to actually display the link
	 * @return String A link to the control panel area specified by url
	 */
	function panelLink( $url, $text, $req ) {
		return ( ( $req <= $this->user->getLevel() ) ? '<li/><a href="index.php?go='.$url.'" target="_self">'.$text.'</a>' : '' );
	}

	function subPanelLink( $url, $text, $req ) {
		return '<div style="text-indent: 1em;">'.$this->panelLink( $url, $text, $req ).'</div>';
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
		$c->append( $this->panelLink( '', $this->lang->message( 'showPanel', 'home' ), 1 ) );
		$c->append( '<li/>'.$this->lang->message( 'showPanel', 'articles' ) );
		$c->append( $this->subPanelLink( 'news&page=add', $this->lang->message( 'showPanel', 'articles:add' ), 1 ) );
		$c->append( $this->subPanelLink( 'news&page=edit', $this->lang->message( 'showPanel', 'articles:edit' ), 2 ) );
		$c->append( '<li/>'.$this->lang->message( 'showPanel', 'categories' ) );
		$c->append( $this->subPanelLink( 'category&page=add', $this->lang->message( 'showPanel', 'categories:add' ), 3 ) );
		$c->append( $this->subPanelLink( 'category&page=add', $this->lang->message( 'showPanel', 'categories:edit' ), 3 ) );
		$c->append( '<li/>'.$this->lang->message( 'showPanel', 'templates' ) );
		if( $this->perUserTemplates() )	{	
			$c->append( $this->subPanelLink( 'template&page=main', $this->lang->message( 'showPanel', 'templates:global' ), 3 ) );
			$c->append( $this->subPanelLink( 'template&page=user', $this->lang->message( 'showPanel', 'templates:user' ), 1 ) );
		} else {
			$c->append( $this->subPanelLink( 'template&page=main', $this->lang->message( 'showPanel', 'templates:news' ), 3 ) );
		}
		$c->append( '<li/>'.$this->lang->message( 'showPanel', 'users' ) );
		$c->append( $this->subPanelLink( 'user&page=add', $this->lang->message( 'showPanel', 'users:add' ), 2 ) );
		$c->append( $this->subPanelLink( 'user&page=remove', $this->lang->message( 'showPanel', 'users:edit' ), 2 ) );
		$c->append( $this->panelLink( 'comments&page=viewPosts', $this->lang->message( 'showPanel', 'comments' ), 2 ) );
		$c->append( $this->panelLink( 'configuration&page=edit', $this->lang->message( 'showPanel', 'configuration' ), 3 ) );
		$c->append( $this->panelLink( 'user&page=edit', $this->lang->message( 'showPanel', 'profile' ), 1 ) );
		$c->append( $this->panelLink( 'logout', $this->lang->message( 'showPanel', 'logout' ), 1 ) );
		
		$replacer = $this->template->setMethod( 'panel' );
		$replacer->addVariable( 'menu', $c->toString() );
		return $this->template->createViewer( $replacer );
	}
}