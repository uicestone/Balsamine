<?php
if(!defined('IN_UICE'))
	exit('Access Denied');
?>
<div id="article">
<h1>留言</h1>
</div>
<div class="logisticsInfo">
<?php
$q="SELECT * FROM `guestbook` where 1=1";

$field=Array('guestbook_content'=>'内容','guest_name'=>'称呼','guest_contact'=>'联系方式','time'=>'时间');

exportTable($q,$field);
?>
</div>