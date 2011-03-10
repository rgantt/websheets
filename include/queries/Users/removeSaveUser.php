<?
$q['user'] = <<< END
select userLevel, user from {0}_user where user='{1}'
END;

$q['delete'] = <<< END
delete from {0}_user where user='{1}'
END;
?>
