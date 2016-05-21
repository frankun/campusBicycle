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

if (isset($_POST['id']) AND isset($_POST['status'])) {
	$id = $_POST['id'];
	$status = $_POST['status'];
} else {

	$error1 = array("status" => "101", "des" => "缺少@get参数:param:Number id,Number status");
	echo json_encode($error1);

	exit ;
}

$result = mysql_query("update bike_scan set status=$status where id=$id") or die("get information failed");
if (!$result) {
	$error2 = array("status" => "103", "des" => "数据库更新出错");
} else {
    	$result = array("status" => 0, "des" => "update successful!", );

    echo json_encode($result);
  

}

//释放查询资源
mysql_free_result($result);

//关闭数据库连接
mysql_close($con);
?>