<?php
namespace blargon\command;

use blargon\display\Users;

class UserCommand extends Command {
	public function init() {
		$this->class = new Users();
	}
}