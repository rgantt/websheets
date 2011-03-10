<?
$q['trueComs'] = <<< END
select id from {0}_comment
END;

$q['getPosts'] = <<< END
select id, subject from {0}_news order by id desc limit 0,9
END;

$q['comCount'] = <<< END
select * from {0}_comment where postId='{1}'
END;
?>
