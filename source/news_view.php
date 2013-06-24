<?php
if(!defined('IN_UICE'))
	exit();

$q_news="SELECT * FROM news WHERE id='".$_GET['id']."' LIMIT 1";
$r_news=mysql_query($q_news);
$news=mysql_fetch_array($r_news);

$news['content']='<p>'.str_replace("\n",'</p><p>',$news['content']).'</p>';

require 'html/news_view.php'
?>