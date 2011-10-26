<?php
package('blargon');

import('japha.lang.StringBuffer');

/**
 * $Id: PageContent.php,v 1.1.1.1 2005/07/06 17:28:54 blargon Exp $
 *
 * Small class which provides an abstraction between plain text and buffered text.
 *
 * We use it either in stead of, or along side the buffered output functions that
 * are built in to php. Used as a string buffer of sorts. In fact, it is implemented
 * with a string buffer.
 *
 * @author Ryan Gantt
 * @version $Revision: 1.1.1.1 $
 */
class PageContent
{
	/**
	 * Instance of StringBuffer that is used to hold the entire contents
	 * of the page before it is sent to the screen.
	 *
	 * @protected
	 */
	protected $page;
	
	protected $header;
	protected $panel;
	protected $footer;
	protected $messages;
	
	/**
	 * Constructor which initializes the buffer, and adds any input
	 * to the buffer.
	 *
	 * @param text Text which will be added to the beginning of the buffer
	 */
	public function __construct( $text=null )
	{
		$this->page = new StringBuffer('');
		if( !is_null( $text ) )
		{
			$this->add( $text );
		}
	}
	
	/**
	 * Adds text to the page buffer
	 *
	 * @param text Text or HTML code to be added to the buffer
	 */
	public function add( $text )
	{
		$this->page->append( $text );
	}
	
	public function setHeader( $header )
	{
		$this->header = new StringBuffer( $header );
	}
	
	public function setPanel( $panel )
	{
		$this->panel = new StringBuffer( $panel );
	}
	
	public function setFooter( $footer )
	{
		$this->footer = new StringBuffer( $footer );
	}
	
	public function getMessages()
	{
		return $this->messages;
	}
	
	public function setMessages( $messages )
	{
		$this->messages = $messages;
	}
	
	public function messageViewer( MessageStack $stack )
	{
		$content = new StringBuffer();
		while( !$stack->isEmpty() )
		{
			$msg = $stack->pop();
			$content->append( $msg->getMessage()->toString() );
		}
		return $content;
	}
	
	/**
	 * Calls toString on the buffer, and then echos the output to the page.
	 */
	public function render()
	{
		echo $this->header->toString();
		echo $this->panel->toString();
		echo $this->page->toString();
		if( $this->getMessages() != null )
		{
			echo $this->messages->toString();
		}
		echo $this->footer->toString();
	}
}