<?php
require_once '../config.php';

use blargon\lang\Language;

set_include_path('..');

$includes = explode( ',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] );
$lang = new Language( $includes[0], 'install' );

$page = <<< END
<html>	
<head>
	<title>Blargon v3.4.4</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div align="center">
<img src="../images/logo.jpg" alt="Blargon!" align="center"/>
</div>
<p/>
<table align="center" style="text-align:left; width:500px; border:1px solid #000000;" cellspacing="15">
	<tr>
		<td>
END;

if( isset( $_POST['submit'] ) && strtolower( $_POST['submit'] ) == strtolower( $lang->message( 'general', 'previous' ) ) ) {
	$p = $_GET['page'] - 1;
} else {
	$p = $_GET['page'] + 1;
}

$num = ( !isset( $_GET['page'] ) ? 1 : $p );
if( $num == 1 ) {
	header('Location: index.php?page=1');
}

$page .= '<form action="index.php?page='.$num.'" method="post">';
$page .= $lang->message( 'step'.$p, 'introduction' ).'<p/>';

include_once 'step'.$p.'.php';
if( function_exists('doAction') ) {
	@list( $content, $noNext, $noPrev ) = doAction();
	$page .= $content;
}

$page .= <<< END
		</td>
	</tr>
	<tr>
		<td align="center">
END;

if( $num >= 3 ) {
	if( isset( $noPrev ) && $noPrev ) {
		$page .= '<input class="formInput" type="submit" name="submit" value="'.$lang->message( 'general', 'previous' ).'" disabled/>';
	} else {
		$page .= '<input class="formInput" type="submit" name="submit" value="'.$lang->message( 'general', 'previous' ).'"/>';
	}
}
if( isset( $noNext ) && $noNext ) {
	$page .= '<input class="formInput" type="submit" name="submit" value="'.$lang->message( 'general', 'next' ).'" disabled/>';
} else {
	$page .= '<input class="formInput" type="submit" name="submit" value="'.$lang->message( 'general', 'next' ).'"/>';
}

$page .= <<< END
</form>
</td>
</tr>
</table>
</body>
</html>
END;

echo $page;