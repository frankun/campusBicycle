<?php
$con = mysql_connect("URL_SERVER", "USER_NAME", "USER_PASSWORD");
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("app_scubiketest", $con);
mysql_query('SET NAMES UTF8') or die("字符集设置错误");
 $siteName="四川大学公益自行车管理系统";
?>