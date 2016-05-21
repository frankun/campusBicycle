<?php
//请勿随意访问该文件
//创建微信自定义菜单
require './wechat/wechat.class.php';
$options = array('token' => 'scubike', //填写你设定的key
//'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
'appid' => 'YOUR_APPID', //填写高级调用功能的app id, 请在微信开发模式后台查询
'appsecret' => 'YOUR_APPSECRET', //填写高级调用功能的密钥

);
$w = new Wechat($options);
$data = array('button' => array(0 => array('name' => '借', 'type' => 'click', 'key' => 'lend', ), 1 => array('name' => '还', 'type' => 'click', 'key' => 'return', ), 2 => array('name' => '发现', 'sub_button' => array(0 => array('type' => 'scancode_push', 'name' => '扫二维码', 'key' => 'qrcode', ), 1 => array('type' => 'location_select', 'name' => '附近自行车', 'key' => 'nearby', )), ), ), );

$w -> createMenu($data);
?>