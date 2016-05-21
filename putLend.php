<?php
header("Content-type: text/html; charset=utf-8");
include ("conn.php");
/*
 5.更新借车信息
 $putLendUrl=$apiUrl."/putLend";
 url:putLend
 param:Number id,Number returnStationId,Number returnCreateAt,Number status
 return:{"status":"0"}

 */

if (isset($_POST['id']) AND isset($_POST['returnCreateAt']) AND isset($_POST['returnStationId']) AND isset($_POST['updateCreateAt']) AND isset($_POST['status'])) {
	$id = $_POST['id'];
	$returnCreateAt = $_POST['returnCreateAt'];
	$returnStationId = $_POST['returnStationId'];
	$updateCreateAt = $_POST['updateCreateAt'];
	$status = $_POST['status'];
} else {

	$error1 = array("status" => "101", "des" => "缺少@get参数:param:Number id,Number returnStationId,Number returnCreateAt,Number status");
	echo json_encode($error1);

	exit ;
}

$result = mysql_query("update bike_lend set returnStationId=$returnStationId,returnCreateAt=$returnCreateAt,updateCreateAt=$updateCreateAt,status=$status where id=$id") or die("get information failed");

if (!$result) {
	$error2 = array("status" => "103", "des" => "数据库更新出错");
} else {
	$result = array("status" => 0, "des" => "更新成功", );

	echo json_encode($result);

}

//释放查询资源
mysql_free_result($result);

//关闭数据库连接
mysql_close($con);
?>