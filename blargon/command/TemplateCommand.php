<?php
namespace blargon\command;

use blargon\display\NewsTemplate;

class TemplateCommand extends Command {
	public function init( $lang ) {
		$this->class = new NewsTemplate( $lang );
	}
}