<?php
function doAction()
{
	global $lang, $config, $db;
	$errors = 0;
	require_once '../configuration/configure.php';
	require_once 'tablesQuery.php';
	require_once 'insertsQuery.php';
	
	$db = DblFactory::getConn();
	
	foreach( $q as $key => $value )
	{
		$qu = $db->query( str_replace( '{0}', $prefix, $value ) );
		if( $qu )
		{
			$content .= greenIt( ucfirst( $key ).$lang->message( 'step6', 'wasAdded' ) ).'<br/>';
		}
		else
		{
			$content .= redIt( ucfirst( $key ).$lang->message( 'step6', 'wasNot' ) ).'<br/>';
			$errors++;
		}
	}
	
	$content .= '<p/>';
	
	foreach( $inserts as $key => $value )
	{
		$qu = $db->query( str_replace( '{0}', $prefix, $value ) );
		if( $qu )
		{
			if( strlen( $key ) > 1 )
			{
				$content .= greenIt( ucfirst( $key ).$lang->message( 'step6', 'wasAdded' ) ).'<br/>';
			}
		}
		else
		{
			if( strlen( $key ) > 1 )
			{
				$content .= redIt( ucfirst( $key ).$lang->message( 'step6', 'wasNot' ) ).'<br/>';
			}
			$errors++;
		}
	}
	
	if( $errors == 0 )
	{
		$content .= '<p/>'.$lang->message( 'general', 'continue' ).'<p/>';
	}
	else
	{
		$content .= '<p/>'.$lang->message( 'step4', 'fix' ).'<p/>';
	}
	
	return array( $content, $errors, true );
}

function greenIt( $message )
{
	return '<span style="color:green;">'.$message.'</span>';
}

function redIt( $message )
{
	return '<span style="color:red;">'.$message.'</span>';
}