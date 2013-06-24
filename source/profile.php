<?php
if(!defined('IN_UICE'))
	exit('Access Denied');

if(isset($_POST['profileSubmit'])){
	$_GET['action']='updatePassword';
	if($_POST['password']!=$_POST['password_confirm']){
		echo "<div class='popinfo'>两次输入的密码不一致</div>";$_GET['action']='profile';
	}
	if($_GET['action']=='updatePassword'){
		$password=$_POST['password'];
		$query="update user set password = '$password' where id = '".$_SESSION['id']."'";
		mysql_query($query,$link);
		echo "<script>location.href=\"/logistics\"</script>";
	}
}
?>
<div id="article"><h1>设置密码</h1></div>
<div class="logisticsInfo">
<form name="login" method="post" action='<?$PHPSELF?>'>
   <table align="center" width="650px">
    <tr>
      <td>输入新密码：<input name="password" type="password" id="password" maxlength="18"></td>
    </tr>
    <tr>
      <td>确认新密码：<input name="password_confirm" type="password" id="password" maxlength="18"></td>
    </tr>
    <tr>
      <td colspan="2">
		   <input type="submit" name="profileSubmit" value="保存">
		   <input type="button" onclick="location.href='/logistics'" value="返回">
	  </td>
	</tr></table>

</form>
</div>