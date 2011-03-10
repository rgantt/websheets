<?
package('blargon.controller');

import('blargon.command.Command');
import('blargon.display.Category');

class CategoryCommand extends Command
{
	public function init( $lang )
	{
		$this->class = new Category( $lang );
	}
}
?>
