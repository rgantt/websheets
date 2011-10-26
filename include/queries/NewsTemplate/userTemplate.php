<?php
$q['templateGet'] = <<< END
select template from {0}_template where user='{1}'
END;

$q['insert'] = <<< END
insert into {0}_template ( template, user ) values ( '<#NEWS#>', '{1}' )
END;

$q['templateGetInner'] = <<< END
select template from {0}_template where user='{1}'
END;