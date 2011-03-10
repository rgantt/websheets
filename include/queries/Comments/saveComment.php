<?
$q['update'] = <<< END
update {0}_comment set subject='{1}', comment='{2}' where id='{3}'
END;

$q['delete'] = <<< END
delete from {0}_comment where id='{1}'
END;
?>
