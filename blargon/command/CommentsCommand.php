<?php
namespace blargon\command;

use blargon\display\Comments;

class CommentsCommand extends Command {
	public function init( $lang ) {
		$this->class = new Comments( $lang );
	}
}