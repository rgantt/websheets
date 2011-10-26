<?php
$q['delete'] = <<< END
delete from {0}_news where id='{1}'
END;

$q['update'] = <<< STOP
update {0}_news set news='{1}', subject='{2}' where id='{3}'
STOP;
?>