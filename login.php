<?php
define('IN_UICE','login');

require 'config.php';

if(got('logout')){//登出
	session_unset();
	session_destroy();
	redirect('login.php');
}

if(is_logged('login'))//检查是否已登陆
	redirect('/index');

if(is_posted('submit')){
	
	$q_user="SELECT * FROM user WHERE username = '".$_POST['username']."' AND password = '".$_POST['password']."'";

	$r_user=mysql_query($q_user,$link);

	if(mysql_num_rows($r_user)==1){

		$user=mysql_fetch_array($r_user);

		$_SESSION['id']=$user['id'];
		$_SESSION['user']=split(',',$user['group']);
		$_SESSION['username']=$user['username'];
		
		redirect('/logistics');

	}else{
		showMessage('名字或密码错','warning');
	}
}

require 'html/common/head.php';

require 'html/login.php';

require 'html/common/foot.php';
?>