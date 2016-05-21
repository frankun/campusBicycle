<?php
header("Content-type: text/html; charset=utf-8");
//echo '2';exit;
include ("conn.php");
/*
 写入用户信息(创建新用户)
 url:postUserinfo
 param:String wechatId,String wechatName,String gender,String headImgUrl,Number createAt
 return:{"status":"0"}
 */
/*
 $_POST['wechatId']='1234';
 $_POST['wechatName']='we';
 $_POST['gender']=0;
 $_POST['headImgUrl']='wer';
 $_POST['createAt']='201202020202';
 */

if (isset($_POST['wechatId']) AND isset($_POST['wechatName']) AND isset($_POST['gender']) AND isset($_POST['headImgUrl']) AND isset($_POST['createAt'])) {
	$wechatId = $_POST['wechatId'];
	$wechatName = $_POST['wechatName'];
	$gender = $_POST['gender'];
	$headImgUrl = $_POST['headImgUrl'];
	$createAt = $_POST['createAt'];
} else {
	$error1 = array("status" => "101", "des" => "缺少@post参数String wechatId,String wechatName,String gender,String headImgUrl,Number createAt");
	echo json_encode($error1);
	exit ;
}

$query = mysql_query("INSERT INTO `bike_user` (id,wechatId,wechatName,gender,headImgUrl,createAt) 
VALUES (null,'$wechatId','$wechatName','$gender','$headImgUrl','$createAt')");
if ($query) {
	$result = array("status" => 0, "des" => "插入成功", );

	echo json_encode($result);
} else {

	$result = array("status" => 102, "des" => "数据库插入失败", );

	echo json_encode($result);
}

//echo $query;
mysql_close($con);
?>

