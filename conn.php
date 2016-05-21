<?php
   //第一步：链接数据库  
    $conn=@mysql_connect("SAE_MYSQL_HOST_M:SAE_MYSQL_PORT","SAE_MYSQL_USER","SAE_MYSQL_PASS")or die ("mysql链接失败");
   //第二步: 选择指定的数据库，设置字符集  
    @mysql_select_db("SAE_MYSQL_DB",$conn) or die ("db链接失败".mysql_error());
    mysql_query('SET NAMES UTF8')or die ("字符集设置错误");  
    //$siteName="四川大学公益自行车管理系统";
    $siteName="校园公共自行车管理系统";
 ?>