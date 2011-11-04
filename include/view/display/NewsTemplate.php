<?php
$template['mainTemplate'] = <<< END
<form name="editTemplate" method="post" action="index.php?go=template&page=saveMain">
	<table>
		<tr>
			<td align="center">@lang->newsPostTemplate;</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
						<input class="formInput" type="button" value="@lang->news;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{news}'"/>
						<input class="formInput" type="button" value="@lang->alias;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{alias}'"/>
						<input class="formInput" type="button" value="@lang->name;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{name}'"/>
						<input class="formInput" type="button" value="@lang->category;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{category}'"/>
						<input class="formInput" type="button" value="@lang->time;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{time}'"/>
						<input class="formInput" type="button" value="@lang->email;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{email}'"/>
						<input class="formInput" type="button" value="@lang->subject;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{subject}'"/>
						<input class="formInput" type="button" value="@lang->catIcon;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{caticon}'"/>
						<input class="formInput" type="button" value="@lang->seeCom;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{addcom}'"/>
						<input class="formInput" type="button" value="@lang->adCom;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{seecom}'"/>
						<input class="formInput" type="button" value="@lang->avatar;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{avatar}'"/>
			</td>
		</tr>
		<tr>
			<td align="center">
				<textarea class="formInput" name="template" rows="15">@var->template;</textarea>
			</td>
		</tr>
		<tr>
			<td align="center">
				<input class="formInput" type="submit" name="submit" value="@lang->editTemplate;" />
			</td>
		</tr>
	</table>
</form>
END;

$template['userTemplate'] = <<< END
<form name="editTemplate" method="post" action="index.php?go=template&page=saveUser">
	<table width="100%">
		<tr>
			<td align="center">News Post Template</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<table border="0">
					<tr>
						<td><input class="formInput" type="button" value="@lang->news;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{news}'"/></td>
						<td><input class="formInput" type="button" value="@lang->alias;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{alias}'"/></td>
						<td><input class="formInput" type="button" value="@lang->name;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{name}'"/></td>
						<td><input class="formInput" type="button" value="@lang->category;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{category}'"/></td>
						<td><input class="formInput" type="button" value="@lang->time;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{time}'"/></td>
						<td><input class="formInput" type="button" value="@lang->email;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{email}'"/></td>
						<td><input class="formInput" type="button" value="@lang->subject;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{subject}'"/></td>
						<td><input class="formInput" type="button" value="@lang->catIcon;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{caticon}'"/></td>
						<td><input class="formInput" type="button" value="@lang->seeCom;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{addcom}'"/></td>
						<td><input class="formInput" type="button" value="@lang->adCom;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{seecom}'"/></td>
						<td><input class="formInput" type="button" value="@lang->avatar;" onMouseDown="document.editTemplate.template.value=document.editTemplate.template.value+'{avatar}'"/></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="center">
				<textarea class="formInput" name="template" rows="15">@var->template;</textarea>
			</td>
		</tr>
		<tr>
			<td align="center">
				<input class="formInput" type="submit" name="submit" value="Edit Template">
			</td>
		</tr>
	</table>
</form>
END;
?>