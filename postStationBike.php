<?php
header("Content-type: text/html; charset=utf-8");
include ("conn.php");
/*增加或者减少站点车辆
 url:postStationBike
 param:String action(值为 add 或 desc),Number number,Number stationId
 return:{"status":"0"}*/

//测试数据

if (isset($_POST['action']) AND isset($_POST['number']) AND isset($_POST['stationId'])) {
	$action = $_POST['action'];
	$number = $_POST['number'];
	$stationId = $_POST['stationId'];
} else {
	$error1 = array("status" => "101", "des" => "缺少@post参数String action(值为 add 或 desc),Number number,Number stationId");
	echo jason_encode($error1);
	exit ;
}

//获取number变量的值
$sql = "SELECT number FROM `bike_station` WHERE id='$stationId'";
//echo $sql;
$numberquery = mysql_query($sql);
$numberres = mysql_fetch_array($numberquery);

$number0 = $numberres[0];

//添加车辆的情况
if ($action == 'add') {
	if ($number0 == null) {
		$number0 = 0;
	}

	$number_final = $number + $number0;

	$query_update = mysql_query("UPDATE `bike_station` SET number = '$number_final'
WHERE id='$stationId'") or die("update query fails!");

}

//减少车辆的情况
else if ($action == 'desc') {
	$dec = $number0 - $number;

	if ($number == null || $dec < 0) {
		$error2 = array("status" => "103", "des" => "输入数据有误");
		echo json_encode($error2);

		exit ;
	}
	$query_update = mysql_query("UPDATE `bike_station` SET number = '$dec'
WHERE id='$stationId' ") or die("update query fails!");

} else {
	$error3 = array("status" => "103", "des" => "你要干嘛？？？");
	echo json_encode($error3);

	exit ;
}

//判断数据库是否更新成功及反馈
if ($query_update) {
	$result = array("status" => 0, "des" => "更新成功", );

	echo json_encode($result);
} else {

	$result = array("status" => 102, "des" => "数据库更新失败", );

	echo json_encode($result);
}

//关闭数据库连接
mysql_close($con);
?>