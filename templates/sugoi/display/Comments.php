<?php
$template['edit'] = <<<END
<form method="post" action="index.php?go=comments&page=save&postid=@var->post;&id=@var->id;&save=yes">
	<table>
		<tr>
			<td>@lang->writer;:</td>
			<td>@var->userName;</td>
		</tr>
		<tr>
			<td>@lang->subject;:</td>
			<td><input class="formInput" name="subject" type="text" length="20" maxlength="50" value="@var->subject;"/></td>
		</tr>
		<tr>
			<td>@lang->content;:</td>
			<td><textarea class="formInput" name="comments" cols="35" rows="15">@var->comment;</textarea></td>
		</tr>
		<tr>
			<td>@lang->keep; <input type="radio" name="keep" value="keep" checked/></td>
			<td>@lang->remove; <input type="radio" name="keep" value="delete"/></td>
		</tr>
		<tr>
			<td colspan="2"><input class="formInput" type="submit" name="submit" value="@lang->edit;"/></td>
		</tr>
	</table>
</form>
END;

$template['viewPosts'] = <<< END
<table class="listTable" cellpadding="2" cellspacing="4">
	<tr>
		<td class="listTableHead">@lang->id;</td>
		<td class="listTableHead">@lang->subject;</td>
		<td class="listTableHead">@lang->com;</td>
	</tr>
	@var->listPosts;
	<tr>
		<td colspan="3" class="listTableHead" align="center" style="font-size:9px;">@lang->total;: @var->total;</td>
	</tr>
</table>
END;
?>