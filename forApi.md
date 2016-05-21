需要使用的api接口：

格式：
    url:代表标准命名接口,接口人员需按照本api命名来制作api
         如在本地测试getUserinfo接口,相应的url接口为:http://localhost/bike/getUserinfo.php
	param:参数,格式:传入字段类型 字段名
	return:返回部分统一返回json格式,每个返回的json格式需带有状态码,结果描述信息，其中状态码键名为:status,结果描述键名为des，如果调用成功的话,des字段可以为空，或者省略。
若调用正确,则返回json类似如下：
    {"status":"0","des":"写入成功","info":{"userId":"132","wechatName":"小明","gender":"男"}},
若调用错误,则返回json类似如下:
    {"status":"101","des":"写入数据库错误"};

post类:
1.写入扫描事件

	url:postScan

	param:String wechatId,Number stationId,Number createdAt

	return:{"status":"0"}
2.写入用户信息(创建新用户)
	url:postUserinfo
	param:String wechatId,String wechatName,String gender,String headImgUrl,Number createAt
	return:{"status":"0"}

3.写入借车信息
	url:postLend
	param:Number userId,Number lendCreateAt,Number lendStationId
	return:{"status":"0"}


4.增加或者减少站点车辆
	url:postStationBike
	param:String action(值为 add 或 desc),Number number,Number stationId
	return:{"status":"0"}
5.更新借车信息
	$putLendUrl=$apiUrl."/putLend";
	url:putLend
	param:Number id,Number returnStationId,Number returnCreateAt,Number status
	return:{"status":"0"}
6.更新扫描状态
	$putLendUrl=$apiUrl."/putScan";
	url:putScan
	param:Number id,Number status
	return:{"status":"0"}

get类:
1.获取用户信息
	url:getUserinfo

	param:String wechatId

	return:{"status":"0","info":{"userId":"182","wechatName":"小明","gender":"男","headImgUrl":"http://xxx.com/xx.jpg","wechatId":"xxxdfdafsdafdsfasafasfsa"}}
	
	//不存在的话返回:{"status":"102","des":"不存在该用户"}

2.获取某用户最新一条借车信息(按照lendCreateAt倒序排序)

	url:userLend

	param:Number userId,Number lendStatus

	return: {"status":"0","info":{"userId":"123","id":"23","lendStationId":"1","lendCreateAt":"1012143122","returnStationId":"1","returnCreateAt":"1012143122","status":"1"}}
	//没有借车的话,返回{"status":"102","des":"该用户没有借车"}
 

3.获取某用户最新扫描信息

    url:getScan
    param:String wechatId
    return: {"status":"0","info":{"id":"22","stationId":"2","createAt":"12331241121","status":0}}
    //没有相关信息的话,返回 {"status":"102","des":"该用户没有还车信息"}
4.获取站点信息列表

	url:getStationList
	param:null
	return:{"status":"0","info":[
	{"stationId":"1","name":"校车站自行车站","number":"23","x","16.2312121","y","30.2312312"},
	{"stationId":"2","name":"校车站自行车站","number":"23","x","16.2312121","y","30.2312312"}
	]}

5.获取某站点信息
    url:getStation
    param:Number stationId
    return: {"status":"0","info":{"stationId":"1","name":"校车站自行车站","number":"23","x","16.2312121","y","30.2312312"}}


  
6.获取某站点最新借还信息列表接口
	url:getLend
	param:Number stationId,Number count(输出信息的条数)
	return:{"status":"0","info":[
	{"wechatName":"小明",
	"status":"0",
	"lendStationId":"1",
	"lendCreateAt":"1021214321",
	"returnStationId":"0",
	"returnCreateAt":"0",
	"updateCreateAt":"1021214321"
},
{"wechatName":"小花",
	"status":"1",
	"lendStationId":"1",
	"lendCreateAt":"1021214321",
	"returnStationId":"2",
	"returnCreateAt":"1021221210",
	"updateCreateAt":"1021214321"
}
	]
	}
	
   
7.获取5个动态二维码图片,(杨国宝做)

   url:getQrcode
   param:Number stationId,Number expire(默认间隔时间为60秒,单位秒)
   return:{"status":"0","info":[
   {"stationId":"1","name":"校车站","numbe":"23","qrcodeUrl":"http://xxx.xxx.com/xxxxxxx.jpg","expire_seconds":"60"},{"stationId":"1","name":"校车站","numbe":"23","qrcodeUrl":"http://xxx.xxx.com/xxxxxxx.jpg","expire_seconds":"120"},
   {"stationId":"1","name":"校车站","numbe":"23","qrcodeUrl":"http://xxx.xxx.com/xxxxxxx.jpg","expire_seconds":"180"},
   {"stationId":"1","name":"校车站","numbe":"23","qrcodeUrl":"http://xxx.xxx.com/xxxxxxx.jpg","expire_seconds":"240"},
   {"stationId":"1","name":"校车站","numbe":"23","qrcodeUrl":"http://xxx.xxx.com/xxxxxxx.jpg","expire_seconds":"300"}   
   ]}
 



