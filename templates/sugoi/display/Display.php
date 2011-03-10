<?
$template['addComment'] = <<< END
<form action="@var->site;@var->page;?comments=save&post=@var->post;" method="post">
<input type="hidden" name="parent" value="@var->parent;"/>
	<table align="center">
		<tr>
			<td>@lang->yourName;:</td>
			<td><input type="text" name="yourName" length="20" maxlength="40" style="height:15px; margin:0px; padding:0px; font-size:10px; font-family:verdana; background-color:#9BCEEB; border:1px solid #ffffff;"/></td>
		</tr>
		<tr>
			<td>@lang->subject;:</td>
			<td><input type="text" name="subject" length="30" maxlength="50" style="height:15px; margin:0px; padding:0px; font-size:10px; font-family:verdana; background-color:#9BCEEB; border:1px solid #ffffff;"/></td>
		</tr>
		<tr>
			<td>@lang->comment;:</td>
			<td><textarea name="comments" cols="40" rows="15" style="margin:0px; padding:0px; font-size:10px; font-family:verdana; background-color:#9BCEEB; border:1px solid #ffffff;">@lang->enterComment;</textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td><td><input type="submit" name="submit" value="@lang->addComment;" style="margin:0px; padding:0px; font-size:10px; font-family:verdana; background-color:#9BCEEB; border:1px solid #ffffff;"/></td>
		</tr>
	</table>
<form>
END;

$template['readComment'] = <<<END
<table align="center">
	<tr>
		<td>@lang->author;:</td>
		<td bgcolor="#FFFFFF">@var->userName;</td>
	</tr>
	<tr>
		<td>@lang->subject;:</td>
		<td bgcolor="#FFFFFF">@var->subject;</td>
	</tr>
	<tr>
		<td>@lang->comment;:</td>
		<td bgcolor="#FFFFFF">@var->comment;</td>
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