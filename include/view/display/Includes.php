<?php
$template['head'] = <<<END
<html>
	<head>
		<title>@config->siteName; - @lang->poweredBy; &copy;</title>
		<link rel="stylesheet" href="@config->template_dir;/style/shell.css" type="text/css">
	</head>
	<body>
		<table align="center">
			<tr>
				<td colspan="2"><img src="@config->template_dir;/images/logo.jpg"/></td>
			</tr>
			<tr>
END;

$template['foot'] = <<<END
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>
END;

$template['showTime'] = <<<END
<div style="font-family:verdana; font-size:9px; color:#ff0000;">page generated in @var->time; seconds</div>
END;
?>