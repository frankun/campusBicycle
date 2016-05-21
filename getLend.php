<?php
header("Content-type: text/html; charset=utf-8");
//测试完成
include ("conn.php");
/*
 获取某站点最新借还信息列表接口
 url:getLend
 param:Number stationId,Number count(输出信息的条数)
 return:{"status":"0","info":[
 {"wechatName":"小明",
 "status":"0",
 "lendStationId":"1",
 "lendCreateAt":"1021214321",
 "returnStationId":"0",
 "returnCreateAt":"0"
 },
 {"wechatName":"小花",
 "status":"1",
 "lendStationId":"1",
 "lendCreateAt":"1021214321",
 "returnStationId":"2",
 "returnCreateAt":"1021221210"
 }
 ]
 }

 */

if (isset($_GET['stationId']) AND isset($_GET['count'])) {
	$stationId = $_GET['stationId'];
	$count = $_GET['count'];
} elseif (isset($_GET['stationId'])) {
	$stationId = $_GET['stationId'];
	$count = 6;
	//默认的查询条数

} else {
	$error0 = array("status" => "101", "des" => "缺少@get参数Number stationId Number count");
	echo json_encode($error0);

	exit ;
}

if ($count == 0) {
	$error1 = array("status" => "104", "des" => "输入数据有误");
	echo json_encode($error1);

	exit ;
}

//根据得到的$step值，获取updateCreateAtz最大值所在的记录
$result = mysql_query("SELECT wechatName,status,lendStationId,lendCreateAt,returnStationId,returnCreateAt,updateCreateAt
FROM `bike_lend`,`bike_user`
WHERE (bike_lend.lendStationId='$stationId' OR bike_lend.returnStationId='$stationId') AND bike_lend.userId=bike_user.id 
ORDER BY updateCreateAt desc
LIMIT $count") or die("数据库查询出错\n");
//echo $result;

$num = 0;
$info = null;

//查询得返回值的情况
if ($result) {
	while ($row = mysql_fetch_assoc($result)) {
		$info[$num] = $row;
		$num++;
	}
       // print_r($info);exit;
	if (!$info) {
		$error2 = array("status" => "102", "des" => "该站点尚未有借还信息");
		echo json_encode($error2);

		exit ;

	}
	$result_state = array("status" => 0, "info" => $info, );
	//print_r($result_state);exit;
	echo json_encode($result_state);

} else {
	$result_state = array("status" => 103, "des" => "数据库读取失败", );
	echo json_encode($result_state);

}

//释放查询资源
mysql_free_result($result);

//关闭数据库连接
mysql_close($con);
?>