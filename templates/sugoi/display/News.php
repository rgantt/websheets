<?php
$template['addNews'] = <<<END
<form name="newsForm"action="index.php?go=news&page=build" method="post">
<input type="hidden" name="time" value="@var->time;"/>
	<table>
		<tr>
			<td colspan="2"><input class="formInput" type="text" style="width:450px;" maxlength="50" value="@lang->subject;" name="subject"/></td>
		</tr>
		@var->mood;
		@var->listeningTo;
		<tr>
			<td align="center">
				<select name="catGet" class="formInput">
					<option>Choose Category</option>
					@var->catList;
				</select>
			</td>
			<td align="center">
				<table border="0">
					<tr>
						<td align="center"><img src="images/emoticon/icon_grin.gif" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+':)'"/></td>
						<td align="center"><img src="images/emoticon/icon_wink.gif" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+';)'"/></td>
						<td align="center"><img src="images/emoticon/icon_sad.gif" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+':('"/></td>
						<td align="center"><img src="images/emoticon/icon_tongue.gif" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+':P'"/></td>
						<td align="center"><img src="images/emoticon/icon_whatever.gif" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+':s'"/></td>
						<td align="center"><img src="images/emoticon/icon_straight.gif" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+':|'"/></td>
						<td align="center"><img src="images/emoticon/icon_coder.gif" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+':coder:'"/></td>
						<td align="center"><img src="images/emoticon/icon_pissed.gif" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+':angry:'"/></td>
						<td align="center"><img src="images/emoticon/icon_php.gif" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+':win:'"/></td>
						<td align="center"><img src="images/emoticon/icon_ninja.gif" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+':ninja:'"/></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<table border="0">
					<tr>
						<td><input type="button" class="formInput" value="@lang->bold;" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+'[b:][:b]'"/></td>
						<td><input type="button" class="formInput" value="@lang->italic;" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+'[i:][:i]'"/></td>
						<td><input type="button" class="formInput" value="@lang->url;" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+'[a:][:a]'"/></td>
						<td><input type="button" class="formInput" value="@lang->underline;" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+'[ul:][:ul]'"/></td>
						<td><input type="button" class="formInput" value="@lang->overline;" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+'[ol:][:ol]'"/></td>
						<td><input type="button" class="formInput" value="@lang->strike;" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+'[st:][:st]'"/></td>
						<td><input type="button" class="formInput" value="@lang->image;" onMouseDown="document.newsForm.newsMessage.value=document.newsForm.newsMessage.value+'[img:][:img]'"/></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><textarea style="width:450px; height:300px;" class="formInput" name="newsMessage">@lang->story;</textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="hidden" name="user" value="@user->user;"/><input class="formInput" type="submit" name="submit" value="@lang->post;"> <input class="formInput" type="reset" value="Clear Fields"/></td>
		</tr>
	</table>
</form>
END;

$template['realEdit'] = <<<END
<form method="post" action="index.php?go=news&page=saveEdit">
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td>@lang->subject;:</td>
			<td><input type="text" name="subject" value="@var->subject;" style="width:200px;" class="formInput" /></td>
		</tr>
		<tr>
			<td>@lang->author;:</td>
			<td>@var->author;</td>
		</tr>
		<tr>
			<td>@lang->category;:</td>
			<td>@var->category;</td>
		</tr>
		<tr>
			<td>@lang->news;:</td>
			<td><textarea name="news" rows="15" cols="100" class="formInput">@var->news;</textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="center"> @lang->keep;<input type="radio" name="delete" value="no" class="formInput" checked /> @lang->delete;<input type="radio" name="delete" value="yes" class="formInput" /></td>
		</tr>
	</table>
	<input type="hidden" name="id" value="@var->id;" />
	<input type="submit" name="submit" value="@lang->editNews;" class="formInput" />
</form>
END;

$template['editNews'] = <<<END
<table class="listTable" cellpadding="2" cellspacing="4">
	<tr>
		<td class="listTableHead">@lang->id;</td>
		<td class="listTableHead">@lang->subject;</td>
		<td class="listTableHead">@lang->author;</td>
		<td class="listTableHead">@lang->action;</td>
	</tr>
		@var->articles;
	<tr>
</table>
END;

$template['replaces'] = <<<END
<br/>There are no entries yet. If you are a registered user, you may login and <a href="@config->siteUrl;/@config->installDir;/index.php?go=news&page=add">post something</a>
END;