<div id="article">
<script type="text/javascript">
function checkGuestbookForm(){
	if($('[name="guestbook_content"]').val()==''){
		alert("您还未留言");
		$('[name="guestbook_content"]').focus();
		return false;

	}else if($('[name="guest_name"]').val()==''){
		alert("您还未留下您的称呼");
		$('[name="guest_name"]').focus();
		return false;

	}else if($('[name="guest_contact"]').val()==''){
		alert("您还未留下联系方式");
		$('[name="guest_contact"]').focus();
		return false;

	}
	return true;
}
</script>
<?php
if(!defined('IN_UICE'))
	exit('Access Denied');

if(isset($_POST['guestbookSubmit'])){
	unset($_POST['guestbookSubmit']);
	$_POST['time']=time();
	$_POST['ip']=getIP();
	db_insert('guestbook',$_POST);
	echo "<h2>感谢您对我们的支持！</h2>";
}else{
?>
<h1>留言</h1>
<form name="guestbookForm" method="post" action="<? $PHPSELF; ?>" onsubmit="return checkGuestbookForm();">
<table width="675px" align="center">
<tr>
  <td>留言内容：</td>
  <td>
  <textarea name="guestbook_content" cols="39" rows="5" style="width:100%" /></textarea>
  </td>
</tr>
<tr>
  <td>您的称呼：</td>
  <td>
  <input name="guest_name"  type="text" maxlength="255" size="43" style="width:100%" />
  </td>
</tr>
<tr>
  <td>您的联系方式：</td>
  <td>
  <input name="guest_contact"  type="text" maxlength="255" size="43" style="width:100%" />
  </td>
</tr>
<tr>
  <td colspan="2">
    <input type="submit" name="guestbookSubmit" value="保存">
    <input type="button" value="返回" onClick="location.href='/'" />
  </td>
</tr>
</table>
</form>
</div>

<?php
}
?>