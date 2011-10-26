<?php
require_once 'configuration/configure.php';
require_once 'configuration/japha.php';

import('blargon.display.News');

require_once "library/comments.php";

function installedLanguage( $lang )
{
	if( is_dir( 'language/'.$lang ) )
	{
		return true;
	}
	return false;
}

$language = News::getClientLanguage();

function showIcon( $name, $version )
{
	$t = '<a href="blargon/xml/{name}/entries-{version}.php"><img src="blargon/images/icons/{name}-feed.gif" border="0"/></a>';
	$t = str_replace( '{name}', $name, $t );
	return str_replace( '{version}', $version, $t );
}

function showNews( $user='%' )
{
	global $language;
	if( empty( $_GET['comments'] ) && empty( $_GET['post'] ) )
	{
		$news = new News( $language );
		echo $news->replaces( $user );
	} 
	else 
	{
		$comments = new Comments( $_GET['comments'] );
		echo $comments->doAction();
	}
}