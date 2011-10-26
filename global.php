<?php
function installedLanguage( $lang )
{
	if( is_dir( 'language/'.$lang ) )
	{
		return true;
	}
	return false;
}