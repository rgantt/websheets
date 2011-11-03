<?php
namespace blargon\factory;

use blargon\factory\DblFactory;
use blargon\user\Reader;
use blargon\user\Poster;
use blargon\user\Moderator;
use blargon\user\Administrator;

class UserFactory {
	public static function getUser( $name, $password ) {
		global $connect;
		$prefix = $connect['prefix'];
		if( $name == NULL ) {
			return new Reader( null, null );
		} else {
			$db = DblFactory::getConn();
			$level = $db->query('select userLevel from '.$prefix.'_user where user=\''.$name.'\' and pass=\''.$password.'\'')->fetchObject();
			switch( $level->userLevel ) {
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