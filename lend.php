<?php
include("judge.php");
include("conn.php");

// $sql="select * from `bike_user`";
// $query=mysql_query($sql);
// $rsUser=mysql_fetch_array($query);
// print_r($rsUser);exit;

$sql="select * from `bike_station`";
$query=mysql_query($sql);
$rsStation=mysql_fetch_array($query);

  $sql="SELECT COUNT(*) AS count FROM `bike_lend`";
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
  $countLend=$rs[0];
  }else{
  $countLend=0;
  }

  $sql="SELECT COUNT(*) AS count FROM `bike_lend` where returnStationId!=0";
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
  $countReturn=$rs[0];
  }else{
  $countReturn=0;
  }
  // echo $countReturn;exit;

  $countNoReturn=$countLend-$countReturn; //未还车辆数；


                  if(isset($_GET['p'])){
                  $p=$_GET['p'];
                }else{
                  $p=1;
                }
                if(isset($_GET['pagesize'])){
                  $pagesize=$_GET['pagesize'];
                }else{$pagesize=10;}
                   
                $start=($p-1)*$pagesize;

                if(isset($_GET['person'])){
  $person=$_GET['person'];
  $sql="select * from `bike_lend` where userId=$person order by id desc limit $start,$pagesize";
}

               else if(isset($_GET['status'])){
                  $status=$_GET['status'];
                  $sql="select * from `bike_lend` where status=$status order by id desc limit $start,$pagesize";
                  }else{
                   $sql="select * from `bike_lend` order by id desc limit $start,$pagesize";
                  }
                  
                  $query=mysql_query($sql);

if(isset($_GET['person'])){
  $sql="select * from `bike_lend` where userId=$person";
  $personQuery=mysql_query($sql);
$num=mysql_num_rows($personQuery);

}
             else if(isset($_GET['status'])){
                $sql="select * from `bike_lend` where status=$status";
                $pageQuery=mysql_query($sql);
                $num=mysql_num_rows($pageQuery);
              }
              else{
                $sql="select * from `bike_lend`";
              $pageQuery=mysql_query($sql);
              $num=mysql_num_rows($pageQuery);
            }
              // print_r($num);exit;
              $pagecount=(($num%$pagesize)==0)?($num/$pagesize):(int)($num/$pagesize+1);
               // echo $pagecount;exit;
               $prevStatus=false;
               $nextStatus=false;
              if($p>1 && $p<=$pagecount){
             $prevStatus=true;
              }else{
            $prevStatus=false;
              }
              if($p>0 && $p<$pagecount){
                $nextStatus=true;
              }else{
                $nextStatus=false;
              }


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

    <title>借还管理 - <?php echo $siteName; ?></title>

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
            <!-- <li><a href="#"><span class="glyphicon glyphicon-search"></span></a></li> -->
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
            <li><a href="./index.php">总览</a></li>
            <li><a href="./station.php">站点管理</a></li>
            <li><a href="./user.php">用户管理</a></li>
            <li class="active"><a href="./lend.php">借还管理</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
          <h2 class="sub-header"><?php if(isset($_GET['status'])){echo '未还统计';}else if(isset($_GET['person'])){echo '个人借还信息';}else{echo '实时借还信息';} ?><small><?php if(isset($_GET['status'])){ echo "（".$countNoReturn."）";}else{;} ?></small>
            <small><a href="./lend.php?status=0"><?php if(isset($_GET['status'])){;}else if(isset($_GET['person'])){;}else{echo "（未还统计：".$countNoReturn."）";} ?></a></small></h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr><?php if($pagecount==0){;}else{ ?>
                  <th>微信名</th>
                  <th>借车时间</th>
                  <th>借车站点</th>
                  <th>还车时间</th>
                  <th>还车站点</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php


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
                  <td><a href="./user.php?id=<?php echo $userId ?>"><?php echo $rsUser['wechatName']; ?></a></td>
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
            <div style="text-align:center"><h4><?php if($pagecount==0){echo "该用户没有借还信息！";} ?></h4>
            <div style="text-align:center"><?php if($pagecount==0){;}else{echo "共 ".$pagecount." 页";} ?>
  <a href="<?php if($prevStatus){ if(isset($_GET['status'])){echo "./lend.php?status=0&p=".($p-1);}
                                  else{echo "./lend.php?p=".($p-1);}}
                 else{echo '#';} ?>"><?php if($pagecount==0){;}else{echo "上一页";} ?></a>
  <a href="<?php if($nextStatus){ if(isset($_GET['status'])){echo "./lend.php?status=0&p=".($p+1);}
                                  else{echo "./lend.php?p=".($p+1);}}
                 else{echo '#';} ?>"><?php if($pagecount==0){;}else{echo "下一页";} ?></a> <?php if($pagecount==0){;}else{echo "第 ".$p." 页";} ?></div>
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
