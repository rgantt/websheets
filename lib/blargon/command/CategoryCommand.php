<?php
namespace blargon\command;

use blargon\display\Category;

class CategoryCommand extends Command {
	public function init() {
		$this->class = new Category();
	}
}