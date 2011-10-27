<?php
$template['config'] = <<<END
<form name="config" action="index.php?go=configuration&page=save" method="post">
	<table cellpadding="5" cellspacing="0" border="0" style="width:450px;">
		<tr>
			<td>@lang->siteName;:</td>
			<td><input type="text" class="formInput" name="siteName" value="@config->siteName;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->subTitle;:</td>
			<td><input type="text" class="formInput" name="subTitle" value="@config->subTitle;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->siteUrl;:</td>
			<td><input type="text" class="formInput" name="siteUrl" value="@config->siteUrl;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->newsUrl;:</td>
			<td><input type="text" class="formInput" name="newsUrl" value="@config->newsUrl;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->installDir;:</td>
			<td><input type="text" class="formInput" name="installDir" value="@config->installDir;" style="width:200px;"/><br/><span style="color:red; font-size:9px;">@lang->dirMessage;</span></td>
		</tr>
		<tr>
			<td>@lang->numHeadlines;:</td>
			<td>
				<select name="maxNum" class="formInput">
					<option value="@config->maxHeadlines;">@config->maxHeadlines;</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="15">15</option>
					<option value="20">20</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>@lang->directionHeadlines;:</td>
			<td>
				<select name="direction" class="formInput">
					<option value="@config->headlineDirection;">@config->headlineDirection;</option>
					<option value="Horizontal">@lang->horizontal;</option>
					<option value="Vertical">@lang->vertical;</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>@lang->newsTimeFormat;:</td>
			<td><input class="formInput" type="text" name="timeFormat" value="@config->timeFormat;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td colspan="2" align="center">[ <a href="include/key/datetime.php" target="_blank">@lang->dateAndTimeSymbols;</a> ]</td>
		</tr>
		<tr>
			<td>@lang->messageTimeFormat;:</td>
			<td><input class="formInput" type="text" name="boardTime" value="@config->boardTime;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->serverOffset;:</td>
			<td>
				<select name="timeOffset" class="formInput">
					<option value="@config->timeOffset;" selected>GMT @var->sign; @var->absOffset; @lang->hours;</option>
					<option value="-12">GMT - 12</option>
					<option value="-11">GMT - 11</option>
					<option value="-10">GMT - 10</option>
					<option value="-9">GMT - 9</option>
					<option value="-8">GMT - 8</option>
					<option value="-7">GMT - 7 (PST)</option>
					<option value="-6">GMT - 6 (MST)</option>
					<option value="-5">GMT - 5 (CST)</option>
					<option value="-4">GMT - 4 (EST)</option>
					<option value="-3.5">GMT - 3.5</option>
					<option value="-3">GMT - 3</option>
					<option value="-2">GMT - 2</option>
					<option value="-1">GMT - 1</option>
					<option value="0">GMT</option>
					<option value="1">GMT + 1</option>
					<option value="2">GMT + 2</option>
					<option value="3">GMT + 3</option>
					<option value="3.5">GMT + 3.5</option>
					<option value="4">GMT + 4</option>
					<option value="4.5">GMT + 4.5</option>
					<option value="5">GMT + 5</option>
					<option value="5.5">GMT + 5.5</option>
					<option value="6">GMT + 6</option>
					<option value="6.5">GMT + 6.5</option>
					<option value="7">GMT + 7</option>
					<option value="8">GMT + 8</option>
					<option value="9">GMT + 9</option>
					<option value="9.5">GMT + 9.5</option>
					<option value="10">GMT + 10</option>
					<option value="11">GMT + 11</option>
					<option value="12">GMT + 12</option>
					<option value="13">GMT + 13</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>@lang->adminEmail;:</td>
			<td><input class="formInput" type="text" name="adminEmail" value="@config->adminEmail;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->postsPerPage;:</td>
			<td><input class="formInput" type="text" name="numPosts" value="@config->postsPerPage;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->xmlPostsToShow;:</td>
			<td><input class="formInput" type="text" name="xmlPostsToShow" value="@config->xmlPostsToShow;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->loginAttempts;:</td>
			<td><input class="formInput" type="text" name="maxAttempts" value="@config->maxAttempts;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->editArticles;:</td>
			<td><input class="formInput" type="text" name="numEdit" value="@config->numEdit;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->language;:</td>
			<td><input class="formInput" type="text" name="language" value="@config->language;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td>@lang->theme;:</td>
			<td><input class="formInput" type="text" name="theme" value="@config->theme;" style="width:200px;"/></td>		
		</tr>
		<tr>
			<td>@lang->perUserTemplates;:</td>
			<td>
				@lang->yes; <input class="formInput" type="radio" name="perUserTemplates" value="yes"/>
				@lang->no; <input class="formInput" type="radio" name="perUserTemplates" value="no"/>
				(@lang->currently; @var->perUser;)
			</td>
		</tr>
		<tr>
			<td>@lang->moodEntry;:</td>
			<td>
				@lang->yes; <input class="formInput" type="radio" name="moodEntry" value="yes"/>
				@lang->no; <input class="formInput" type="radio" name="moodEntry" value="no"/>
				(@lang->currently; @var->mood;)
			</td>
		</tr>
		<tr>
			<td>@lang->userTitles;:</td>
			<td>
				@lang->yes; <input class="formInput" type="radio" name="userTitles" value="yes"/>
				@lang->no; <input class="formInput" type="radio" name="userTitles" value="no"/>
				(@lang->currently; @var->titles;)
			</td>
		</tr>
		<tr>
			<td>@lang->listeningTo;:</td>
			<td>
				@lang->yes; <input class="formInput" type="radio" name="listeningTo" value="yes"/>
				@lang->no; <input class="formInput" type="radio" name="listeningTo" value="no"/>
				(@lang->currently; @var->listening;)
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" class="formInput" name="submit" value="@lang->saveConfiguration;"></td>
		</tr>
	</table>
</form>
END;
?>