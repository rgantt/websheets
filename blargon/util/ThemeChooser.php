<?
package('blargon.util');

import('blargon.factory.ConfigFactory');

class ThemeChooser
{
	private $theme;
	
	public function __construct()
	{
		$config = ConfigFactory::getConfig();
		$this->theme = $config->get('theme');
	}
	
	public function getTheme()
	{
		return 'templates/'.$this->theme;
	}
}
?>
