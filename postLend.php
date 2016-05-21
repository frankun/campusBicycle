<?php
header("Content-type: text/html; charset=utf-8");
include ("conn.php");

/*写入借车信息
 url:postLend
 param:Number userId,Number lendCreateAt,Number lendStationId
 return:{"status":"0"}*/
if (isset($_POST['userId']) AND isset($_POST['lendCreateAt']) AND isset($_POST['lendStationId']) AND isset($_POST['updateCreateAt'])) {
	$userId = $_POST['userId'];
	$lendCreateAt = $_POST['lendCreateAt'];
	$lendStationId = $_POST['lendStationId'];
	$updateCreateAt = $_POST['updateCreateAt'];
	$status = $_POST['status'];
} else {
	$error1 = array("status" => "101", "des" => "缺少@post参数Number userId,Number lendCreateAt,Number lendStationId,Number updateCreateAt");
	echo json_encode($error1);
	//($error1);
	exit ;
}

$query = mysql_query("INSERT INTO `bike_lend` (id,userId,lendCreateAt,lendStationId,returnStationId,returnCreateAt,updateCreateAt,status) VALUES (null,'$userId','$lendCreateAt','$lendStationId',null,0,'$updateCreateAt','$status')");

if ($query) {
	$result = array("status" => 0, "des" => "插入成功");
	//var_dump($result);

	echo json_encode($result);
} else {

	$result = array("status" => 102, "des" => "数据库插入失败", );

	echo json_encode($result);
}

//echo $query;
mysql_close($con);
?>
