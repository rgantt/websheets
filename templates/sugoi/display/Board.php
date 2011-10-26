<?php
$template['board'] = <<<END
<form method="post" action="index.php?go=board&page=saveEntry">
	<table cellpadding="5" cellspacing="5" style="width:440px;">
		<tr>
			<td>
				<table class="homeTable" height="100%">
					<tr>
						<td class="listTableHead">[<b>@config->siteName;</b>] @lang->userBoard;</td>
					</tr>
					<tr>
						<td width="100%">
							<table width="100%" class="boardTableCell" style="margin-top:5px; margin-bottom:5px;">
								@var->entries;
							</table>
						</td>
					</tr>
					<tr>
						<td><input class="formInput" style="width:100%;" type="text" name="message" value="<@lang->enterMessage;>"/></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="submit" class="formInput" value="@lang->postMessage;"/></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
END;