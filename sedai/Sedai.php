<?
package('sedai');

import('sedai.parser.SedaiParser');
import('sedai.replacer.SedaiReplacer');

class Sedai
{
	protected $format;
	protected $template;
	protected $include;
	protected $key;
	public $rpl;
	private $templateName;
	
	public function __construct( $name )
	{
		require 'configuration/sedai.php';
		$this->format = $format;
		$this->include = $includeDir;
		$this->templateName = $name;
	}
	
	public function setClass( $template )
	{
		$this->template = $template;
	}
	
	public function getClass()
	{
		return $this->template;
	}
	
	public function setMethod( $key )
	{
		$this->key = $key;
	}
	
	public function getMethod()
	{
		return $this->key;
	}
	
	public function getFormat()
	{
		$pieces = explode( ',', str_replace( '{', '', str_replace( '}', '', $this->format ) ) );
		return $pieces;
	} 
	
	public function templateParser()
	{
		$prs = new SedaiParser( $this->include.'/'.$this->templateName.'/display', $this->template.'.php', $this->key );
		$prs->setFormat( $this->getFormat() );
		return $prs;
	}
	
	public function templateReplacer( $parser )
	{
		$rpl = new SedaiReplacer( $parser->getHaystack(), $this->getFormat() );
		$rpl->setClass( $this->template );
		$rpl->setMethod( $this->key );
		while( ( $cmd = $parser->getNext() ) !== false )
		{
			$rpl->addReplace( $cmd );
		}
		return $rpl;
	}
	
	public function doReplace( $replacer )
	{
		return $replacer->replace();
	}
	
	public function templateViewer( $replacer )
	{
		return $replacer->view();
	}
}
?>
