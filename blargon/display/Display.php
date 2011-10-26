<?php
package('blargon');

import('blargon.lang.Language');
import('blargon.factory.ConfigFactory');
import('blargon.factory.DblFactory');
import('blargon.template.TemplateWrapper');
import('blargon.jdbl.PreparedQueryHandler');

import('blargon.factory.UserFactory');

/**
 * $Id: Display.php,v 1.3 2005/07/11 19:33:45 blargon Exp $
 *
 * This is the parent class of all the displayer classes in the application
 *
 * @author Ryan Gantt
 * @version $Revision: 1.3 $
 */
abstract class Display
{
	protected $db;
	protected $config;
	protected $user;
	protected $pqh;
	protected $lang;
	protected $template;
	protected $language;
	private $templateName;
	
	/**
	 * Initializes the database connection, and the configuration connections,
	 * and then makes a call to an abstract method that must be defined in the
	 * child classes in order to initialize the template system
	 *
	 * Contains the only statically called query in the entire application, as it
	 * resides in an abstract class and the preparedQueryHandler depends on the fact
	 * that it can derive the name of the class at run time and load those queries.
	 */
	public function __construct( $lang )
	{
		$this->db = DblFactory::getConn();
		$this->config = ConfigFactory::getConfig();
		if( isset( $_COOKIE['uName'] ) && isset( $_COOKIE['pass'] ) )
		{
			$this->user = UserFactory::getUser( $_COOKIE['uName'], md5( $_COOKIE['pass'] ) );
		}
		else
		{
			// login as a dummy user who is only able to see news
			$this->user = '';
		}
		$this->templateName = $this->db->fetchObject( $this->db->query("select value from ".$this->config->get('prefix')."_config where entry='theme'") )->value;
		$this->init( $lang );
	}
	
	/**
	 * Abstract method that must be defined with a call to the language
	 * and prepared query handler initialization systems.
	 *
	 * @abstract
	 */
	public function init( $lang )
	{
		$this->language = $lang;
		$this->pqh = new PreparedQueryHandler( get_class( $this ), $this->config->get('prefix') );
		$this->template = new TemplateWrapper( $this->templateName );
		$this->template->setClass( get_class( $this ) );
		$this->lang = new Language( $lang, get_class( $this ) );
	}
}