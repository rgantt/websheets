<?php
namespace blargon\command;

use blargon\display\Site;

class ConfigurationCommand extends Command {
	public function init( $lang ) {
		$this->class = new Site( $lang );
	}
}