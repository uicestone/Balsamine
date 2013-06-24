<?php
define('IN_UICE','logistics');
require 'config.php';
require 'html/common/head.php';

if(!is_logged())
	redirect('login.php');
else
	require "html/common/topmenu.php";

if(got('logout'))
	require "login.php";

elseif(got('profile'))
	require "source/profile.php";
	
elseif(got('add') || got('edit'))
	require 'source/logistics_add.php';

else
	require 'source/logistics_list.php';

require 'html/common/foot.php';
?>