<?php
namespace blargon\display;

/**
 * This class provides the header and footer to the application
 */
class Includes extends Display {
	/**
	 * Shows the header of the blargon application, including the logo
	 *
	 * @return String Template of the header
	 */
	function head()	{
		$replacer = $this->template->setMethod( 'head' );
		return $this->template->createViewer( $replacer );
	}

	/**
	 * Shows the footer of the application, including the time spent rendering the page
	 *
	 * @return String Template of the header
	 */	
	function footer( $diff ) {
		$replacer = $this->template->setMethod( 'foot' );
		$replacer->addVariable( 'time', round( $diff, 3 ) );
		return $this->template->createViewer( $replacer );
	}
}