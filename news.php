<?php
define('IN_UICE','news');
require 'config.php';

if(got('add')){
	$action='news_add';
}else{
	$action='news_view';
}

require 'html/common/head.php';

require 'source/'.$action.'.php';

require 'html/common/foot.php';
?>