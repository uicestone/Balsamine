<?php
define('IN_UICE',true);
require "config.php";
require 'html/common/head.php';
?>
<div id="article">
<h1>六月花蕾 Flower Bud 公司介绍</h1>
<p>Flower Bud六月花蕾日用化妆品有限公司是致力于健康环保型化妆品研发的专业化妆品公司。</p>
<p>该公司旗下的宝莎曼纯植物染发护发系列产品是最被看好的产品之一。为了确保源材料的质量，保证客户的健康，宝莎曼公司在印度土壤最佳的源生态地区不惜重金打造了一个有机植物种植基地，并且由当地种植经验最丰富的原住民精心培育和筛选最优质的植物作为化妆品的原料，在最新鲜的时候采摘和初加工，最大程度保留了植物中的有效成分，再送至宝莎曼实验基地进行严格的质量检验和深度提取和精加工。宝莎曼公司确保所生产的每一个产品都经过多道质量把关，并为纯植物产品，不会添加任何有害人体健康的化学成分。宝莎曼公司多年的经验表明，89%的顾客满意并认可该品牌的纯植物染发系列产品，11%的顾客希望宝莎曼公司能研制出更多种类的产品以适合个性化和年轻化的顾客和群体。</p>
<p>我们向您承诺，我们会认真对待每一位顾客的建议和要求，尽力让使用宝莎曼产品的顾客感受到我们的关心和诚意。</p>
<br><br>
</div>
<div id="indexNews">
<h2>最新新闻
<? if(is_logged('admin')){?>
<a href="/news?add">添加</a>
<? }?>
</h2>
<?php
$q="SELECT * FROM news WHERE 1=1 ORDER BY time DESC";
$field=array(
	'title'=>array('title'=>'标题','surround'=>array('mark'=>'a','href'=>'/news?id={id}')),
	'time'=>array('title'=>'日期','eval'=>true,'content'=>"
		return date('Y-m-d',{time});
	")
);
exportTable($q,$field);
?>
</div>
<?php
require 'html/common/foot.php';
?>