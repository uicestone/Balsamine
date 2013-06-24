<?php
function exportTable($q_data,$field,$menu=NULL,$surroundForm=false,$surroundBox=true,$width=NULL,$align=NULL){
	/*
	输出一个表格
	$q_data:数据库查询语句,必须包含WHERE条件,留空为WHERE 1=1
	$field:输出表的列定义
		array(
			'查询结果的列名'=>'显示的列名',//此为简写
			'查询结果的列名'=>array(
					'title'=>'列的显示标题'
					'td_title'=>'标题单元格的HTML参数，如width=100px',
					'td'=>'内容单元格的HTML参数，如style="background:#0FF"',
					'surround_title'=>array(
							'mark'=>'标签名，如 a',
							'标签的属性名如href'=>'标签的值如http://www.google.com',
						)标题单元格文字需要嵌套的HTML标签
					'surround'
					'orderby'=>true,是否需要排序菜单
					'eval'=>false，'是否'将content作为源代码运行
					'content'=>'显示的内容，可以用如{client}来显示变量，{client}是数据库查询结果的字段名'
				)
		)
	*/
	//showMessage($q_data,'notice');

	$r_data=mysql_query($q_data);
	
	if($surroundForm){
		echo '<form method="post">';
	}

	if(isset($menu['head'])){
		echo
		'<div class="contentTableMenu"'.
			'align="'.(is_null($align)?'center':$align).'"'.
			'style="'.(is_null($width)?'':'width:'.$width.'px').'"'.
		'>'.
			$menu['head'].
		'</div>';
	}

	if($surroundBox){
		echo '<div class="contentTableBox">';
	}

	echo
	'<table class="contentTable" cellpadding="0" cellspacing="0"'. 
		'align="'.(is_null($align)?'center':$align).'"'. 
		'style="'.(is_null($width)?'':'width:'.$width.'px').'"'.
	'>'.
		'<thead><tr>';

	foreach($field as $k=>$v){
		if(!is_array($v))
			echo '<td><a href="javascript:post(\'orderby\',\''.$k.'\')">'.$v.'</a></td>';
		else{
			$str=$v['title'];
			if(isset($v['surround_title'])){
				$str=surround($str,$v['surround_title']);
			}elseif(!isset($v['orderby']) || $v['orderby']){
				$str=surround($str,array('mark'=>'a','href'=>'javascript:postOrderby(\''.$k.'\')'));
			}
			echo "<td ".returnex($v['td_title']).">".(is($str,'')?'&nbsp;':$str)."</td>";
		}
	}

	echo "</tr></thead>";

	echo "<tbody>";
	
	$line_id=1;
	while($data=mysql_fetch_array($r_data)){
		if($line_id%2==0)
			$tr='class="oddLine"';
		else
			$tr='';
		echo "<tr ".$tr.">";

		foreach($field as $k => $v)
			if(!is_array($v))
				echo '<td>'.($data[$k]==''?'&nbsp;':variableReplace($data[$k],$data)).'</td>';
			else{
				$str=isset($v['content']) ? $v['content'] : $data[$k];
				if(isset($v['surround'])){
					array_walk($v['surround'],'variableReplaceSelf',$data);
					$str=surround($str,$v['surround']);
				}
				$str=variableReplace($str,$data);
				if(is($v['eval'],true)){
					$str=eval($str);
				}
				echo "<td ".returnex($v['td']).">".(is($str,'')?'&nbsp;':$str)."</td>";
			}

		echo "</tr>";
		$line_id++;
	}
	echo "</tbody>";
	echo "</table>";

	if($surroundBox)
		echo "</div>";

	if(isset($menu['foot'])){
		echo '<div class="contentTableMenu" style="'.(is_null($width)?'':'width:'.$width.'px').'">';
		echo $menu['foot'];
		echo '</div>';
	}
	if($surroundForm){
		echo '</form>';
	}
}

function variableReplace($content,$data){
	while(preg_match('/{(\S*?)}/',$content,$match)){
		$content=str_replace($match[0],$data[$match[1]],$content);
	}
	return $content;
}

function variableReplaceSelf(&$content,$key,$data){
	while(preg_match('/{(\S*?)}/',$content,$match)){
		$content=str_replace($match[0],$data[$match[1]],$content);
	}
}

function surround($str,$surround){
	if($str=='')
		return '';
	
	$mark=$surround['mark'];
	unset($surround['mark']);
	$property=db_implode_field_value($surround,' ',NULL,'=','"','"','');
	return '<'.$mark.' '.$property.'>'.$str.'</'.$mark.'>';
	
}

function processSearch(&$q,$fields){
	if(is_posted('search_cancel')){
		unset($_SESSION[IN_UICE]['option']['in_search_mod']);
		unset($_SESSION[IN_UICE]['post']['keyword']);
		redirect($_SERVER['REQUEST_URI'],'js');
	}
	
	if(is_posted('searchSubmit')){
		$_SESSION[IN_UICE]['post']['keyword']=array_trim($_POST['keyword']);
		$_SESSION[IN_UICE]['option']['in_search_mod']=true;
	}
	
	if(optioned('in_search_mod',true)){
		
		$condition_search='';
		
		foreach($_SESSION[IN_UICE]['post']['keyword'] as $field => $keywords){
			
			$condition='';

			$condition=preg_split('/[\s]+|,/',$_SESSION[IN_UICE]['post']['keyword'][$field]);
			
			$condition=' AND ('.db_implode_field_value($condition,' AND ',db_field_name($field),' LIKE ',"'%","%'",'').')';
			
			$condition_search.=$condition;
			
		}
		$q.=$condition_search;
	}
		
	$search_bar='<form method="post" name="search">';
	foreach($fields as $field_table_name => $field_ui_name){
		$search_bar.=
			'<label>'.$field_ui_name.'：'.
			'<input type="text" name="keyword['.$field_table_name.']" value="'.displayPost('keyword/'.$field_table_name,true).'" onkeypress="keyPressHandler($(\'input[name=\"searchSubmit\"]\'))" /><br />'.
			'</label>';
	}
	
	$search_bar.='<input type="submit" name="searchSubmit" value="搜索" tabindex="0" />';
	if(optioned('in_search_mod',true)){
		$search_bar.='<input type="submit" name="search_cancel" value="取消搜索" tabindex="1" />';
	}
	$search_bar.='</form>';
	
	return $search_bar;
}

function processOrderby(&$q,$defaultOrder,$defaultMethod=NULL,$field_need_convert=array(),$only_table_of_the_page=true){

	if (!sessioned('orderby',NULL,false)){
		$_SESSION[IN_UICE]["orderby"]=$defaultOrder;
	}
	if (!sessioned('method',NULL,false)){
		$_SESSION[IN_UICE]["method"]=is_null($defaultMethod)?"ASC":$defaultMethod;
	}

	if($only_table_of_the_page && is_posted('orderby') && sessioned('orderby',NULL,false) && $_POST['orderby']==$_SESSION[IN_UICE]['orderby']){
		sessioned('method','ASC',false)?$_SESSION[IN_UICE]['method']='DESC':$_SESSION[IN_UICE]['method']='ASC';
	}
	
	if(is_posted('orderby')){
		$_SESSION[IN_UICE]['orderby']=$_POST['orderby'];
	}
	if(is_posted('method')){
		$_SESSION[IN_UICE]['method']=$_POST['method'];
	}
	
	$needConvert=in_array($_SESSION[IN_UICE]['orderby'],$field_need_convert);
	
	$q.= ' ORDER BY '.
		($needConvert?'convert(':'').
		db_field_name($_SESSION[IN_UICE]['orderby']).
		($needConvert?' USING GBK) ':' ').
		$_SESSION[IN_UICE]['method'];
}

function processMultiPage(&$q){
	$q_rows=$q;
	$q_rows=preg_replace('/^[\s\S]*?FROM /','SELECT COUNT(1) FROM ',$q_rows);
	$q_rows=preg_replace('/ORDER BY[^(^)]*?$/','',$q_rows);
	$a_rows=mysql_fetch_row(mysql_query($q_rows));
	$rows=$a_rows[0];
		
	if(is($_SESSION[IN_UICE]['list']['start'],$rows,'>'))
		$_SESSION[IN_UICE]['list']['start']=0;

	$_SESSION[IN_UICE]['list']['tableItems']=$rows;
	
	if(isset($_SESSION[IN_UICE]['list']['start']) && $_SESSION[IN_UICE]['list']['items']){
		if(is_posted('previousPage')){
			$_SESSION[IN_UICE]['list']['start']-=$_SESSION[IN_UICE]['list']['items'];
			if($_SESSION[IN_UICE]['list']['start']<0)
				$_SESSION[IN_UICE]['list']['start']=0;
			redirect($_SERVER['REQUEST_URI']);
		}elseif(is_posted('nextPage')){
			if($_SESSION[IN_UICE]['list']['start']+$_SESSION[IN_UICE]['list']['items']<$_SESSION[IN_UICE]['list']['tableItems'])
				$_SESSION[IN_UICE]['list']['start']+=$_SESSION[IN_UICE]['list']['items'];
			redirect($_SERVER['REQUEST_URI']);
		}elseif(is_posted('firstPage')){
			$_SESSION[IN_UICE]['list']['start']=0;
			redirect($_SERVER['REQUEST_URI']);
		}elseif(is_posted('finalPage')){
			$_SESSION[IN_UICE]['list']['start']=$rows - ($rows % $_SESSION[IN_UICE]['list']['items']);
			redirect($_SERVER['REQUEST_URI']);
		}
	}else{
		$_SESSION[IN_UICE]['list']['start']=0;
		$_SESSION[IN_UICE]['list']['items']=25;
	}
	
	$q.=" LIMIT ".$_SESSION[IN_UICE]['list']['start'].",".$_SESSION[IN_UICE]['list']['items'];
	
	$listLocator=($_SESSION[IN_UICE]['list']['start']+1)."-".
	($_SESSION[IN_UICE]['list']['start']+$_SESSION[IN_UICE]['list']['items']<$_SESSION[IN_UICE]['list']['tableItems']?($_SESSION[IN_UICE]['list']['start']+$_SESSION[IN_UICE]['list']['items']):$_SESSION[IN_UICE]['list']['tableItems']).'/'.$_SESSION[IN_UICE]['list']['tableItems'];
	
	$listLocator.=
		'<button type="button" onclick="post(\'firstPage\',true)">&lt;&lt;</button>'.
		'<button type="button" onclick="post(\'previousPage\',true)">&nbsp;&lt;&nbsp;</button>'.
		'<button type="button" onclick="post(\'nextPage\',true)">&nbsp;&gt;&nbsp;</button>'.
		'<button type="button" onclick="post(\'finalPage\',true)">&gt;&gt;</button>';
	return $listLocator;
}
?>