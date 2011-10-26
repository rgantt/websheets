<?php
package('blargon.factory');

import('blargon.factory.DblFactory');
import('blargon.user.*');

class UserFactory
{
	public static function getUser( $name, $password )
	{
		global $prefix;
		if( $name == NULL )
		{
			return new Reader( null, null );
		}
		else
		{
			$db = DblFactory::getConn();
			$level = $db->fetchObject( $db->query('select userLevel from '.$prefix.'_user where user=\''.$name.'\' and pass=\''.$password.'\'') );
			switch( $level->userLevel )
			{
				case 1:
					return new Poster( $name, $password );
					break;
				case 2:
					return new Moderator( $name, $password );
					break;
				case 3:
					return new Administrator( $name, $password );
					break;
				default:
					throw new Exception('Cannot create an instance of invalid user level '.$level->userLevel.'!');
			}
		}
	}
}