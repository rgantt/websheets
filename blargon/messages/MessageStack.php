<?php
namespace blargon\messages;

use japha\util\Stack;

class MessageStack extends Stack {
	public function push( Message $object ) {
		parent::push( $object );
	}
}