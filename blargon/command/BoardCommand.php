<?php
package('blargon.controller');

import('blargon.command.Command');
import('blargon.display.Board');

class BoardCommand extends Command
{
	public function init( $lang )
	{
		$this->class = new Board( $lang );
	}
}