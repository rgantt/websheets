<?php
$template['head'] = <<<END
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>@lang->poweredBy;</title>
		<link rel="stylesheet" href="@config->template_dir;/style/websheets.css" type="text/css" />
		<link rel="stylesheet" href="@config->template_dir;/style/notifier.css" type="text/css" />
	</head>
	<body>
		<header>
			<img src="@config->template_dir;/images/logo.jpg"/>
		</header>
END;

$template['foot'] = <<<END

		</article>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		<script type="text/javascript" src="@config->template_dir;/javascript/notifier.js"></script>
	</body>
</html>
END;

$template['showTime'] = <<<END
<div id="loadTime">page generated in @var->time; seconds</div>
END;
?>