<?php
session_start();
date_default_timezone_set('Asia/Shanghai');

$host="localhost";
$sqluser="balsamine_f";
$sqlpassword="%$^&!)";

$link=mysql_connect("$host","$sqluser","$sqlpassword");
mysql_select_db("balsamine",$link);

mysql_query("SET NAMES 'UTF8'");

$_G['requireExport']=true;
$_G['currentTimestamp']=time();

require 'function/function_common.php';
require 'function/function_table.php';
?>


