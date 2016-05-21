<?php
include("judge.php");
  include("conn.php");

  $sql="select count(*) as count from `bike_user`"; //计算该表中的数据条数；
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
  $count=$rs[0];  //总用户数量；
  }else{
  $count=0;
  }
  // echo $count;exit;
  // echo $sql;exit;
  // $query=mysql_query($sql);
  // //echo $query;exit;
  // $rs=mysql_fetch_array($query)
  // //print_r($rs);exit;

  $timeToday=strtotime(date("Y-m-d"));
  $sql="SELECT COUNT(*) AS count FROM `bike_user` where createAt>=$timeToday"; //计算该表中注册时间大于今日零点的用户数量；
  //echo $sql;exit;
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
  $countNewUser=$rs[0];  //新用户数量；
  }else{
  $countNewUser=0;
  }

  // $percent=$countNewUser/$count*100;  //计算新用户与总用户的百分比；
  //echo $percent;exit;

  $sql="select sum(initNumber) from `bike_station`";  //计算该表中initNumber字段下的总数即初始车辆总数；
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
  $countBikeNumber=$rs[0];
  }else{
  $countBikeNumber=0;  //车辆总数；
  }
  //echo $countBikeNumber;exit;

  $sql="select sum(Number) from `bike_station`";  //计算停放车辆总数；
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
  $countNumber=$rs[0];   //停放总数；
  }else{
  $countNumber=0;
  }
  //echo $countNumber;exit;
  $countLendNumber=$countBikeNumber-$countNumber;  //借出数量；

  $sql="select count(lendCreateAt) as count from `bike_lend`";  //计算lengCreateAt字段下数据条数；
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
    $lendNumber=$rs[0];   //借出流量统计；
  }else{
    $lendNumber=0;
  }
  // echo $lendNumber;exit;

  $sql="select count(returnCreateAt) as count from `bike_lend` where status=1"; //计算returnCreateAt字段下的已经归还车辆的数据条数；
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
    $returnNumber=$rs[0];   //归还流量统计；
  }else{
    $returnNumber=0;
  }
  // echo $returnNumber;exit;
  $sumNumber=$lendNumber+$returnNumber; //总流量；

  $sql="select count(lendCreateAt) as count from `bike_lend` where lendCreateAt>=$timeToday"; 
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
    $tdLendNumber=$rs[0];   //当天借出流量统计；
  }else{
    $tdLendNumber=0;
  }
  // echo $lendNumber;exit;

  $sql="select count(returnCreateAt) as count from `bike_lend` where returnCreateAt>=$timeToday";
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
    $tdReturnNumber=$rs[0];   //当天归还流量统计；
  }else{
    $tdReturnNumber=0;
  }
  // echo $returnNumber;exit;
  $tdSumNumber=$tdLendNumber+$tdReturnNumber; //当天总流量；

  $sql="select count(distinct userId) from `bike_lend`";
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
    $countActive=$rs[0];   //总活跃人数；
  }else{
    $countActive=0;
  }

  $tdActivePercent=$tdLendNumber/$count*100; //今日活跃度；
  $activePercent=$countActive/$count*100; //总活跃度；

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>后台管理 - <?php echo $siteName; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./index.php"><?php echo $siteName; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./logout.php">退出</a></li>
          </ul>
          <form action="user.php" method="get" class="navbar-form navbar-right">
            <div class="input-group">
               <input type="text" name="keys" class="form-control" placeholder="搜索...">
               <span class="input-group-btn">
                  <button class="btn btn-default" type="submit" name="subs"><span class="glyphicon glyphicon-search"></span></button>
               </span>
            </div>
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="./index.php">总览</a></li>
            <li><a href="./station.php">站点管理</a></li>
            <li><a href="./user.php">用户管理</a></li>
            <li><a href="./lend.php">借还管理</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">统计</h1>

          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">新增用户：<a href="./user.php?type=new"><?php echo $countNewUser; ?></a>
              <h4>用户量</h4>
              <span class="text-muted"><a href="./user.php"><?php echo $count; ?></a></span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">今日活跃度：<?php echo round($tdActivePercent,2); ?>%
              <h4>总活跃度</h4>
              <span class="text-muted"><?php echo round($activePercent,2); ?>%</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">在借车辆：<?php echo $countLendNumber; ?>
              <h4>总车辆数</h4>
              <span class="text-muted"><?php echo $countBikeNumber; ?></span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">今日流量：<?php echo $tdSumNumber; ?>
              <h4>借还流量</h4>
              <span class="text-muted"><?php echo $sumNumber; ?></span>
            </div>
          </div>

         <h2 class="sub-header">实时借还信息
          <small><a href="./lend.php?status=0">（未还统计：<?php echo $nullNumer=$lendNumber-$returnNumber; ?>）</a></small></h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>微信名</th>
                  <th>借车时间</th>
                  <th>借车站点</th>
                  <th>还车时间</th>
                  <th>还车站点</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql="select * from `bike_lend` order by id desc limit 0,10";
                  $query=mysql_query($sql);

                  while($rs=mysql_fetch_array($query)){
              
                  $userId=$rs['userId'];
                  $sql="select * from `bike_user` where id=$userId";
                  $userQuery=mysql_query($sql);
                  $rsUser=mysql_fetch_array($userQuery);
                  // print_r($rsUser);exit;

                  $lendStationId=$rs['lendStationId'];
                  $sql="select * from `bike_station` where id=$lendStationId";
                  $lendStationQuery=mysql_query($sql);
                  $rsLendStation=mysql_fetch_array($lendStationQuery);

                  $returnStationId=$rs['returnStationId'];
                  $sql="select * from `bike_station` where id=$returnStationId";
                  $returnStationQuery=mysql_query($sql);
                  $rsReturnStation=mysql_fetch_array($returnStationQuery);
                ?>
                <tr>
                  <td><a href="./user.php?id=<?php echo $userId; ?>"><?php echo $rsUser['wechatName']; ?></a></td>
                  <td><?php $lendDates=$rs['lendCreateAt']; echo date("Y-m-d H:i",$lendDates); ?></td>
                  <td><?php echo $rsLendStation['name']; ?></td>
                  <td><?php $returnDates=$rs['returnCreateAt']; 
                  $changeDates=date("Y-m-d H:i",$returnDates);
                  if($returnDates==0){echo "未还";}else{ echo $changeDates; } ?></td>
                  <td><?php if($rs['returnStationId']==NULL){echo "未还";}else{ echo $rsReturnStation['name'];} ?></td>
                </tr>
                <?php
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jQuery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
