<?php
package('blargon.util');

import('blargon.factory.ConfigFactory');
import('blargon.factory.DblFactory');

import('blargon.util.Entry');

class Atom
{
	protected $config;
	protected $db;
	
	protected $toShow;
	protected $counter = 0;
	
	public function __construct()
	{
		$this->config = ConfigFactory::getConfig();
		$this->db = DblFactory::getConn();
		$this->toShow = $this->config->get('xmlPostsToShow') - 1;
		$this->numPosts = $this->db->numRows( $this->db->query('select * from '.$this->config->get('prefix').'_news') );
	}
	
	public function getSiteName()
	{
		return $this->config->get('siteName');
	}
	
	public function getBlargonVersion()
	{
		return $this->config->get('version');
	}
	
	public function getSubTitle()
	{
		return $this->config->get('subTitle');
	}
	
	public function getUpdated()
	{
		return;
	}
	
	public function getId()
	{
		return;
	}
	
	public function getAlternateLink()
	{
		return $this->config->get('siteUrl');
	}
	
	public function getRights()
	{
		return;
	}
	
	public function getDescription()
	{
		return $this->config->get('siteDescription');
	}
	
	public function getBlargonUrl()
	{
		return $this->config->get('blargonUrl');
	}
	
	public function getNextPost()
	{
		if( ( $this->counter <= $this->toShow ) && ( $this->counter < $this->numPosts ) )
		{
			return new Entry( $this->counter++ );
		}
		return false;
	}
}