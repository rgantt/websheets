<?php
require_once 'config.php';

$news = new blargon\display\News( 'en-us' );
echo $news->replaces('%');