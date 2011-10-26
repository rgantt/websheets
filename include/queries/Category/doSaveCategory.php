<?php
$q['update'] = <<< END
update {0}_category set name='{1}', shortName='{2}', image='{3}', homePage='{4}', parent='{5}' where name='{6}'
END;

$q['delete'] = <<< END
delete from {0}_category where name='{1}'
END;