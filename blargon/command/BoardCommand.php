<?php
namespace blargon\command;

use blargon\display\Board;

class BoardCommand extends Command {
	public function init( $lang ) {
		$this->class = new Board( $lang );
	}
}