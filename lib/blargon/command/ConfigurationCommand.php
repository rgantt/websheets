<?php
namespace blargon\command;

use blargon\display\Site;

class ConfigurationCommand extends Command {
	public function init() {
		$this->class = new Site();
	}
}