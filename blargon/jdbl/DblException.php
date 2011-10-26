<?php
namespace blargon\jdbl;

use japha\lang\Exception;

/**
 * $Id: DblException.php,v 1.1.1.1 2005/07/06 17:28:53 blargon Exp $
 *
 * Exception thrown when there is an error within one of the drivers. Usually
 * thrown at the beginning of execution when the driver is connecting.
 *
 * @author Ryan Gantt
 * @version $Revision: 1.1.1.1 $
 */
class DblException extends Exception
{
	/**
	 * Adds a message to be shown in the stack trace
	 *
	 * @param message Message about the exception
	 */
	public function __construct( $message )
	{
		$this->message = $message;
	}
}