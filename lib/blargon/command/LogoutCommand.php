<?php
namespace blargon\command;

class LogoutCommand extends Command {
	public function init() {
		setcookie( 'uName', '', time() - 60 );
		setcookie( 'pass', '', time() - 60 );
		header( 'Location: index.php' );
	}
}