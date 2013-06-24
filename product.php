<?php
define('IN_UICE',true);
require 'config.php';
require 'html/common/head.php';if(isset($_GET['id']) && !is_numeric($_GET['id']))//id不是数字，展示产品分类
	$cat=$_GET['id'];
elseif(isset($_GET['id']) && is_numeric($_GET['id']))//id是数字，展示单个产品
	$productID=$_GET['id'];
else//id未设置，展示所有产品
	$cat='all';
?>
<div id="productMenu">
    <div>
    	<a href="/product/dye.html"><img src="/images/products/dye.png" width="200" /></a>
    </div>
    <div>
    	<a href="/product/care.html"><img src="/images/products/care.png" width="200" /></a>
    </div>
    <div>
    	<img src="/images/products/wash.png" width="200" />
    </div>
    <div>
    	<img src="/images/products/latest.png" width="200" />
    </div>
</div>
<?php
if(isset($cat)){//展示产品分类
?>
<div id="productList">
<?php
	$condition= $cat=='all'?'1=1':"cat = '".$cat."'";
	$q_products="select * from products where ".$condition;
	$r_products=mysql_query($q_products,$link);
	while($products=mysql_fetch_array($r_products)){
?>
	<div class="productItem">
    	<a href="/product/<? echo $products['id'];?>.html" target="_blank"><img src="<? echo $products['pic'];?>" width="100" /></a>
        <div class="productIntro">
            <h3><a href="/product/<? echo $products['id'];?>.html" target="_blank"><? echo $products['name'];?></a></h3>
            <? echo $products['summary'];?>
        </div>
    </div>
<?php
	}
?>
</div>
<?php
}elseif(isset($productID)){//展示单个产品
	$q_product="select * from products where id = $productID";
	$r_product=mysql_query($q_product,$link);
	$product=mysql_fetch_array($r_product);
?>
<div id="article">
<h1><? echo $product['name']; ?></h1>
<? echo $product['content']; ?>
<br><br>
</div>
<div id="productSideShow">
	<img src="<? echo $product['pic'].'.side.jpg'; ?>" />
</div>
<?php
}
require 'html/common/foot.php';
?>