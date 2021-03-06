<?php
namespace blargon\display;

use blargon\lang\Language;
use blargon\factory\DblFactory;
use blargon\factory\ConfigFactory;
use blargon\template\TemplateWrapper;
use blargon\jdbl\PreparedQueryHandler;
use blargon\factory\UserFactory;

/**
 * This is the parent class of all the displayer classes in the application
 */
abstract class Display {
	protected $db;
	protected $config;
	protected $user;
	protected $pqh;
	protected $lang;
	protected $template;
	protected $language;
	
	/**
	 * Initializes the database connection, and the configuration connections,
	 * and then makes a call to an abstract method that must be defined in the
	 * child classes in order to initialize the template system
	 *
	 * Contains the only statically called query in the entire application, as it
	 * resides in an abstract class and the preparedQueryHandler depends on the fact
	 * that it can derive the name of the class at run time and load those queries.
	 */
	public function __construct() {
		$this->db = DblFactory::getConn();
		$this->config = ConfigFactory::getConfig();
		/** STRONG AUTHENTICATION */
		if( isset( $_COOKIE['uName'] ) && isset( $_COOKIE['pass'] ) ) {
			$this->user = UserFactory::getUser( $_COOKIE['uName'], md5( $_COOKIE['pass'] ) );
		} else {
			// login as a dummy user who is only able to see news
			$this->user = '';
		}
		$this->init();
	}
	
	public function init() {
		$this->pqh = new PreparedQueryHandler( get_class( $this ), $this->config->get('prefix') );
		$this->template = new TemplateWrapper("templates");
		$this->template->setClass( get_class( $this ) );
		$this->lang = new Language( get_class( $this ) );
	}
}