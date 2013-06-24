<?php
function is(&$k,$v,$method=NULL){
	if(is_null($method) || $method=='=')
		return (isset($k) && $k==$v)?true:false;
	if($method=='>')
		return (isset($k) && $k>$v)?true:false;
	if($method=='>=')
		return (isset($k) && $k>=$v)?true:false;
	if($method=='<')
		return (isset($k) && $k<$v)?true:false;
	if($method=='<=')
		return (isset($k) && $k<=$v)?true:false;
}

function got($variable,$value=NULL){
	if(is_null($value))
		return isset($_GET[$variable])?true:false;
	if(!is_null($value))
		return (isset($_GET[$variable]) && $_GET[$variable]==$value)?true:false;
}

function is_posted($variableString,$value=NULL){
	if(is_null($value))
		return is_null(array_dir('_POST/'.$variableString))?false:true;
	if(!is_null($value))
		return (!is_null(array_dir('_POST/'.$variableString)) && array_dir('_POST/'.$variableString)==$value)?true:false;
}

function sessioned($variable,$value=NULL,$global=true){
	if($global){
		if(is_null($value)){
			return isset($_SESSION[$variable])?true:false;
		}elseif(isset($_SESSION[$variable]) && $_SESSION[$variable]==$value)
			return true;
		else
			return false;
	}else{
		if(is_null($value)){
			return isset($_SESSION[IN_UICE][$variable])?true:false;
		}elseif(isset($_SESSION[IN_UICE][$variable]) && $_SESSION[IN_UICE][$variable]==$value)
			return true;
		else
			return false;
	}
}

function optioned($variable,$value=NULL){
	if(is_null($value))
		return isset($_SESSION[IN_UICE]['option'][$variable])?true:false;
	else
		return (isset($_SESSION[IN_UICE]['option'][$variable]) && $_SESSION[IN_UICE]['option'][$variable]==$value)?true:false;
}

function is_serialized($string){
	if(@unserialize($string)){
		return true;
	}else{
		return false;
	}
}

function is_logged($checkType=NULL){
	if(is_null($checkType) || $checkType=='login'){
		if(!isset($_SESSION['user'])){
			return false;
		}
	}elseif(!isset($_SESSION['user']) || !in_array($checkType,$_SESSION['user'])){
		session_unset();
		session_destroy();
		return false;
	}

	/*
	preparePermission();

	$q_get_notifies="SELECT COUNT(*) FROM notify WHERE unread=1 AND receiver='".$_SESSION['id']."'";
	$r_get_notifies=mysql_query($q_get_notifies);
	$a_get_notifies=mysql_fetch_array($r_get_notifies);
	$_SESSION['notifies']=$a_get_notifies[0];
	*/
	//未读新消息数
	
	return true;
}

function is_permitted($affair,$action=NULL,$mod=NULL){
	if(is_null($mod)){
		if(isset($_SESSION['permission'][$affair])){
			if(is_null($action)){
				return true;
			}
			else{
				return isset($_SESSION['permission'][$affair][$action]) && in_array(true,$_SESSION['permission'][$affair][$action])?true:false;
			}
		}else
			return false;
	}else{
		if(isset($_SESSION['permission'][$affair.'_'.$mod])){
			if(is_null($action)){
				return true;
			}
			else{
				return isset($_SESSION['permission'][$affair.'_'.$mod][$action]) && in_array(true,$_SESSION['permission'][$affair.'_'.$mod][$action])?true:false;
			}
		}else
			return false;
	}
}

function getIP(){
	if(isset($_SERVER['HTTP_CLIENT_IP'])){
		 return $_SERVER['HTTP_CLIENT_IP'];
	}elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		 return $_SERVER['REMOTE_ADDR'];
	}
}

function redirect($url,$method='php',$unsetPara=NULL){
	if($method=='php'){
		if(is_null($unsetPara)){
			header("location:".$url);
		}else{
			$query_string='?';
			$glue='';
			foreach($_GET as $k=>$v){
				if($k!=$unsetPara){
					$query_string.=$glue.$k.'='.$v;
					$glue='&';
				}
			}
			header('location:'.$q);//待开发
		}
	}
	elseif($method=='js')
		echo '<script>'.(is_null($unsetPara)?"location.href='".$url."'":"location.href=unsetURLPar('".$url."','".$unsetPara."')").'</script>';

	exit;
}

function refreshParentContentFrame(){
	echo '<script type="text/javascript">window.opener.parent.contentFrame.location.reload();</script>';
}

function closeWindow(){
	echo '<script type="text/javascript">window.close();</script>';
}

function displayPost($fieldName,$return=false){
	$val=array_dir('_SESSION/'.IN_UICE.'/post/'.$fieldName);
	if($return)
		return $val;
	else
		echo $val;
}

function returnex(&$str){
	if(isset($str))
		return $str;
	else return NULL;
}

function showMessage($message,$type='notice'){
	echo "<div class='message ".$type."'>".$message."</div>";
}

function str_getSummary($str,$length=80){
	if(strlen($str)>=$length-3){
		for($i=0;$i<$length;$i++){
			$temp_str=substr($str,0,1);
			if(ord($temp_str)>127){
				$i++;
				if($i<$length){
					$new_str[]=substr($str,0,3);
					$str=substr($str,3);
				}
			}else{
				$new_str[]=substr($str,0,1);
				$str=substr($str,1);
			}
		}
		return join($new_str).'…';
	}else{
		return $str;
	}
}

function array_trim($array){
	foreach($array as $k => $v){
		if($v=='' || $v==array()){
			unset($array[$k]);
		}elseif(is_array($v)){
			$array[$k]=array_trim($v);
		}
	}
	return $array;
}

function array_numkey_to_strkey($array){
	foreach($array as $k=>$v){
		if(is_numeric($k)){
			unset($array[$k]);
		}
	}
}

function array_dir($arrayindex,$setto=NULL){
/*
	用array_dir('/_SESSION/post/id')来代替$_SESSION['post']['id']
	仅适用于全局变量
	用is_null(array_dir(String $arrayindex))来判断是否存在此变量
	若指定$setto,则会改变$arrayindex的值
*/
	preg_match('/^[^\/]*/',$arrayindex,$match);
	$arraystr=$match[0];
	
	preg_match('/\/.*$/',$arrayindex,$match);
	$indexstr=$match[0];

	$indexstr=str_replace('/',"']['",$indexstr);
	$indexstr=substr($indexstr,2).substr($indexstr,0,2);
	
	if(is_null($setto))
		return eval('return returnex($'.$arraystr.$indexstr.');');
	else{
		eval('$'.$arraystr.$indexstr."=\$setto;");
	}
}

if (!function_exists('array_replace')){
	function array_replace(&$array_target, array &$array_source, $filterEmpty=false ){
	
		if(!isset($array_target)){
			$array_target=$array_source;
		}else{
			foreach($array_source as $k=>$v){
				if(is_array($v)){
					array_replace($array_target[$k],$v);
				}else{
					$array_target[$k]=$v;
				}
			}
		}
	}
}

function array_sub($array,$keyname){
	//将数组的下级数组中的某一key抽出来构成一个新数组
	$array_new=array();
	foreach($array as $key => $sub_array){
		if(isset($sub_array[$keyname])){
			$array_new[$key]=$sub_array[$keyname];
		}
	}
	return $array_new;
}

function db_fetch_array_no_numkey($resource){
	$array=mysql_fetch_array($resource);
	foreach((array)$array as $k => $v){
		if(is_numeric($k)){
			unset($array[$k]);
		}
	}
	return $array;
}

function db_insert($table, $data, $return_insert_id = true, $replace = false) {

	$sql = db_implode_field_value($data);

	$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
	
	if(IN_UICE!='cron'){
		//showMessage( "$cmd `$table` SET $sql",'notice');exit;
	}

	$return = mysql_query("$cmd `$table` SET $sql");

	return $return_insert_id ? mysql_insert_id() : $return;

}

function db_update($table, $data, $condition) {

	$sql = db_implode_field_value($data);

	$cmd = 'UPDATE';

	//showMessage ("$cmd `$table` SET $sql where $condition",'warning');exit;

	$return = mysql_query("$cmd `$table` SET $sql where $condition");
	
	return $return;
}

function db_implode_field_value($array, $glue = ',',$keyname=NULL,$equalMark='=',$mark_for_v_l="'",$mark_for_v_r="'", $mark_for_k='`',$value_type='value') {
	if(!is_null($keyname)){
		$keyname_array=split('\.',$keyname);
		$keyname=$glue_keyname='';
		foreach($keyname_array as $k=>$v){
			$keyname.=$glue_keyname.$mark_for_k.$v.$mark_for_k;
			$glue_keyname='.';
		}
	}
	$sql = $comma = '';
	foreach ((array)$array as $k => $v) {
		$sql .= $comma.(is_null($keyname)?$mark_for_k.$k.$mark_for_k:$keyname).$equalMark.$mark_for_v_l.($value_type=='value'?$v:$k).$mark_for_v_r;
		$comma = $glue;
	}
	return $sql;
}

function db_field_name($fieldNameStr){
	if(!preg_match('/\./',$fieldNameStr)){
		return '`'.$fieldNameStr.'`';
	}elseif(substr_count($fieldNameStr,'.')>1){
		return false;
	}else{
		preg_match('/(.*)\.(.*)/',$fieldNameStr,$match);
		return '`'.$match[1].'`.`'.$match[2].'`';
	}
}

function db_toArray($q){
	$r=mysql_query($q);
	$array=array();
	while($a=db_fetch_array_no_numkey($r)){
		$array[]=$a;
	}
	return $array;
}
?>