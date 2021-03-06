<?php
$q['comment'] = <<< END
create table {0}_comment (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	postId INT(5), 
	userName CHAR(40), 
	subject CHAR(50), 
	comment TEXT
)
END;

$q['category'] = <<< END
create table {0}_category (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	name CHAR(30), 
	image CHAR(40), 
	homePage CHAR(40), 
	shortName CHAR(20)
)
END;

$q['user'] = <<< END
create table {0}_user (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	user CHAR(20), 
	pass CHAR(60), 
	email CHAR(60), 
	alias CHAR(20), 
	avatar CHAR(50), 
	userLevel INT(1), 
	title varchar(255) not null default 'Bloggist' 
)
END;

$q['emote'] = <<< END
create table {0}_emote (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	emote VARCHAR(10) NOT NULL, 
	image VARCHAR(30) NOT NULL
)
END;

$q['template'] = <<< END
create table {0}_template (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	template TEXT, 
	user int(5) 
)
END;

$q['news'] = <<< END
create table {0}_news (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	subject CHAR(50), 
	time CHAR(50), 
	user CHAR(20), 
	cat CHAR(30), 
	news TEXT 
)
END;

$q['config'] = <<< END
create table {0}_config (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	entry char(255), 
	value char(255) 
)
END;

$q['attempts'] = <<< END
create table {0}_attempts (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	userId int, 
	time varchar(32), 
	addr varchar(32) 
)
END;
?>