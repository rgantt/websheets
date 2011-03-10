<?
package('blargon');

import('blargon.display.Display');
import('blargon.factory.*');

/**
 * $Id: Site.php,v 1.5 2005/07/11 19:26:13 blargon Exp $
 *
 * This class is here to provide a way to get access to the configuration variables
 * that are saved in the {prefix}_config table. Some of them require logic to save
 * and display, as can be noted in the edit() method.
 *
 * @author Ryan Gantt
 * @version $Revision: 1.5 $
 */
class Site extends Display
{	
	private $problems = array();
	
	/**
	 * Displays all of the configuration options per the template that is
	 * defined in the current theme, and then updates them accordingly. A
	 * sort of neat feature (which I'm still working out the pros/cons of),
	 * is that if you add a text field to the template for this method, and 
	 * then fill it out and submit the form (assuming that you have the
	 * configuration key already defined as SOMETHING in the db), it will
	 * automatically update it as if it had been there forever.
	 *
	 * This method is not meant to edit the hardcoded configuration data (such
	 * as the prefix and database information)
	 *
	 * @return String Form to edit the configuration data
	 */
	function edit()
	{
		$sign = ( ( $this->config->get( 'timeOffset' ) >= 0 ) ? '+' : '-' );
		$absOffset = abs( $this->config->get( 'timeOffset' ) );
		$mood = ( ( $this->config->get( 'moodEntry' ) == 'no' ) ? 'no' : 'yes' );
		$titles = ( ( $this->config->get( 'userTitles' ) == 'no' ) ? 'no' : 'yes' );
		$listening = ( ( $this->config->get( 'listeningTo' ) == 'no' ) ? 'no' : 'yes' );
		$perUser = ( ( $this->config->get( 'perUserTemplates' ) == 'no' ) ? 'no' : 'yes' );
		
		$replacer = $this->template->setMethod( 'config' );
		$vars = array( 'sign' => $sign, 'mood' => $mood, 'perUser' => $perUser, 'titles' => $titles, 'listening' => $listening, 'absOffset' => $absOffset );
		$replacer->addVariables( $vars );
		return $this->template->createViewer( $replacer );
	}
	
	/**
	 * Checks that a given string is in the expected format of an email address
	 *
	 * @return boolean True iff the string was an email address
	 */
	function validateEmail( $email )
	{
		if( !eregi( "^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $email ) )
		{
			return false;
		}
		return true;
	}
	
	/**
	 * Checks that a given string is in the expected format of a URL
	 *
	 * @return boolean True iff the string was a URL
	 */
	function validateUrl( $url )
	{
		if( !eregi( "^(http|https|ftp)\://[a-zA-Z0-9\-\.]+(:[a-zA-Z0-9]*)?/?([a-zA-Z0-9\-\._\?\,\'/\\\+&%\$#\=~])*[^\.\,\)\(\s]$", $url ) )
		{
			return false;
		}
		return true;
	}
	
	/**
	 * Takes the information submitted by Site::edit() and puts the information
	 * back into the database in it's updated form.
	 *
	 * @return String A message regarding the success or failure of the database query
	 */
	function save()
	{
		if( $this->validateEmail( $_POST['adminEmail'] ) )
		{
			if( $this->validateUrl( $_POST['siteUrl'] ) )
			{
				foreach( $_POST as $key => $value )
				{
					$this->config->set( $key, $value );
				}
				return $this->lang->success( 'saveConfiguration', 'default' );
			}
			else
			{
				return $this->lang->failure( 'saveConfiguration', 'url' );
			}
		}
		else
		{
			return $this->lang->faiure( 'saveConfiguration', 'email' );
		}
	}
}
?>