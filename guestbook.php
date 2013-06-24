<?php
define('IN_UICE',true);
require 'config.php';
require 'html/common/head.php';

if(is_logged('admin')){
	require "html/common/topmenu.php";
	require "source/guestbook_list.php";
}else
	require "source/guestbook_post.php";

require 'html/common/foot.php';
?>