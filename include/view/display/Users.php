<?php
$template['editUser'] = <<<END
<form method="post" action="index.php?go=user&page=doEdit">
	<table cellpadding="4" cellspacing="0" border="0">
		<tr>
			<td style="font-size:20px;"><b>@user->user;</b></td>
			<td style="font-size:12px;"><b>(@lang->userLevel;: @user->level;)</b></td>
		</tr>
		<tr>
			<td>@lang->currentPassword;:</td>
			<td><input class="formInput" type="password" name="oldPass" value=""/><br/><span style="font-size:9px; color:#ff0000;">@lang->passMustEnter;</span></td>
		</tr>
		<tr>
			<td>@lang->newPassword;:</td>
			<td><input class="formInput" type="password" name="newPass" value=""/></td>
		</tr>
		<tr>
			<td>@lang->repeatNew;:</td>
			<td><input class="formInput" type="password" name="repeatNew" value=""/></td>
		</tr>
		<tr>
			<td>@lang->email;:</td>
			<td><input class="formInput" type="text" name="email" value="@user->email;"/></td>
		</tr>
		<tr>
			<td>@lang->alias;:</td>
			<td><input class="formInput" type="text" name="alias" value="@user->alias;"/></td>
		</tr>
		@user->title;
		<tr>
			<td>@lang->avatarImage;:</td>
			<td>
				<select name="avatar" class="formInput">
					<option value="@user->avatar;">@user->avatar;</option>
					@var->listAvatars;
				</select> [ <a href="index.php?go=user&page=uploadAvatar">@lang->uploadAvatar;</a> ]
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input class="formInput" type="submit" name="submit" value="@lang->changeUser;"/></td>
		</tr>
	</table>
</form>
END;

$template['addUser'] = <<< END
@lang->createUser;
<p/>
<form name="form" action="index.php?go=user&page=save" method="post">
	<table cellpadding="5" cellspacing="0" border="0">
		<tr>
			<td>@lang->userName;:</td>
			<td><input class="formInput" type="text" name="newUserName" size="20" maxlength="20" /></td>
		</tr>
		<tr>
			<td>@lang->password;:</td>
			<td><input class="formInput" type="password" name="newPass" size="20" maxlength="20" /></td>
		</tr>
		<tr>
			<td>@lang->repeat;:</td>
			<td><input class="formInput" type="password" name="repeatPass" size="20" maxlength="20" /></td>
		</tr>
		<tr>
			<td>@lang->email;:</td>
			<td><input class="formInput" type="text" name="newEmail" size="20" maxlength="30" /><br/><span style="font-size:9px; color:#ff0000;">@lang->willBeMailed;</span></td>
		</tr>
		<tr>
			<td>@lang->alias;:</td>
			<td><input class="formInput" type="text" name="newAlias" size="20" maxlength="20" /></td>
		</tr>
		<tr>
			<td>@lang->avatarImage;:</td>
			<td><input class="formInput" type="text" name="avatar" size="20" maxlength="100" /><br/><span style="font-size:9px; color:#ff0000;">@lang->defaultIs; @config->siteUrl;@config->installDir;/images/avatar/</span></td>
		</tr>
		<tr>
			@var->userLevel;
			<td align="center" colspan="2"><input class="formInput" type="submit" value="@lang->doCreate;" name="submit"/></td>
		</tr>
	</table>
	<p/>
	<span style="font-size:9px; color:#ff0000;">@lang->canNotRecover;</span>
</form>
END;

$template['removeUser'] = <<<END
@lang->pleaseSelect;<p>
<form action="index.php?go=user&page=removeSave" method="post">
	<table cellpadding="5" cellspacing="0" border="0">
		<tr>
			<td>@lang->selectUser;:</td>
			<td>
			<select class="formInput" name="removeUser">
			@var->users;
			</select>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><input class="formInput" type="submit" value="@lang->removeUser;" name="submit">
		</tr>
	</table>
	<p/><center><span style="color:red;">@lang->warning;</span></center>
</form>
END;

$template['uploadAvatar'] = <<<END
<form action="index.php?go=user&page=doUploadAvatar" enctype="multipart/form-data" method="post">
	<table>
		<tr>
			<th colspan="2">@lang->uploadAvatar;</th>
		</tr>
		<tr>
			<td>@lang->destination;:</td>
			<td><input type="text" name="fileName" class="formInput" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->fileToUpload;:</td>
			<td><input type="file" name="avatar" class="formInput" style="width:200px;"/></td>
		</tr>
		<tr>
			<th colspan="2"><input type="submit" name="submit" class="formInput" value="@lang->uploadAvatar;"/></th>
		</tr>
	</table>
</form>
END;
?>