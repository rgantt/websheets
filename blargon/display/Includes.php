<?
package('blargon');

import('blargon.display.Display');
import('blargon.factory.*');

/**
 * $Id: Includes.php,v 1.4 2005/07/11 19:26:13 blargon Exp $
 *
 * This class provides the header and footer to the application
 *
 * @author Ryan Gantt
 * @version $Revision: 1.4 $
 */
class Includes extends Display
{
	/**
	 * Shows the header of the blargon application, including the logo
	 *
	 * @return String Template of the header
	 */
	function head()
	{
		$replacer = $this->template->setMethod( 'head' );
		return $this->template->createViewer( $replacer );
	}

	/**
	 * Shows the footer of the application, including the time spent rendering the page
	 *
	 * @return String Template of the header
	 */	
	function footer( $diff )
	{
		$replacer = $this->template->setMethod( 'foot' );
		$replacer->addVariable( 'time', round( $diff, 3 ) );
		return $this->template->createViewer( $replacer );
	}
}
?>
