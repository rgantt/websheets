<?php
package('blargon.controller');

import('blargon.command.Command');
import('blargon.display.Site');

class ConfigurationCommand extends Command
{
	public function init( $lang )
	{
		$this->class = new Site( $lang );
	}
}