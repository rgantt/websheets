<?php
package('blargon.controller');

import('blargon.command.Command');
import('blargon.display.Users');

class UserCommand extends Command
{
	public function init( $lang )
	{
		$this->class = new Users( $lang );
	}
}