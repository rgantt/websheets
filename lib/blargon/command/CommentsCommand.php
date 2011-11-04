<?php
namespace blargon\command;

use blargon\display\Comments;

class CommentsCommand extends Command {
	public function init() {
		$this->class = new Comments();
	}
}