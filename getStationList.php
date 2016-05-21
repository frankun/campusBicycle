<?php
header("Content-type: text/html; charset=utf-8");
//测试完成
include ("conn.php");
/*
 获取站点信息列表

 url:getStationList
 param:null
 return:{"status":"0","info":[
 {"stationId":"1","name":"校车站自行车站","number":"23","x","16.2312121","y","30.2312312"},
 {"stationId":"2","name":"校车站自行车站","number":"23","x","16.2312121","y","30.2312312"}
 ]}
 */

$result = mysql_query("SELECT name,number,x,y,id FROM `bike_station`");
//如果获取的结果为空，则报错并退出

//对要输入的记录进行计数
$num = 0;
$info = null;

if ($result) {
	while ($row = mysql_fetch_assoc($result)) {
		$info[$num] = $row;
		$info[$num]['stationId'] = $row['id'];
		$num++;
	}

	if (count($info) == 0) {
		$result_state = array("status" => 102, "des" => '没有站点', );
		echo json_encode($result_state);
		exit ;
	} else {
		$result_state = array("status" => 0, "info" => $info, );
		echo json_encode($result_state);
	}

} else {
	$result_state = array("status" => 103, "des" => "数据库读取失败", );
	echo json_encode($result_state);
}

mysql_free_result($result);

//关闭数据库连接
mysql_close($con);
?>