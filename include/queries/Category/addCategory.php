<?php
$q['default'] = <<< END
select * from {0}_category where parent='0' order by name asc
END;