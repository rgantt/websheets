<?php
package('blargon');

import('blargon.display.Display');
import('blargon.factory.DblFactory');

/**
 * $Id: NewsTemplate.php,v 1.3 2005/07/11 19:26:13 blargon Exp $
 *
 * This class is all about the new templates, including the global template
 * and the user defined template.
 *
 * @author Ryan Gantt
 * @version $Date: 2005/07/11 19:26:13 $
 */
class NewsTemplate extends Display
{
	/**
	 * This is the method that's called when we know for sure that no one is
	 * using a per-user template system.
	 *
	 * It simply loads the root template (that template defined by user 0, which
	 * can never be the personal template of anyone).
	 *
	 * @return string The main template of the blargon system
	 */
	function main()
	{
		$temp = $this->db->fetchObject( $this->pqh->execute( 'mainTemplate' ) );
		
		$replacer = $this->template->setMethod( 'mainTemplate' );
		$replacer->addVariable( 'template', eregi_replace( '<br />', '', $temp->template ) );
		return $this->template->createViewer( $replacer );
	}

	/**
	 * This method simply merges your changes with that of the template in the
	 * database. It completely overwrites the saved one with your new one.
	 *
	 * Warning: there is no backup, so if you save, there's no going back.
	 *
	 * @return string A confirmation message notifying you of your template save
	 */
	function saveMain()
	{
		if(isset($_POST['submit']) && $_POST['submit'])
		{
			$this->pqh->execute( 'saveMainTemplate', array( $_POST['template'] ) );
			return $this->lang->success( 'saveMainTemplate', 'default' ) . '<br><a href="index.php">Back to Control Panel</a>';
		}
	}
	
	/**
	 * This method does the exact same thing as this.mainTemplate(), except that
	 * it uses a template defined by one of the users. If you are a user, but
	 * you don't have a custom template yet, it will ask you if do you do in
	 * fact want to make your own, or just use the global one.
	 *
	 * @return string Either the current users template, or the global one
	 */
	function user()
	{
		$templateGet = $this->pqh->execute( 'userTemplate', array( $this->user->getId() ), 'templateGet' );
		if( $this->db->numRows( $templateGet ) == 0 )
		{
			if( isset( $_GET['make'] ) && ( $_GET['make'] == 'true' ) )
			{
				$this->pqh->execute( 'userTemplate', array( $userId), 'insert' );
				$templateGet = $this->pqh->execute( 'userTemplate', array( $userId ), 'templateGetInner' );
			}
			else
			{
				return $this->lang->message( 'userTemplate', 'noneExist' ).'<center><br/><a href="index.php?go=template&page=user&make=true">Create Custom Template</a><br/><a href="index.php?go=template&page=main">Edit Main Template</a></center>';
			}
		}
		$temp = $this->db->fetchObject( $templateGet );
		
		$replacer = $this->template->setMethod( 'userTemplate' );
		$replacer->addVariable( 'template', eregi_replace( '<br />', '', $temp->template ) );
		return $this->template->createViewer( $replacer );
	}

	/**
	 * Overwrites the template currently associated with the user in the database
	 * with the one that the user is saving from the web form.
	 *
	 * @return string A confirmation message regarding your saved template
	 */
	function saveUser()
	{
		$this->pqh->execute( 'saveUserTemplate', array( $_POST['template'], $this->user->getId() ) );
		return $this->lang->success( 'saveUserTemplate', 'default' ) . '<br><a href="index.php">Back to Control Panel</a>';
	}
}