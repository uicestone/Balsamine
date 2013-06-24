<div id="article">
<h1><a href="/logistics">物流信息登记</a><a href="logistics.php?add" style="position:relative;left:450px;font-size:20px;">添加</a></h1>
</div>
<?php
$q="SELECT * FROM `logistics_status`,`logistics` WHERE time in (SELECT MAX(time) FROM logistics_status GROUP BY logistics_status.id) and logistics.id = logistics_status.id";

$field=array('num'=>'货号','content'=>'货物','status'=>'物流状态','time'=>'更新时间','receiver'=>'收件人','comment'=>'备注','authorized'=>'授权查看');

exportTable($q,$field);
?>