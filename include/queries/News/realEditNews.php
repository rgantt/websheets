<?
$q['row'] = <<< STOP
select id, subject, time, user, cat, news from {0}_news WHERE id='{1}'
STOP;

$q['cats'] = <<< END
select name from {0}_category WHERE id='{1}'
END;
?>
