
 <?php
 header("Content-type: text/html; charset=utf-8");
 //测试完成
 include ("conn.php");
 $result = mysql_query("SELECT name,number,x,y,id FROM `bike_station`");
//如果获取的结果为空，则报错并退出
//对要输入的记录进行计数
 $num = 0;
 $info = null;
if ($result) {
  while ($row = mysql_fetch_assoc($result)) {
    $info[$num] = $row;
    $info[$num]['stationId'] = $row['id'];
    $num++;
  }
}
if(isset($_GET['stationId'])){
  $stationVal=$_GET['stationId']-1;
 }else{
 //  $getStationUrl='C:\wamp\www\bike\getStation.php?stationId=1';
  $stationVal=0;
 }
/*
 $stationInfo=file_get_contents( 'getStationList.php');
 $obStation=json_decode($stationInfo,true);//所有站点信息
 echo $obStation['status'];

if(isset($_GET['stationId'])){
  //$getStationUrl='C:\wamp\www\bike\getStation.php?stationId='.$_GET['stationId'];
  $obPreStation=$obStation->info[$_GET['stationId']]->name;
 }else{
 //  $getStationUrl='C:\wamp\www\bike\getStation.php?stationId=1';
  $obPreStation=$obStation['info'][0]['name'];
  echo $obPreStation;
 }
 //$preStation=file_get_contents($getStationUrl);
// $obPreStation=json_decode($preStation);//当前站点信息
*/

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <script src="js/jQuery.js"></script>
  <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
  <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
	<title>自行车站点</title>
  
 
</head>
<body>
       
       <div style="100%;width:100%;height:600px;position:absolute;top:10%">

	   <div id="head" style="color:rgb(83,80,85); text-align: center;font-size: 24px;">
        <div style="display: inline-block;" id="stationName">
            <?php echo $info[$stationVal]['name'];?>
         </div>
         <div class="dropdown" style="display: inline-block;">
        <button type="button" class="btn dropdown-toggle" id="dropdownMenu1" 
      data-toggle="dropdown" style="font-size:4px;padding:0 0;">
      
      <span class="caret"></span>
      </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
      
      <?php for($s=1;$s<=count($info);$s++){ ?>
      <li role="presentation" >
         <a role="menuitem"  tabindex="-1" href="<?php echo
          "./show.php?stationId=".$s ?>">
          <?php echo $info[$s-1]['name'] ?></a>
      </li>
      <?php } ?>

   </ul>
</div>
         <hr style="border-color: rgb(83,80,85); margin: 1px 40%;">
          <span id="count"></span>

       </div>
              
       <div style="background-repeat:no-repeat; background:url(shuangyinhao1.png);background-size:100% 100%;color:rgb(83,80,85);text-align: center;font-size: 18px;position:relative;
        top:30px;height:80px">
         &nbsp;&nbsp;这里是四川大学公益自行车的“<?php echo $info[$stationVal]['name'];?>”站点<br>
              如需借还车辆，请登录微信并扫描下方二维码。<br>
             
       </div>

      <input id="stationIdInput" type="hidden" value="<?php if(isset($_GET['stationId'])){echo 'getLend.php?stationId='.$_GET['stationId'];}else{echo 'getLend.php?stationId=1';} ?>" />
      <input id="erweimaApiInput" type="hidden" value="<?php if(isset($_GET['stationId'])){echo 'getQrcode.php?stationId='.$_GET['stationId'];}else{echo 'getQrcode.php?stationId=1';} ?>" />
  

      <div style="display: inline-block; width:40%;height:270px;position:relative;
         left:10%;top:10%">
       <table style="text-align: center;width:100%;color:rgb(83,80,85);height:270px; cellspacing=4 ;font-size:26px;" bgcolor="#FFF">

       	<tr>
       		<td >
       			帅气/美丽的你
       		</td>
       		<td>
       			操作
       		</td>
       		<td>
       			时间
       		</td>
       	</tr>
        
        <tr>
          <td class="wechatName1">
            
          </td>
          <td class="status1">
            
          </td>
          <td class="operateTime1">
            
          </td>
        </tr>
         <tr>
          <td class="wechatName2">
            
          </td>
          <td class="status2">
            
          </td>
          <td class="operateTime2">
            
          </td>
        </tr>
      <tr>
          <td class="wechatName3">
            
          </td>
          <td class="status3">
            
          </td>
          <td class="operateTime3">
            
          </td>
        </tr>
     
     




       </table>

       </div>

       <div style="display: inline-block;background-size:100% 100%;width:270px;height:270px;position:relative;left:20%;top:10%;vertical-align:top;">
       	<img style="width:270px;height:270px;" id="erweima" src="">
       </div>
  </div>

      


 <script type="text/javascript">
      
       function returnTime(data){
           var date = new Date(data*1000);

        h = date.getHours() + ':';
        m = date.getMinutes() + ':';
        s = date.getSeconds(); 
          

           return h+m+s;
          }


       //function refreshOnTime(){
       //刷新借还信息
       //  $.get("ajaxReturn.php",function(data){
       // $("#count").html(data);

       //  setTimeout("refreshOnTime()",1000); 

       //  }); 
       var stationChoose=$("#stationIdInput").val();
        //var stationChoose="getUserInfor.php";
       setInterval(function(){
        var returnInfo=null;
        $.get(stationChoose,function(data){
           returnInfo=JSON.parse(data);
          // count=returnInfo.info.length;
          $(".wechatName1").text(returnInfo.info[0].wechatName)
          if (returnInfo.info[0].status==1) {
            $(".status1").text("还");
          } else{
            $(".status1").text("借");
          };
         
          $(".operateTime1").text(returnTime(returnInfo.info[0].updateCreateAt));


           $(".wechatName2").text(returnInfo.info[1].wechatName);
            if (returnInfo.info[1].status==1) {
            $(".status2").text("还");
          } else{
            $(".status2").text("借");
          };
         
          $(".operateTime2").text(returnTime(returnInfo.info[1].updateCreateAt));


           $(".wechatName3").text(returnInfo.info[2].wechatName);
            if (returnInfo.info[2].status==1) {
            $(".status3").text("还");
          } 
            if (returnInfo.info[2].status==0) {
            $(".status3").text("借");
          }
         
          $(".operateTime3").text(returnTime(returnInfo.info[2].updateCreateAt));
          

        }) ;  
                },3000); 
         //setTimeout(refreshOnTime(),3000);
             
     //}
      
//        //setInterval("refreshOnTime()",1000);
// </script>

      <script type="text/javascript"> 
      function ShowTime() { 
      var time = new Date(); 
      var temp = time.toLocaleString(); 
     // document.getElementById("spanTime").innerText = temp; 
      $("#count").html(temp);
      setTimeout(ShowTime, 1000); 
      } 
      onload = ShowTime; 
      </script>

<script type="text/javascript">
  $(document).ready(function(){
    
    var src=[];
    var result=null;
    var resu=null;
    var count=1;//count从1开始，因为0设为默认的
    var erweimaApiChoose=$("#erweimaApiInput").val();
    //var erweimaApiChoose="erweimaApi.php";
      $.get(erweimaApiChoose,function(data){
          setInterval(function(){
        $.get(erweimaApiChoose,function(res){
         resu=JSON.parse(res); 
         for(var i=0;i<5;i++){
           src[i]= resu.info[i].qrcodeUrl;     
         }   //此循环是将每5分组请求所得的json赋值到SRC数组中   
           console.log(src);  //将当前url存入数组    
        });

          },283*1000);//设置每5分钟ajax刷新获取一个新的json对象
   
        result=JSON.parse(data);
        for(var i=0;i<5;i++){
           src[i]= result.info[i].qrcodeUrl;   
           console.log(src[i]);  
         }   //此循环是将最初请求所得的json赋值到SRC数组中 

         $("#erweima").attr("src",src[0]);
          setInterval(function(){
        //location.reload();
      if (count<4) 
      {
      count++;
         }
         else
         {
          count=0;
         }
      $("#erweima").attr("src",src[count]);  
      
      //console.log(count);
    },57000);//设置每57秒更新一次图片
                }) ;
  
  
    

  });
    
  </script>

<script language="JavaScript">
  // function myrefresh(){
  // window.location.reload();
  // }
  // setTimeout('myrefresh()',300*1000); //指定300s全局刷新一次
</script>
</body>
</html>