<?php
package('blargon');

import('blargon.display.Display');

import('blargon.exception.InvalidDataTypeException');

/**
 * $Id: Category.php,v 1.5 2005/07/14 16:58:45 blargon Exp $
 *
 * This class controls the creation, display, change, and deletion of those
 * things which I call categories. The concept of categories hasn't really
 * been to pushed to its limit in this application, though I hope someday I can
 * bring it closer. Optimally there would be a way to show only news from a
 * certain category (which I guess is possible now, with some skill on the part
 * of the user).
 *
 * Basically for now a category is just a way to tip you off to what you should
 * be writing about, and a visual clue for the reader as to what you should be
 * talking about. They are not enforced at all -- in fact, if you wanted, you
 * could define one, and then not even display it in the template.
 *
 * @author Ryan Gantt
 * @version $Date: 2005/07/14 16:58:45 $
 */
class Category extends Display
{
	/**
	 * This is the method where we list all of the current categories, and also
	 * have a box where a user can enter the name of a new category which they
	 * would like to create
	 *
	 * @return string The template for adding and viewing categories
	 */
	public function add()
	{
		$listCats = '';
		$result = $this->pqh->execute( 'addCategory' );
		if( $this->db->numRows( $result ) == 0 )
		{
			$listCats = $this->lang->failure( 'addCategory', 'default' );
		}
		else
		{
			while( $cat = $this->db->fetchObject( $result ) )
			{
				$listCats .= "<tr>\n\t\t<td><a href=\"index.php?go=category&page=edit&cat=".$cat->id."\">$cat->name</a></td>\n\t</tr>";
				$listCats .= $this->getCategoryList( $cat->id, $cat->name, 1 );
			}
		}
		
		$replacer = $this->template->setMethod( 'addCategory' );
		$replacer->addVariable( 'catsList', $listCats );
		return $this->template->createViewer( $replacer );
	}
	
	private function getCategoryList( $id, $name, $level )
	{
		$lc = '';
		$pad = ( 10 * $level );
		$c = $this->db->query('select * from '.$this->config->get('prefix').'_category where parent=\''.$id.'\'');
		while( $row = $this->db->fetchObject( $c ) )
		{
			$lc .= "<tr>\n\t\t<td><p style=\"padding-left: ".$pad."pt;\"><a href=\"index.php?go=category&page=edit&cat=".$row->id."\">$row->name</a></p></td>\n\t</tr>";
			$lc .= $this->getCategoryList( $row->id, $row->name, ++$level );
		}
		return $lc;
	}
	
	/**
	 * This is the method that's called to save a *new* category. The category
	 * information is just the default crap that I came up with a long time ago.
	 *
	 * @return string A confirmation message about your successful creation
	 */
	public function save()
	{
		if( $_POST['newCat'] == '' )
		{
			throw new InvalidDataTypeException( $this->lang->failure( 'saveCategory', 'nullTitle' ) );
		}
		$insert = $this->pqh->execute( 'saveCategory', array( $_POST['newCat'] ) );
		return $this->lang->success( 'saveCategory', 'default' );
	}
	
	/**
	 * Called when a user edits an existing category. There is significantly more
	 * logic in this call, because there is the option to delete a category
	 * after it has been created. That's what the logic is for.
	 *
	 * @return string A confirmation message about the edit or deletion of the category
	 */
	public function doSave()
	{
		if( $_POST['keep'] == 'yes' )
		{
			$this->pqh->execute( 'doSaveCategory', array( $_POST['newCatName'], $_POST['catShortName'], $_POST['catImage'], $_POST['catHomePage'], $_POST['parent'], $_POST['catName'] ), 'update' );
			return $this->lang->success( 'doSaveCategory', 'updated' );
		} 
		else 
		{
			$this->pqh->execute( 'doSaveCategory', array( $_POST['catName'] ), 'delete' );
			return $this->lang->success( 'doSaveCategory', 'deleted' );
		}
	}
	
	/**
	 * Shows the template which allows a user to edit the information regarding
	 * an existing category.
	 *
	 * @return string The template to edit an existing category
	 */
	public function edit()
	{
		$select = $this->pqh->execute( 'editCategory', array( $_GET['cat'] ) );
		$cat = $this->db->fetchObject( $select );
		
		$current = $this->db->fetchObject( $this->db->query('select id, name from '.$this->config->get('prefix').'_category where id=\''.$cat->parent.'\'') );
		
		$q = $this->db->query('select id, name from '.$this->config->get('prefix').'_category where id <> \''.$cat->id.'\' and id <> \''.$current->id.'\' order by id desc');
		$parents = '<select name="parent" class="formInput">';
		$parents .= '<option value="'.$current->id.'">'.$current->name.'</option>';
		$parents .= '<option value="0">None</option>';
		while( $row = $this->db->fetchObject( $q ) )
		{
			$parents .= '<option value="'.$row->id.'">'.$row->name.'</option>';
		}
		$parents .= '</select>';
		
		$vars = array( 'catsList' => $parents, 'name' => $cat->name, 'shortName' => $cat->shortName, 'image' => $cat->image, 'homePage' => $cat->homePage );
		
		$this->template->setMethod( 'editCategory' );
		$parser = $this->template->createParser( 'templates/'.$this->config->get('theme') );
		$replacer = $this->template->createReplacer( $parser );
		$replacer->addVariables( $vars );
		return $this->template->createViewer( $replacer );
	}
}