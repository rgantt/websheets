<?php
$template['head'] = <<<END
<html>
<head>
<title>@config->siteName; - @lang->poweredBy; &copy;</title>
<link rel="stylesheet" href="templates/@config->theme;/style/shell.css" type="text/css">
</head>
<body style="font-family:arial; background-color:#ffffff; margin-top:0px; margin-bottom:0px; margin-left:0px; margin-right:0px;">
<table align="center" cellpadding="0" cellspacing="0" style="font-family:arial; width:640px;">
<tr>
<td colspan="2" style="border-bottom:1px dashed #dddddd;" align="center"><img src="templates/@config->theme;/images/logo.jpg"/></td>
</tr>
<tr>
END;

$template['foot'] = <<<END
</div></td></tr>
</table>
</body>
</html>
END;

$template['showTime'] = <<<END
<div style="font-family:verdana; font-size:9px; color:#ff0000;">page generated in @var->time; seconds</div>
END;
?>