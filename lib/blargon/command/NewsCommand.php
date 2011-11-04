<?php
namespace blargon\command;

use blargon\display\News;

class NewsCommand extends Command {
	public function init() {
		$this->class = new News();
	}
}