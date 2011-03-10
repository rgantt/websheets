<?
$template['addCategory'] = <<<END
<form method="post" action="index.php?go=category&page=save">
	<table cellpadding="5" cellspacing="0" border="0">
		<tr>
			<td colspan="2" align="center">@lang->createNewCategory;</td>
		</tr>
		<tr>
			<td>@lang->newCategoryName;:</td>
			<td align="center"><input class="formInput" type="text" length="20" maxlength="30" name="newCat"></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><input class="formInput" type="submit" name="submit" value="@lang->createCategory;"></td>
		</tr>
	</table>
</form>
<p/><br/><p/>
<table>
	<tr>
		<td>@lang->editExistingCategory;</td>
		@var->catsList;
</table>
END;

$template['editCategory'] = <<< END
<form method="post" action="index.php?go=category&page=doSave">
	<table cellpadding="5" cellspacing="0" border="0">
		<tr>
			<td>@lang->categoryName;:</td>
			<td><input class="formInput" type="text" length="20" maxlength="40" name="newCatName" value="@var->name;"/><input class="formInput" type="hidden" name="catName" value="@var->name;"/></td>
		</tr>
		<tr>
			<td>@lang->categoryAlias;:</td>
			<td><input class="formInput" type="text" length="20" maxlength="40" name="catShortName" value="@var->shortName;"/></td>
		</tr>
		<tr>
			<td>@lang->categoryImage;:</td>
			<td><input class="formInput" type="text" length="20" maxlength="40" name="catImage" value="@var->image;"/><font style="font-size:9px; color:black;"><br/>@lang->defaultDirectory; @var->siteUrl;@var->installDir;/images/categories/</font></td>
		</tr>
		<tr>
			<td>@lang->categoryHomepage;:</td>
			<td><input class="formInput" type="text" length="20" maxlength="40" name="catHomePage" value="@var->homePage;"/> <font style="font-size:9px; color:black;"><br/>@lang->forExample; @var->siteUrl;@var->installDir;/yourcat/</font></td>
		</tr>
		<tr>
			<td>@lang->categoryParent;:</td>
			<td>
				@var->catsList;
			</td>
		</tr>
		<tr>
			<td align="right">@lang->keep;: <input type="radio" name="keep" value="yes" checked/></td>
			<td>@lang->delete;: <input class="formInput" type="radio" name="keep" value="no"/></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input class="formInput" type="submit" name="submit" value="@lang->editCategory;"/></td>
		</tr>
	</table>
</form>
END;
?>