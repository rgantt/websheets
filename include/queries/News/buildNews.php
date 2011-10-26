<?php
$q['default'] = <<< END
insert into {0}_news ( time, subject, user, mood, listeningTo, cat, news ) VALUES ( '{1}', '{2}', '{3}', '{4}', '{5}', '{6}', '{7}' )
END;