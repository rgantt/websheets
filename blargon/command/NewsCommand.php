<?php
package('blargon.controller');

import('blargon.command.Command');
import('blargon.display.News');

class NewsCommand extends Command
{
	public function init( $lang )
	{
		$this->class = new News( $lang );
	}
}