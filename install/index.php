<?php
require_once '../config.php';

use blargon\lang\Language;

$lang = new Language('install');

$page = <<< END
<html>	
	<head>
		<title>websheets installation</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
			<img src="../include/view/images/logo.jpg" alt="websheets" align="center"/>
		<p/>
		<table align="center">
			<tr>
				<td>
END;

if( isset( $_POST['submit'] ) && strtolower( $_POST['submit'] ) == strtolower( $lang->message( 'general', 'previous' ) ) ) {
	$p = $_GET['page'] - 1;
} else {
	$p = isset( $_GET['page'] ) ? $_GET['page'] : 0;
}
$num = ( !isset( $_GET['page'] ) ? 1 : $p + 1 );

$page .= "<form action=\"?page={$num}\" method=\"post\">";
echo $p;
$page .= $lang->message( 'step'.$p, 'introduction' ).'<p/>';

@include_once 'step'.$p.'.php';
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