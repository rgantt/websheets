<?
package('blargon.controller');

import('blargon.command.Command');
import('blargon.display.Comments');

class CommentsCommand extends Command
{
	public function init( $lang )
	{
		$this->class = new Comments( $lang );
	}
}
?>
