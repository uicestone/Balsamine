<?php
if(!defined('IN_UICE'))
	exit('no permission');
	
if(got('edit')){//指定编辑某个新闻
	unset($_SESSION[IN_UICE]['post'][IN_UICE]);
	array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/id',$_GET['edit']);

}elseif(is_null(array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/id'))){//新新闻，临时起名，入库，获得sessionid

	array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/uid',$_SESSION['id']);
	array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/username',$_SESSION['username']);
	array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/time',$_G['currentTimestamp']);
	array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/display',0);

	db_insert(IN_UICE,array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE),false);
	array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/id',mysql_insert_id());
}

$q_news="SELECT * FROM news WHERE id='".array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/id')."'";
$r_news=mysql_query($q_news);
array_dir('_SESSION/'.IN_UICE.'/post/news',db_fetch_array_no_numkey($r_news));
//从数据库取得当前id新闻数据

$submitable=false;//可提交性，false则显示form，true则可以跳转

if(is_posted('newsSubmit')){
	$submitable=true;
	
	array_replace($_SESSION[IN_UICE]['post'][IN_UICE],array_trim($_POST[IN_UICE]));
	
	if(array_dir('_POST/'.IN_UICE.'/title')==''){
		$submitable=false;
		showMessage('请填写标题','warning');
	}
	
	array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/uid',$_SESSION['id']);
	array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/username',$_SESSION['username']);
	array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/time',$_G['currentTimestamp']);
	array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/display',1);

	if($submitable && db_update(IN_UICE,array_dir('_SESSION/'.IN_UICE.'/post/news'),"id='".array_dir('_SESSION/'.IN_UICE.'/post/'.IN_UICE.'/id')."'")){

		unset($_SESSION[IN_UICE]['post'][IN_UICE]);
		
		redirect('/index');
	}else{
		showMessage('新闻更新错误','warning');
	}
}

require 'html/news_add.php';
?>