<?
package('blargon');

import('blargon.display.Display');
import('blargon.factory.DblFactory');

/**
 * $Id: Users.php,v 1.5 2005/07/11 19:26:14 blargon Exp $
 *
 * Displays all of the user functions: edit, create, and remove.
 *
 * @author Ryan Gantt
 * @version $Revision: 1.5 $
 */
class Users extends Display
{
	function getAvatarList()
	{
		$content = '';
		$dir = dir('images/avatar');
		while( ( $file = $dir->read() ) !== false )
		{
			if( ( substr( $file, -4 ) == '.jpg' ) || ( substr( $file, -4 ) == '.jpeg' ) || ( substr( $file, -4 ) == '.gif' ) || ( substr( $file, -4 ) == '.png' ) )
			{
				$content .= '<option value="'.$file.'">'.$file.'</option>';
			}
		}
		return $content;
	}
	
	function uploadAvatar()
	{
		$replacer = $this->template->setMethod( 'board' );
		return $this->template->createViewer( $replacer );
	}
	
	function doUploadAvatar()
	{
		if( $_FILES['avatar']['error'] == 0 )
		{
			if( $_POST['fileName'] != $_FILES['avatar']['name'] )
			{
				$_FILES['avatar']['name'] = $_POST['fileName'];
			}
			if( move_uploaded_file( $_FILES['avatar']['tmp_name'], 'images/avatar/'.$_FILES['avatar']['name'] ) )
			{
				return $this->lang->success( 'doUploadAvatar', 'default' );
			}
			return $this->lang->failure( 'doUploadAvatar', 'notMoved' );
		}
		else
		{
			return $this->lang->failure( 'doUploadAvatar', 'notUploaded' );
		}
		trace( $_FILES );
	}
	
	function edit()
	{
		$title = ( $this->config->get( 'userTitles' ) == 'yes' ) ? '<tr><td>Title:</td><td><input class="formInput" type="text" name="title" value="#titleVal#"></td></tr>' : '<input type="hidden" name="title" value="Nobody"/>';
		
		$replacer = $this->template->setMethod( 'editUser' );
		$replacer->addVariable( 'listAvatars', $this->getAvatarList() );
		return $this->template->createViewer( $replacer );
	}
		
	function doEdit()
	{
		if( md5( $_POST['oldPass'] ) == $this->user->getPass() )
		{
			$this->user->setEmail( $_POST['email'] );
			$this->user->setAlias( $_POST['alias'] );
			$this->user->setAvatar( $_POST['avatar'] );
			if( isset( $_POST['title'] ) )
			{
				$this->user->setTitle( $_POST['title'] );
			}
			$content = $this->lang->success( 'doEditUser', 'default' );
			
			if( ( $_POST['newPass'] != '' ) && ( $_POST['newPass'] == $_POST['repeatNew'] ) )
			{
				$this->user->setPass( $_POST['newPass'] );
				$content .= $this->lang->success( 'doEditUser', 'passMatch' ).$_POST['newPass'].'.';
			}
			else if( ( $_POST['newPass'] != '' ) && ( $_POST['newPass'] != $_POST['repeatNew'] ) )
			{
				$content .= $this->lang->failure( 'doEditUser', 'wrongPass' );
			}
		} 
		else 
		{
			$content = $this->lang->failure( 'doEditUser', 'passNotFound' );
		}
		return $content;
	}
	
	function add()
	{
		$ull = "<td>User Level:</td>\n<td><select class=\"formInput\" name=\"userLevel\">";
		switch( $this->user->getLevel() )
		{
			case 3:
				$ull .= '<option value="3">(3) '.$this->lang->message( 'addUser', 'level3' ).'</option>';
			case 2:
				$ull .= '<option value="2">(2) '.$this->lang->message( 'addUser', 'level2' ).'</option>';
				$ull .= '<option value="1">(1) '.$this->lang->message( 'addUser', 'level1' ).'</option>';
				break;
		}
		$ull .= "</select></td></tr><tr>";
		
		$replacer = $this->template->setMethod( 'addUser' );
		$replacer->addVariable( 'userLevel', $ull );
		return $this->template->createViewer( $replacer );
	}

	function save()
	{
		if( $_POST['newPass'] == '' )
		{
			return $this->lang->failure( 'saveUser', 'passBlank' );
		} 
		else if( $_POST['repeatPass'] == '' )
		{
			return $this->lang->failure( 'saveUser', 'repeatBlank' );
		} 
		else if( $_POST['newUserName'] == '' )
		{
			return $this->lang->failure( 'saveUser', 'userBlank' );
		}
		else if( !( $_POST['newPass'] == $_POST['repeatPass'] ) )
		{
			return $this->lang->failure( 'saveUser', 'passMatch' );
		} 
		else 
		{
			$this->pqh->execute( 'saveUser', array( $_POST['newUserName'], md5($_POST['newPass']), $_POST['newEmail'], $_POST['newAlias'], $_POST['avatar'], $_POST['userLevel'] ) );
			return $this->lang->success( 'saveUser', 'default' );
		}
	}

	function remove()
	{
		$users = '';
		$result = $this->pqh->execute( 'removeUser' );
		while( $row = $this->db->fetchObject( $result ) )
		{
			$users .= '<option value="'.$row->user.'">'.$row->user.'</option>';
		}
		
		$replacer = $this->template->setMethod( 'removeUser' );
		$replacer->addVariable( 'users', $users );
		return $this->template->createViewer( $replacer );
	}
	
	function removeSave()
	{
		$user = $this->db->fetchObject( $this->pqh->execute( 'removeSaveUser', array( $_POST['removeUser'] ), 'user' ) );
		if( $user->userLevel == 4 )
		{
			return $this->lang->failure( 'removeSave', 'admin' );
		}
		else if( $user->user == $_COOKIE['uName'] )
		{
			return $this->lang->failure( 'removeSave', 'reflect' );
		}
		else 
		{
			$this->pqh->execute( 'removeSaveUser', array( $_POST['removeUser'] ), 'delete' );
			return $this->lang->success( 'removeSave', 'default' );
		}
	}
}
?>