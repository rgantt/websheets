<?php
package('blargon.controller');

import('blargon.command.Command');

class LogoutCommand extends Command
{
	public function init( $lang )
	{
		setcookie( 'uName', '', time() - 60 );
		setcookie( 'pass', '', time() - 60 );
		header( 'Location: index.php' );
	}
}