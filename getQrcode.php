<?php
header("Content-type: text/html; charset=utf-8");
require './wechat/wechat.class.php';
$options = array('token' => 'scubike', //填写你设定的key
//'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
'appid' => 'YOUR_APPID', //填写高级调用功能的app id, 请在微信开发模式后台查询
'appsecret' => 'YOUR_APPSECRET', //填写高级调用功能的密钥

);
$systemError = "系统错误,请稍后再试";
$apiUrl = "http://1.scubiketest.sinaapp.com";
if (isset($_GET['stationId'])) {
	$stationId = $_GET['stationId'];
} else {
	$error1 = array("status" => "101", "des" => "缺少@get参数Numbe stationId");
	echo json_encode($error1);

	exit ;
}
if (isset($_GET['expire'])) {
	$expire = $_GET['expire'];
} else {
	$expire = 60;
}

$getStationUrl = $apiUrl . "/getStation.php?stationId=" . $stationId;

$getStation = json_decode(http_get($getStationUrl));

if ($getStation -> status == 0) {
	$w = new Wechat($options);

	for ($i = 0; $i < 5; $i++) {
		$j = $i + 1;

		$ticket[$i] = $w -> getQRCode($stationId, 0, $expire * $j);
		$qrcodeUrl[$i] = $w -> getQRUrl($ticket[$i]['ticket']);
		$stationInfo[$i] = array('stationId' => $stationId, 'name' => $getStation -> info -> name, 'number' => $getStation -> info -> number, 'qrcodeUrl' => $qrcodeUrl[$i], 'expire_seconds' => $ticket[$i]['expire_seconds']);

	}

	$result = array('status' => 0, 'info' => $stationInfo);

	echo json_encode($result);
} else {
	echo json_encode($getStation);
	exit ;

}

/**
 * GET 请求
 * @param string $url
 */
function http_get($url) {
	$oCurl = curl_init();
	if (stripos($url, "https://") !== FALSE) {
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
	}
	curl_setopt($oCurl, CURLOPT_URL, $url);
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
	$sContent = curl_exec($oCurl);
	$aStatus = curl_getinfo($oCurl);
	curl_close($oCurl);
	if (intval($aStatus["http_code"]) == 200) {
		return $sContent;
	} else {
		return false;
	}
}
?>