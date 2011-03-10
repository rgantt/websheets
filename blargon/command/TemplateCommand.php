<?
package('blargon.controller');

import('blargon.command.Command');
import('blargon.display.NewsTemplate');

class TemplateCommand extends Command
{
	public function init( $lang )
	{
		$this->class = new NewsTemplate( $lang );
	}
}
?>
