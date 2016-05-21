<?php
$con = mysql_connect("w.rdc.sae.sina.com.cn:3307", "jn41zm50w3", " 2h5ix35hlzylmxyzz2yx0jk2y42ixl3zk24yhi2x");
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("app_campuspubbike", $con);
mysql_query('SET NAMES UTF8') or die("字符集设置错误");
 $siteName="四川大学公益自行车管理系统";
?>