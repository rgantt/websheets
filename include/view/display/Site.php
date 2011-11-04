<?php
$template['config'] = <<<END
<form name="config" action="index.php?go=configuration&page=save" method="post">
	<table >
		<tr>
			<td>@lang->newsTimeFormat;:</td>
			<td><input class="formInput" type="text" name="timeFormat" value="@config->timeFormat;" style="width:200px;"/></td>
		</tr>
		<tr>
			<td colspan="2" align="center">[ <a href="include/key/datetime.php" target="_blank">@lang->dateAndTimeSymbols;</a> ]</td>
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
			<td>@lang->loginAttempts;:</td>
			<td>
				<input class="formInput" type="text" name="maxAttempts" value="@config->maxAttempts;"/>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="submit" class="formInput" name="submit" value="@lang->saveConfiguration;">
			</td>
		</tr>
	</table>
</form>
END;
?>