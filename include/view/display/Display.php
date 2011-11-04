<?php
$template['addComment'] = <<< END
<form action="@var->site;@var->page;?comments=save&post=@var->post;" method="post">
<input type="hidden" name="parent" value="@var->parent;"/>
	<table align="center">
		<tr>
			<td>@lang->yourName;:</td>
			<td><input type="text" name="yourName" /></td>
		</tr>
		<tr>
			<td>@lang->subject;:</td>
			<td><input type="text" name="subject" /></td>
		</tr>
		<tr>
			<td>@lang->comment;:</td>
			<td><textarea name="comments" cols="40" rows="15">@lang->enterComment;</textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="@lang->addComment;" /></td>
		</tr>
	</table>
<form>
END;

$template['readComment'] = <<<END
<table align="center">
	<tr>
		<td>@lang->author;:</td>
		<td>@var->userName;</td>
	</tr>
	<tr>
		<td>@lang->subject;:</td>
		<td>@var->subject;</td>
	</tr>
	<tr>
		<td>@lang->comment;:</td>
		<td>@var->comment;</td>
	</tr>
	<tr>
		<td colspan="2"><a href="@var->url;?comments=add&post=@var->post;&parent=@var->id;">Respond to this Comment</td>
	</tr>
	<tr>
		<td colspan="2"><a href="@var->url;">@lang->returnToNews;</a></td>
	</tr>
	<tr>
		<td colspan="2"><a href="@var->url;?comments=see&post=@var->post;">@lang->otherComments;</a></td>
	</tr>
</table>
END;
?>