<?php
header("Content-type: text/html; charset=utf-8");
//微信服务端引用

require './wechat/wechat.class.php';
$options = array('token' => 'scubike', //填写你设定的key
//'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
'appid' => 'YOUR_APPID', //填写高级调用功能的app id, 请在微信开发模式后台查询
'appsecret' => 'YOUR_APPSECRET', //填写高级调用功能的密钥

);
$systemError = "系统错误,请稍后再试";
$apiUrl = "http://1.scubiketest.sinaapp.com";
$apiSuffix = "php";
$w = new Wechat($options);

$w -> valid();
$type = $w -> getRev() -> getRevType();
switch($type) {
	case Wechat::MSGTYPE_TEXT :
		$w -> text("感谢您的留言,稍后回复您！") -> reply();

		break;
	case Wechat::MSGTYPE_EVENT :
		$result = $w -> getRevEvent();
		switch ($result['event']) {
			case 'subscribe' :
				if ($w -> getRevSceneId()) {



					//0.将该扫描事件写入数据库，扫描时间，用户id，
					$postScanurl = $apiUrl . "/postScan." . $apiSuffix;
					//写入扫描时间的api @post
					$param = array('wechatId' => $w -> getRevFrom(), 'createAt' => $w -> getRevCtime(), 'stationId' => $w -> getRevSceneId(), 'status' => 0);
					http_post($postScanurl, $param);
					//1.检查数据库是否有该用户
					$getUserinfoUrl = $apiUrl . "/getUserinfo." . $apiSuffix . "?wechatId=" . $w -> getRevFrom();

					$userinfo = json_decode(http_get($getUserinfoUrl));

					//2.如果有，查询该用户是否有借车行为

					if ($userinfo -> status == "0") {

						//@get
						$userLendUrl = $apiUrl . "/userLend." . $apiSuffix . "?userId=" . $userinfo -> info -> userId . "&lendStatus=0";
						$userLend = json_decode(http_get($userLendUrl));
						//3.如果2的结果是有，提示：XX请在3分钟内点击下方还车按钮进行还车

						if ($userLend -> status == "0") {
							$lendtips = "尊敬的用户" . $userinfo -> info -> wechatName . ",您已借车，请在3分钟内点击下方的还车按钮进行还车" . $userlend -> status;
							$w -> text($lendtips) -> reply();

						} else if ($userLend -> status == "102") {
							  $getStationUrl=$apiUrl."/getStation.".$apiSuffix."?stationId=".$w->getRevSceneId();
			    $stationInfo= json_decode(http_get($getStationUrl));
			    if($stationInfo->status=="0"){
			    	if($stationInfo->info->number>0){
							$returntips = "尊敬的用户" . $userinfo -> info -> wechatName . ",已成功授权，请在3分钟内点击下方的借车按钮进行借车";
							$w -> text($returntips) -> reply();
							//4.如果2的结果是没有，提示：xx请点击下方借车按钮进行借车
								}else{
					$content = "当前站点车辆不足";
						$w -> text($content) -> reply();
			}
			}else{
					$content = "系统中无此站点信息";
						$w -> text($content) -> reply();
			}
						} else {
							$w -> text($systemError) -> reply();
						}

					} else {

						$userinfo = $w -> getUserInfo($w -> getRevFrom());
						$postUserinfoUrl = $apiUrl . "/postUserinfo." . $apiSuffix;
						$param = array('wechatId' => $w -> getRevFrom(), 'wechatName' => $userinfo['nickname'], 'gender' => $userinfo['sex'], 'headImgUrl' => $userinfo['headimgurl'], 'createAt' => $w -> getRevCtime());

						$postUserinfo = json_decode(http_post($postUserinfoUrl, $param));

						if ($postUserinfo -> status == "0") {
							 $getStationUrl=$apiUrl."/getStation.".$apiSuffix."?stationId=".$w->getRevSceneId();
			    $stationInfo= json_decode(http_get($getStationUrl));
			    if($stationInfo->status=="0"){
			    	if($stationInfo->info->number>0){
							$lendtips = "尊敬的用户" . $userinfo['nickname'] . ",请在3分钟内点击下方的借车按钮进行借车";
							$w -> text($lendtips) -> reply();
								}else{
					$content = "当前站点车辆不足";
						$w -> text($content) -> reply();
			}
			}else{
					$content = "系统中无此站点信息";
						$w -> text($content) -> reply();
			}
						} else {
							$w -> text($systemError) -> reply();
						}

					}

				} else {
					$w -> text('欢迎关注四川大学公益自行车借还系统,你可以点击下方"发现"菜单的"附近自行车"来查看距离你最近的站点的可借车辆。
如需借车,请在公益自行车站点扫描动态二维码') -> reply();
				}

				break;
			case 'SCAN' :

			   
				//0.将该扫描事件写入数据库，扫描时间，用户id，
				$postScanurl = $apiUrl . "/postScan." . $apiSuffix;
				//写入扫描时间的api @post
				$param = array('wechatId' => $w -> getRevFrom(), 'createAt' => $w -> getRevCtime(), 'stationId' => $w -> getRevSceneId());
				http_post($postScanurl, $param);
				//$w->text('scan'.$w -> getRevSceneId())->reply();

				//1.检查数据库是否有该用户
				$getUserinfoUrl = $apiUrl . "/getUserinfo." . $apiSuffix . "?wechatId=" . $w -> getRevFrom();

				$userinfo = json_decode(http_get($getUserinfoUrl));

				//2.如果有，查询该用户是否有借车行为

				if ($userinfo -> status == "0") {

					//@get
					$userLendUrl = $apiUrl . "/userLend." . $apiSuffix . "?userId=" . $userinfo -> info -> userId . "&lendStatus=0";
					$userLend = json_decode(http_get($userLendUrl));
					//3.如果2的结果是有，提示：XX请在3分钟内点击下方还车按钮进行还车

					if ($userLend -> status == "0") {
						$lendtips = "尊敬的用户" . $userinfo -> info -> wechatName . ",您已借车，请在3分钟内点击下方的还车按钮进行还车";
						$w -> text($lendtips) -> reply();

					} else if ($userLend -> status == "102") {
                         $getStationUrl=$apiUrl."/getStation.".$apiSuffix."?stationId=".$w->getRevSceneId();
			    $stationInfo= json_decode(http_get($getStationUrl));
			    if($stationInfo->status=="0"){
			    	if($stationInfo->info->number>0){

						$returntips = "尊敬的用户" . $userinfo -> info -> wechatName . ",已成功授权，请在3分钟内点击下方的借车按钮进行借车";
						$w -> text($returntips) -> reply();
			    		}else{
					$content = "当前站点车辆不足";
						$w -> text($content) -> reply();
			}
			}else{
					$content = "系统中无此站点信息";
						$w -> text($content) -> reply();
			}


						//4.如果2的结果是没有，提示：xx请点击下方借车按钮进行借车
					} else {
						$w -> text($systemError) -> reply();
					}

				} else {

					$userinfo = $w -> getUserInfo($w -> getRevFrom());
					$postUserinfoUrl = $apiUrl . "/postUserinfo." . $apiSuffix;
					$param = array('wechatId' => $w -> getRevFrom(), 'wechatName' => $userinfo['nickname'], 'gender' => $userinfo['sex'], 'headImgUrl' => $userinfo['headimgurl'], 'createAt' => $w -> getRevCtime());

					$postUserinfo = json_decode(http_post($postUserinfoUrl, $param));

					if ($postUserinfo -> status == "0") {
						  $getStationUrl=$apiUrl."/getStation.".$apiSuffix."?stationId=".$w->getRevSceneId();
			    $stationInfo= json_decode(http_get($getStationUrl));
			    if($stationInfo->status=="0"){
			    	if($stationInfo->info->number>0){
						$lendtips = "尊敬的用户" . $userinfo['nickname'] . ",请在3分钟内点击下方的借车按钮进行借车";
						$w -> text($lendtips) -> reply();
						}else{
					$content = "当前站点车辆不足";
						$w -> text($content) -> reply();
			}
			}else{
					$content = "系统中无此站点信息";
						$w -> text($content) -> reply();
			}
					} else {
						$w -> text($systemError) -> reply();
					}

				}
		

				break;
			case 'CLICK' :
				//点击事件
				switch ($result['key']) {
					case 'lend' :
						//1.查询数据库是否有该用户？
						$getUserinfoUrl = $apiUrl . "/getUserinfo." . $apiSuffix . "?wechatId=" . $w -> getRevFrom();

						$userinfo = json_decode(http_get($getUserinfoUrl));
						//$w->text('j')->reply();
						//3.如果有该用户，查询该用户是否已经在借车了

						if ($userinfo -> status == "0") {

							//@get
							$userLendUrl = $apiUrl . "/userLend." . $apiSuffix . "?userId=" . $userinfo -> info -> userId . "&lendStatus=0";
							$userLend = json_decode(http_get($userLendUrl));
							//4.如果3的结果为是，提示：您已于X月X日 借过车了请先扫描二维码还车后  再进行借车
							if ($userLend -> status == "0") {

								$lendtips = "尊敬的用户" . $userinfo -> info -> wechatName . ",您在" . date('m月 d日H点i分', $userLend -> info -> lendCreateAt) . "所借的公益自行车尚未归还,请先在站点扫描二维码并还车后再进行借车";
								$w -> text($lendtips) -> reply();

							} else if ($userLend -> status == "102") {
								//存在用户且没有借车
								//5.如果3的结果为否，（查询点击借车时间-该用户的扫描时间）>3分钟
								$getScanUrl = $apiUrl . "/getScan." . $apiSuffix . "?wechatId=" . $w -> getRevFrom();
								$scan = json_decode(http_get($getScanUrl));
								if ($scan -> status == "0" && $scan -> info -> status == "0" ) {

									//6.如果大于3分钟的话，提示：您在三分钟内未扫描二维码，请先扫描二维码再借车；
									if ((($w -> getRevCtime() - $scan -> info -> createAt) / 60) > 3) {
										$tips = "尊敬的用户" . $userinfo -> info -> wechatName . ",请先在站点扫描动态二维码后再进行借车";
										$w -> text($tips) -> reply();

									} else {

										//7.如果小于3分钟的话，将借车信息写入借车表，并减少相应站点车辆提示：您好借车成功

										$postLendUrl = $apiUrl . "/postLend." . $apiSuffix;
										$param = array("userId" => $userinfo -> info -> userId, "lendCreateAt" => $w -> getRevCtime(), "updateCreateAt" => $w -> getRevCtime(), "lendStationId" => $scan -> info -> stationId, "status" => 0);
										$postLend = json_decode(http_post($postLendUrl, $param));

										if ($postLend -> status == "0") {

											$postStationBikeUrl = $apiUrl . "/postStationBike." . $apiSuffix;
											$param = array('action' => 'desc', 'number' => 1, 'stationId' => $scan -> info -> stationId);
											$postStationBike = json_decode(http_post($postStationBikeUrl, $param));
											if ($postStationBike -> status == "0") {

												$putScanUrl = $apiUrl . "/putScan." . $apiSuffix;
												$param = array("id" => $scan ->info ->id , "status" => 1);
												$putScan = json_decode(http_post($putScanUrl, $param));
												if ($putScan -> status == 0) {
													$tips = "恭喜您,用户" . $userinfo -> info -> wechatName . "借车成功";
													$w -> text($tips) -> reply();
												} else {
													$w -> text($systemError) -> reply();
												}
											} else {
												$w -> text($systemError) -> reply();
											}

										} else {
											$w -> text($systemError) -> reply();
										}

									}

								} else {
                                    $tips =
                                     "尊敬的用户" . $userinfo -> info -> wechatName . ",您在3分钟内未扫描站点的动态二维码,请先在站点扫描动态二维码后再进行借车";
									$w -> text($tips) -> reply();
								}

							} else {
								$w -> text($systemError) -> reply();
							}

						} else {
							//8.如果1的结果为无，将该用户的个人信息写入数据库中，并继续3
							$userinfo = $w -> getUserInfo($w -> getRevFrom());
							//$userinfo='dddd';
							// $w->text($userinfo)->reply();

							$postUserinfoUrl = $apiUrl . "/postUserinfo." . $apiSuffix;

							$param = array('wechatId' => $w -> getRevFrom(), 'wechatName' => $userinfo['nickname'], 'gender' => $userinfo['sex'], 'headImgUrl' => $userinfo['headimgurl'], 'createAt' => $w -> getRevCtime());

							$postUserinfo = json_decode(http_post($postUserinfoUrl, $param));

							if ($postUserinfo -> status == "0") {
								$tips = "尊敬的用户" . $userinfo['nickname'] . ",您在3分钟内未扫描站点的动态二维码,请先在站点扫描动态二维码后再进行借车";
								$w -> text($tips) -> reply();
							} else {
								$w -> text($systemError) -> reply();
							}

						}
						break;
					case 'return' :
						//1.查询数据库是否有该用户？
						//2.如果1的结果为有，进行3.
						//3.如果有该用户，查询该用户是否已经在借车了
						//4.如果3的结果为否，提示：您没有借过车
						//5.如果3的结果为是，（查询点击借车时间-该用户的扫描时间）>3分钟
						//6.如果大于3分钟的话，提示：您在三分钟内未扫描二维码，请先点击下方的扫按钮扫描二维码再还车；
						//7.如果小于3分钟的话，将还车信息写入借车表，并更新相应站点信息。提示：您好，xxx还车成功，祝您使用愉快
						//8.如果1的结果为无，将该用户的个人信息写入数据库中，并继续3
						//1.查询数据库是否有该用户？
						$getUserinfoUrl = $apiUrl . "/getUserinfo." . $apiSuffix . "?wechatId=" . $w -> getRevFrom();

						$userinfo = json_decode(http_get($getUserinfoUrl));

						//3.如果有该用户，查询该用户是否已经在借车了

						if ($userinfo -> status == "0") {

							//@get
							$userLendUrl = $apiUrl . "/userLend." . $apiSuffix . "?userId=" . $userinfo -> info -> userId . "&lendStatus=0";
							$userLend = json_decode(http_get($userLendUrl));

							if ($userLend -> status == "0") {

								$getScanUrl = $apiUrl . "/getScan." . $apiSuffix . "?wechatId=" . $w -> getRevFrom();
								$scan = json_decode(http_get($getScanUrl));
								if ($scan -> status == "0" && $scan -> info -> status == "0") {

									if ((($w -> getRevCtime() - $scan -> info -> createAt) / 60) > 3) {
										$tips = "尊敬的用户" . $userinfo -> info -> wechatName . ",您在3分钟内未扫描站点的动态二维码,请先在站点扫描动态二维码后再进行还车";
										$w -> text($tips) -> reply();

									} else {

										//7.如果小于3分钟的话，将还车信息更新到借车表，并增加相应站点车辆，提示：您好还车成功

										$putLendUrl = $apiUrl . "/putLend." . $apiSuffix;
										$param = array("id" => $userLend -> info -> id, "returnStationId" => $scan -> info -> stationId, "returnCreateAt" => $w -> getRevCtime(), "updateCreateAt" => $w -> getRevCtime(), "status" => 1);
										$putLend = json_decode(http_post($putLendUrl, $param));

										if ($putLend -> status == 0) {

											$postStationBikeUrl = $apiUrl . "/postStationBike." . $apiSuffix;
											$param = array('action' => 'add', 'number' => 1, 'stationId' => $scan -> info -> stationId);
											$postStationBike = json_decode(http_post($postStationBikeUrl, $param));
											if ($postStationBike -> status == "0") {

												$putScanUrl = $apiUrl . "/putScan." . $apiSuffix;
												$param = array("id" => $scan -> info -> id, "status" => 1);
												$putScan = json_decode(http_post($putScanUrl, $param));
												if ($putScan -> status == 0) {

													$tips = "恭喜您,用户" .$userinfo -> info -> wechatName . "还车成功";
													$w -> text($tips) -> reply();
												} else {
													$w -> text($systemError."扫描系统故障") -> reply();
												}
											} else {
												$w -> text($systemError."站点加车故障") -> reply();
											}

										} else {
											$w -> text($systemError."putLend故障") -> reply();
										}

									}

								} else {
									$tips = "尊敬的用户" . $userinfo -> info -> wechatName . ",您在3分钟内未扫描站点的动态二维码,请先在站点扫描动态二维码后再进行还车";
									$w -> text($tips) -> reply();
								}

							} elseif ($userLend -> status == "102") {
								$lendtips = "尊敬的用户" . $userinfo -> info -> wechatName . ",您尚未借车,请先借车后再进行还车";
								$w -> text($lendtips) -> reply();

							} else {
								$w -> text($systemError) -> reply();
							}

						} else {
							//8.如果1的结果为无，将该用户的个人信息写入数据库中，并继续3
							$userinfo = $w -> getUserInfo($w -> getRevFrom());
							$postUserinfoUrl = $apiUrl . "/postUserinfo." . $apiSuffix;
							$param = array('wechatId' => $w -> getRevFrom(), 'wechatName' => $userinfo['nickname'], 'gender' => $userinfo['sex'], 'headImgUrl' => $userinfo['headimgurl'], 'createAt' => $w -> getRevCtime());

							$postUserinfo = json_decode(http_post($postUserinfoUrl, $param));

							if ($postUserinfo -> status == "0") {
								$tips = "尊敬的用户" . $w -> getRevFrom() . ",您在3分钟内未扫描站点的动态二维码,请先在站点扫描动态二维码后再进行借车";
								$w -> text($tips) -> reply();
							} else {
								$w -> text($systemError) -> reply();
							}

						}
						break;
					default :
						break;
				}
				break;
			default :
				break;
		}

		break;
	case Wechat::MSGTYPE_IMAGE :
		break;
	case Wechat::MSGTYPE_LOCATION :

		//根据用户地理位置x,y坐标返回用户最近的站点的车辆状态信息
		$getStationListUrl = $apiUrl . "/getStationList." . $apiSuffix;
		$stationList = json_decode(http_get($getStationListUrl));
		$stationListInfo = $stationList -> info;
		if ($stationList -> status == "0") {
			$userGeo = $w -> getRevGeo();
			$y1 = $userGeo['y'];
			$x1 = $userGeo['x'];

			foreach ($stationListInfo as $k => $v) {

				$distance[$k] = distance_calculate($y1, $x1, $v -> y, $v -> x);

			}

			foreach ($distance as $key => $val) {

				if ($val == min($distance)) {
					$val = number_format($val, 2, '.', '');
					$tips = "您好,距离您最近的自行车站点是:" . $stationListInfo[$key] -> name . ",距离您" . $val . "公里,目前还有" . $stationListInfo[$key] -> number . "辆空闲车辆。";
					$w -> text($tips) -> reply();

				}
			}

		} else {
			$w -> text($systemError) -> reply();
		}
		break;
	default :
		$w -> text("help info") -> reply();
}
function distance_calculate($lat1, $lon1, $lat2, $lon2, $unit) {

	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);

	if ($unit == "K") {
		return ($miles * 1.609344);
	} else if ($unit == "N") {
		return ($miles * 0.8684);
	} else {
		return $miles;
	}
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

/**
 * POST 请求
 * @param string $url
 * @param array $param
 * @param boolean $post_file 是否文件上传
 * @return string content
 */
function http_post($url, $param, $post_file = false) {
	$oCurl = curl_init();
	if (stripos($url, "https://") !== FALSE) {
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
	}
	if (is_string($param) || $post_file) {
		$strPOST = $param;
	} else {
		$aPOST = array();
		foreach ($param as $key => $val) {
			$aPOST[] = $key . "=" . urlencode($val);
		}
		$strPOST = join("&", $aPOST);
	}
	curl_setopt($oCurl, CURLOPT_URL, $url);
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($oCurl, CURLOPT_POST, true);
	curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
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