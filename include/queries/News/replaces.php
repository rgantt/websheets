<?
$q['resultNews'] = <<< END
select n.*, u.user from {0}_news n left join {1}_user u on u.user = n.user where n.user like '{2}' order by id desc limit 0,{3}
END;

$q['numComments'] = <<< END
select id from {0}_comment WHERE postId = '{1}'
END;

$q['nUser'] = <<< END
select * from {0}_user where user='{1}'
END;

$q['obCats'] = <<< END
select * from {0}_category where id='{1}'
END;
?>
