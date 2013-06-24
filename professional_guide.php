<?php
define('IN_UICE',true);
require 'html/common/head.php';if(!isset($_GET['id'])){
?>
<center style="position:relative;top:80px;">
<a href="/professional_guide/dye.html"><img src="/images/guide/dye.png" width="300" /></a>

<a href="/professional_guide/care.html"><img src="/images/guide/care.png" width="300" style="margin-left:200px;" /></a>
</center>
<?php
}elseif($_GET['id']=='dye'){
?>
<div id="article">
<h1>我要染发</h1>
<h2>您的头发是？</h2>
<table><tr>
<td>
	<a href="/professional_guide/dye/white.html"><img src="/images/guide/white.png" width="250"/></a><br>
</td>
<td>
	<a href="/professional_guide/dye/grey.html"><img src="/images/guide/grey.png" width="250" style="margin-left:80px;"/></a><br>
</td>
</tr>
</table>
</div>
<div id="dye" class="rightDecorate"></div>
<?php
	if(isset($_GET['aid']) && $_GET['aid']=='white'){
?>
<div id="article">
<h1>白发</h1>
<p>全白头发的顾客我们建议您选用深棕色或者黑色养发粉。</p>
<p>深棕色或者黑色来养发粉无护发效果，但相比赤褐色颜色更沉稳，可以很好的遮盖白发，使您拥有一头自然亮丽的秀发。</p>
<p>使用过深棕色和黑色养发粉两次以后，若想使头发颜色更加鲜亮，建议第三次养发可改选赤褐色染发粉染发，可使秀发颜色更饱满和自然。</p>
</div>
<?php
	}elseif(isset($_GET['aid']) && $_GET['aid']=='grey'){
?>
<div id="article">
<h1>花白</h1>
<p>花白头发的顾客建议您选用赤褐色养发粉。</p>
<p>赤褐色染发粉会根据白发的多少产生不同的上色效果，既有上色效果又有护理头发的作用，可以很好的遮盖白发，并且抑制白发生长速度。所以建议头发偏少或花白发色的顾客使用，可使秀发看上去更亮丽，更健康。</p>
</div>
<?php
	}elseif(isset($_GET['aid']) && $_GET['aid']=='black'){
?>
<div id="article">
<h1>黑发</h1>
<p>花白头发的顾客建议您选用赤褐色染发粉。</p>
<p>赤褐色染发粉会根据白发的多少产生不同的染发效果，既有染发效果又有护理头发的作用，可以很好的遮盖白发，并且抑制白发生长速度。所以建议头发偏少或花白发色的顾客使用，可使秀发看上去更亮丽，更健康。</p>
</div>
<?php
	}
}elseif($_GET['id']=='care'){
?>
<div id="article">
<h1>我要护发</h1>
<table><tr>
<td>
	<a href="/professional_guide/care/hair.html"><img src="/images/guide/hair.png" width="250" /></a><br>
</td>
<td>
	<a href="/professional_guide/care/skin.html" style="margin-left:80px;"><img src="/images/guide/skin.png" width="250" /></a><br>
</td>
</tr>
</table>
</div>
<div id="dye" class="rightDecorate"></div>
<?php
	if(isset($_GET['aid']) && $_GET['aid']=='hair'){
?>
<div id="article">
<h1>头发问题</h1>
<p>如果您的头发有一下问题：干枯、发梢分叉、暗淡无光、脆弱易断、化学染烫后秀发受损等问题，专家为您提供两种产品的建议供您选择。
天然护发粉——适合各种人群。提取植物中最有营养价值的成分，并且不带任何色素成分，经过精细的处理，使植物的营养价值能够充分被毛发吸收，并在头发上留下一层保护膜，是改善发质的最佳选择。使用后头发柔软亮泽，秀发一次比一次更健康。</p>
<p>赤褐色染发粉——适合各种人群，尤其是白发人群。提取植物中带有色素的部位，并且富含滋养成分，使用后能完美遮盖白发，并且对头发和头皮有护理作用，能抑制白发生长，激活毛囊，使新生的白发有少许黄色素，并且减少化学染烫后发质的损伤程度。</p>
</div>
<?php
	}elseif(isset($_GET['aid']) && $_GET['aid']=='skin'){
?>
<div id="article">
<h1>头皮问题</h1>
<p>草本养发粉——适合各种人群。提取植物中色素较少的部分，添加草药成分，能有效改善头皮的健康状况，保湿头皮，对脂溢性脱发，头皮瘙痒，轻度斑脱等头皮问题有显著帮助。此产品含少量色素，白发人群使用此产品时，白发呈淡黄色，黑发上无法上色。</p>
</div>
<?php
	}
}
require 'html/common/foot.php';
?>