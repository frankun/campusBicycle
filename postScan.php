<?php
header("Content-type: text/html; charset=utf-8");
include ("conn.php");
/*
 写入扫描事件

 url:postScan

 param:String wechatId,Number stationId,Number createdAt

 return:{"status":"0"}
 */

// $_POST["wechatId"]='12345678';
//$_POST["stationId"]=1;
//$_POST["createAt"]='20121111111';

if (isset($_POST["wechatId"]) AND isset($_POST["stationId"]) AND isset($_POST["createAt"])) {
	$wechatId = $_POST["wechatId"];
	$stationId = $_POST["stationId"];
	$createAt = $_POST["createAt"];
	$status = $_POST["status"];

} else {

	$error1 = array("status" => "101", "des" => "缺少@post参数String wechatId,Number stationId,Number createdAt");
	echo json_encode($error1);

	exit ;
}

//$getId=mysql_insert_id();
//echo $getId;

$query = mysql_query("INSERT INTO `bike_scan` (id,wechatId,createAt,stationId,status) VALUES (null,'$wechatId','$createAt','$stationId','$status')");

//mysql_query("INSERT INTO bike_scan (id,wechatId,createAt,stationId)
//VALUES ('0','wechatId','2','1')");

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