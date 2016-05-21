<?php
header("Content-type: text/html; charset=utf-8");
//测试完成
include ("conn.php");
/*获取用户信息：
 url:getUserinfo

 param:String wechatId

 return:{"status":"0","info":{"userId":"182","wechatName":"小明","gender":"男","headImgUrl":"http://xxx.com/xx.jpg","wechatId":"xxxdfdafsdafdsfasafasfsa"}}

 //不存在的话返回:{"status":"102","des":"不存在该用户"}
 */
//$_GET["wechatId"]='123456';

if (isset($_GET["wechatId"])) {

	$wechatId = $_GET["wechatId"];

} else {

	$error0 = array("status" => "101", "des" => "缺少@get参数String wechatId。");
	echo json_encode($error0);

	exit ;
}

$result = mysql_query("SELECT id,wechatName,gender,headImgUrl,wechatId 
FROM `bike_user` WHERE wechatId='$wechatId'") or die("get information failed");

$row = mysql_fetch_assoc($result);
//{"userId":"182","wechatName":"小明","gender":"男","headImgUrl":"http://xxx.com/xx.jpg","wechatId":"xxxdfdafsdafdsfasafasfsa"}
if (!$row) {
	$error1 = array("status" => 102, "des" => "不存在该用户");
	echo json_encode($error1);

	exit ;
}

if ($row) {
	$row['userId'] = $row['id'];
	$result_state = array("status" => 0, "info" => $row, );

} else {

	$result_state = array("status" => 103, "des" => "数据库读取失败", );

}

echo json_encode($result_state);

mysql_free_result($result);

//关闭数据库连接
mysql_close($con);
?>