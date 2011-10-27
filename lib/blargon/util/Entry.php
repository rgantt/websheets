<?php
package('blargon.util');

import('blargon.factory.ConfigFactory');
import('blargon.factory.DblFactory');

class Entry
{
	protected $config;
	protected $db;
	protected $entryData;
	
	public function __construct( $n )
	{
		$this->config = ConfigFactory::getConfig();
		$this->db = DblFactory::getConn();
		
		$this->entryData = $this->db->fetchObject( $this->db->query('select * from '.$this->config->get('prefix').'_news order by id desc limit '.$n.',1') );
	}
	
	public function getTitle()
	{
		return $this->entryData->subject;
	}
	
	public function getId()
	{
		return $this->entryData->id;
	}
	
	public function getAuthorName()
	{
		return $this->entryData->user;
	}
	
	public function getReplacedContent()
	{
		return $this->entryData->news;
	}
	
	public function getAlternateLink()
	{
		return;
	}
	
	public function getPostedDate()
	{
		return;
	}
	
	public function getModifiedDate()
	{
		return;
	}
}