<?php
namespace blargon\command;

use blargon\display\Category;

class CategoryCommand extends Command {
	public function init( $lang ) {
		$this->class = new Category( $lang );
	}
}