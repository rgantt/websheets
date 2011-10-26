<?php
$template['entry'] = <<<END
	<tr>
		<td class="listTableCell">[ (@var->time;) <b><a href="mailto:@var->email;">@var->name;</a></b> ]: @var->entry;</td>
	</tr>
END;
?>