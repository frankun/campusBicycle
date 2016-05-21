<?php
header("Content-type: text/html; charset=utf-8");
//测试完成
include ("conn.php");
//$_GET['wechatId']='1234567';
/*
 获取某用户最新扫描信息

 url:getScan
 param:String wechatId
 return: {"status":"0","info":{"stationId":"2","createAt":"12331241121"}}
 //没有相关信息的话,返回 {"status":"102","des":"该用户没有还车信息"}
 */

if (isset($_GET['wechatId'])) {
	$wechatId = $_GET['wechatId'];
} else {

	$error0 = array("status" => "101", "des" => "缺少@get参数String wechatId");
	echo json_encode($error0);

	exit ;
}

$result = mysql_query("SELECT id,stationId,createAt,status
FROM `bike_scan` 
WHERE wechatId='$wechatId' ORDER BY createAt desc") or die("数据库查询出错\n");
//echo $result;

//获取$row一行的数据
$row = mysql_fetch_assoc($result);

if (!$row) {
	$error1 = array("status" => 102, "des" => "该用户还没有还车信息\n");
	echo json_encode($error1);

	exit ;
}

//查询得返回值的情况
if ($row) {
	$result_state = array("status" => 0 , "info" => $row, );
} else {
	$result_state = array("status" => 103, "des" => "数据库读取失败", );

}

echo json_encode($result_state);

//释放查询资源
mysql_free_result($result);

//关闭数据库连接
mysql_close($con);
?>