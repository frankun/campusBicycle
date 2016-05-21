<?php
header("Content-type: text/html; charset=utf-8");
//测试完成
include ("conn.php");

/*
 获取某用户最新一条借车信息(按照lendCreateAt倒序排序)

 url:userLend

 param:Number userId,Number lendStatus

 return: {"status":"0","info":{"userId":"123","id":"23","lendStationId":"1","lendCreateAt":"1012143122","returnStationId":"1","returnCreateAt":"1012143122","status":"1"}}
 //没有借车的话,返回{"status":"102","des":"该用户没有借车"}

 */

//$_GET['userId']='1';
//$_GET['lendStatus']=0;

if (isset($_GET['userId']) AND isset($_GET['lendStatus'])) {
	$userId = $_GET['userId'];
	$lendStatus = $_GET['lendStatus'];
} else {

	$error0 = array("status" => "101", "des" => "缺少@get参数Number userId,Number lendStatus");
	echo json_encode($error0);

	exit ;
}

$result = mysql_query("SELECT  id,userId,lendStationId,lendCreateAt,returnStationId,returnCreateAt,status
FROM `bike_lend` 
WHERE userId='$userId' AND status='$lendStatus'
ORDER BY lendCreateAt DESC") or die("从数据库中获取数据失败");

if ($result) {

	$row = mysql_fetch_assoc($result);
	//只取第一行的数据

	if (!$row) {
		$error1 = array("status" => 102, "des" => "该用户没有借车");
		echo json_encode($error1);
		exit ;
	} else {
		$result_state = array("status" => 0, "info" => $row, );
	}

	echo json_encode($result_state);

}

//释放查询资源
mysql_free_result($result);

//关闭数据库连接
mysql_close($con);
?>