<?
package('sedai.helper');

abstract class Helper
{
	protected $instance;
	
	public function __construct()
	{
		$this->getInstance();
	}
	
	abstract public function getInstance();
	abstract public function get( $key );
}
?>
