<?php
if(!defined('IN_UICE'))
	exit('Access Denied');

if(isset($_GET['orderby']))
	$orderby=$_GET['orderby'];
else
	$orderby='lastmod';
	
if(isset($_GET['method']))
	$method=$_GET['method'];
else $method='desc';
?>
<script type="text/javascript">
function reOrder(orderBy){//此函数用来响应点击标题排序
	var method='<?php echo $method; ?>';
	if('<?php echo $orderby;?>'==orderBy){
		if ('<?php echo $method;?>'=='desc'){
			method='asc';
		}else{
			method='desc';
		}
	}
	location.href = "logistics.php?orderby="+orderBy+"&method="+method;
}
</script>
<div id="article">
<h1><a href="/logistics">物流信息登记</a><a href="logistics.php?action=addLogistics" style="position:relative;left:450px;font-size:20px;">添加</a></h1>
</div>
<div class="logisticsInfo">

<?php
$q="SELECT * FROM `logistics`,`logistics_status` where logistics.id=logistics_status.id  and authorized = '".$_SESSION['username']."'";

$field=Array('num'=>'货号','content'=>'货物','status'=>'物流状态','time'=>'时间','receiver'=>'收件人','comment'=>'备注');

exportTable($field, $q);
?>

</div>