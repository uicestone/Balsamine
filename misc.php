<?php
define('IN_UICE','misc');
require 'config.php';

if(!is_logged())
	require "login.php";

if(got('logout'))
	require "login.php";

elseif(got('profile'))
	require "source/profile.php";
?>