<?php
if(!defined('IN_UICE'))
	exit('Access Denied');

if(got('add'))
	$action='insertLogistics';
elseif(got('edit'))
	$action='replaceLogistics';

if(is_posted('submit/logistics')){//获取表单数据并校验

	$_SESSION['logistics']['post']=$_POST;

	foreach($_POST['logistics'] as $k => $v){
		if(!in_array($k,array('comment'))){
			if ($v==''){
				showMessage('表格未填写完整');$action='addLogistics';break;
			}
		}
	}

	if($action=='insertLogistics'){//处理插入数据请求

		$id=db_insert('logistics',$_SESSION['logistics']['post']['logistics']);//物流信息插入数据库
		db_insert('logistics_status',array('id'=>$id,'status'=>$_SESSION['logistics']['post']['logistics_status']['status'],'time'=>time()));//物流状态插入数据库
		
		$q_client_check = "SELECT * from `user` WHERE `username` ='".$_SESSION['logistics']['post']['logistics']['authorized']."'";
		$r_client_check = mysql_query($q_client_check);
		if(mysql_num_rows($r_client_check)==0){
			$password=rand(100000,999999);
			$newClient=array('username'=>$_SESSION['logistics']['post']['logistics']['authorized'],'password'=>$password,'group'=>'client');
			db_insert('user',$newClient);//新客户插入数据库
			showMessage("新客户用户名：".$_SESSION['logistics']['post']['logistics']['authorized']."密码：".$password);
		}

		showMessage('添加物流信息成功');
		unset($_SESSION['logistics']['post']);
	}
	if($action=='replaceLogistics'){//处理编辑数据请求

		$status=$_SESSION['logistics']['post']['status'];$_SESSION['logistics']['post']['id']=$_GET['id'];

		unset($_SESSION['logistics']['post']['status']);//将status从POST导出后注销
		db_insert('logistics',$_SESSION['logistics']['post'],true,true);//物流信息插入数据库
		if($status!=$_SESSION['logisticsData'][$_GET['id']]['status']){
			db_insert('logistics_status',array('id'=>$_SESSION['logistics']['post']['id'],'status'=>$status,'time'=>time()));//物流状态插入数据库
		}

		$q_client_check = "select * from `user` where `group` = 'client' and `username` ='".$_SESSION['logistics']['post']['authorized']."'";
		$r_client_check = mysql_query($q_client_check);
		if(mysql_num_rows($r_client_check)==0){
			$password=rand(100000,999999);
			$newClient=array('username'=>$_SESSION['logistics']['post']['authorized'],'password'=>$password,'group'=>'client');
			db_insert('user',$newClient);//新客户插入数据库
			echo "<script>alert(\"新客户用户名：".$_SESSION['logistics']['post']['authorized']."\\n密码：".$password."\")</script>";
		}

		unset($_SESSION['logistics']['post']);
		redirect('logistics');
	}
}
if(got('action','deleteLogistics')){//删除
	$id=$_GET['id'];
	$q_delete_logistics="delete from logistics where id = '$id'";
	$q_delete_logistics_status="delete from logistics_status where id = '$id'";
	mysql_query($q_delete_logistics);mysql_query($q_delete_logistics_status);
	redirect('logistics');
}

require 'html/logistics_add.php';
?>
</div>