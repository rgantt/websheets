<?php
$q['getUserId'] = <<< END
select id from {0}_user where user='{1}'
END;

$q['loadUserTemplate'] = <<< END
select template from {0}_template where user='{1}'
END;

$q['loadDefaultTemplate'] = <<< END
select template from {0}_template where user='0'
END;
?>