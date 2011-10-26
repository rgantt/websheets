<?php
function doAction() {
	$newsTemplateData = "<table>\n";	
	$newsTemplateData .= "\t<tr>\n";
	$newsTemplateData .= "\t\t<td>{subject}</td>\n";
	$newsTemplateData .= "\t\t<td>{time}</td>\n";
	$newsTemplateData .= "\t</tr>\n";
	$newsTemplateData .= "\t<tr>\n";
	$newsTemplateData .= "\t\t<td colspan=\"2\">{news}</td>\n";
	$newsTemplateData .= "\t</tr>\n";
	$newsTemplateData .= "\t<tr>\n";
	$newsTemplateData .= "\t\t<td><a href=\"mailto:{email}\">{news}</a></td>\n";
	$newsTemplateData .= "\t\t<td>{category}</td>\n";
	$newsTemplateData .= "\t</tr>\n";
	$newsTemplateData .= "</table>\n";
	
	$content = '<textarea name="template" class="formInput" style="font-size:12px; width:550px; height:350px;">'.$newsTemplateData.'</textarea><p/>';
	$content .= '<div align="center">[ <a target="_blank" href="../include/key/template.php">Template Keys</a> ]</div>';
	return array( $content, 0, true );
}