<div id="article">
<h1><a href="/logistics">物流信息登记</a></h1>
</div>
<div class="logisticsInfo">
<form method="post">
<table width="680px">
<tr>
  <td>货　　号：
  <input name="logistics[num]" value="<? displayPost('logistics/num'); ?>" type="text" maxlength="255" size="20">
  </td>
  <td>货　　物：
  <input name="logistics[content]" value="<? displayPost('logistics/content'); ?>" type="text" maxlength="255" size="20">
  </td>
</tr>
<tr>
  <td>目前状态：
  <input name="logistics_status[status]" value="<? displayPost('logistics_status/status'); ?>" type="text" maxlength="255" size="20">
  </td>
  <td>收件人　：
  <input name="logistics[receiver]" value="<? displayPost('logistics/receiver'); ?>" type="text" maxlength="255" size="20">
  </td>
</tr>
<tr>
  <td>授权账号：
  <input id="authorized" name="logistics[authorized]" value="<? displayPost('logistics/authorized'); ?>" type="text" maxlength="255" size="20">
  </td>
  <td>选　　择：
  <select onChange="document.getElementById('authorized').value=this.value;this.value='0'">
  <option value="0">从现有客户列表中选择</option>
<?php
$q_client="select * from `user` where `group` = 'client'";
$r_client=mysql_query($q_client,$link);
while($client=mysql_fetch_array($r_client)){
?>
  	<option value="<? echo $client['username']; ?>"><? echo $client['username']; ?></option>
<?php
}
?>
  </select>
  </td>
</tr>
<tr>
  <td colspan="2">备　　注：
  <input name="logistics[comment]" value="<? displayPost('comment'); ?>" type="text" maxlength="255" size="76">
  </td>
</tr>
<tr>
  <td colspan="2">
    <input type="submit" name="submit[logistics]" value="保存">
    <input type="button" value="返回" onClick="location.href='/logistics'" />
<?php
if($action=='editLogistics'){
?>
	<input type="button" value="删除" onClick="location.href='/logistics.php?action=deleteLogistics&id=<? echo $_GET['id']; ?>'" />
<?php
}
?>
  </td>
</tr>
</table>
</form>