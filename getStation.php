<?php
header("Content-type: text/html; charset=utf-8");
//测试完成
include ("conn.php");
/*
 获取某站点信息
 url:getStation
 param:Number stationId
 return: {"status":"0","info":{"stationId":"1","name":"校车站自行车站","number":"23","x","16.2312121","y","30.2312312"}}
 */
//$_GET['stationId']='2';
if (isset($_GET['stationId'])) {
	$stationId = $_GET['stationId'];
} else {
	$error0 = array("status" => "101", "des" => "缺少@get参数Number stationId");
	echo json_encode($error0);

	exit ;
}

$result = mysql_query("SELECT id,name,number,x,y
FROM `bike_station` WHERE id='$stationId'") or die("get information failed");

//对要输出的记录进行计数
$num = 0;
$info = null;

if ($result) {
	while ($row = mysql_fetch_assoc($result)) {
		$info[$num] = $row;
		$info[$num]['stationId'] = $row['id'];
		$num++;
	}

	if (!$info) {
		$result_state = array("status" => 102, "des" => "该站点还没有相关信息", );
		echo json_encode($result_state);
		exit ;
	}

	$result_state = array("status" => 0, "info" => $info[0], );

} else {
	$result_state = array("status" => 103, "des" => "数据库读取失败", );

}
echo json_encode($result_state);

//释放查询资源
mysql_free_result($result);

//关闭数据库连接
mysql_close($con);
?>