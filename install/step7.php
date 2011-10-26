<?php
function doAction()
{
	global $lang, $config;
	$errors = 0;
	
	$content = '<table>';
	$content .= '<tr><td>'.$lang->message( 'general', 'userName' ).'</td><td><input class="formInput" type="text" name="userName"/></td></tr>';
	$content .= '<tr><td>'.$lang->message( 'general', 'password' ).'</td><td><input class="formInput" type="password" name="password"/></td></tr>';
	$content .= '<tr><td>'.$lang->message( 'general', 'repeatPass' ).'</td><td><input class="formInput" type="password" name="repeatPass"/></td></tr>';
	$content .= '</tr></table>';
	
	return array( $content, $errors, true );
}