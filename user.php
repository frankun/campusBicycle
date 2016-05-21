<?php
include("judge.php");
include("conn.php");
empty($_GET['type']) && $_GET['type'] = 'new';
$sql="SELECT COUNT(*) AS count FROM `bike_user`";
$query=mysql_query($sql);
if($rs=mysql_fetch_array($query)){ 
  $count=$rs[0];
}else{ 
  $count=0; 
}

$timeToday=strtotime(date("Y-m-d"));   //计算今天零点的UNIX时间戳；
$sql="SELECT COUNT(*) AS count FROM `bike_user` where createAt>=$timeToday"; //计算该表中注册时间大于今日零点的用户数量；
$query=mysql_query($sql);
if($rs=mysql_fetch_array($query)){
  $countNewUser=$rs[0];      //新用户数量；
}else{
  $countNewUser=0;
}

if(isset($_GET['p'])){
  $p=$_GET['p'];
}else{
  $p=1;
}
if(isset($_GET['pagesize'])){
  $pagesize=$_GET['pagesize'];
}else{
  $pagesize=10;
}

$start=($p-1)*$pagesize;

  if(!empty($_GET['keys'])){
    $keys="`wechatName` like '%".$_GET['keys']."%' ";
  }else{
    $keys=1;
  }
                  
if(isset($_GET['id'])){
  $id=$_GET['id'];
  $sql="select * from `bike_user` where id=$id order by id desc";
}
                else if($_GET['type']=='new'){
                  $sql="select * from `bike_user` where createAt>=$timeToday order by id desc limit $start,$pagesize";
                  }
                else {
                   $sql="select * from `bike_user` where $keys order by id desc limit $start,$pagesize";
                  }
                $query=mysql_query($sql);

if(!empty($_GET['keys'])){
    $keys="select * from `bike_user` where `wechatName` like '%".$_GET['keys']."%' ";
    $userQuery=mysql_query($sql);
    $num=mysql_num_rows($userQuery);
    $pagecount=(($num%$pagesize)==0)?($num/$pagesize):(int)($num/$pagesize+1);
}
else if(isset($_GET['id'])){
  $sql="select * from `bike_user` where id=$id";
  $userQuery=mysql_query($sql);
  $num=mysql_num_rows($userQuery);
  $pagecount=(($num%$pagesize)==0)?($num/$pagesize):(int)($num/$pagesize+1);
}
else if($_GET['type']=='new'){  
$sql="select * from `bike_user` where createAt>=$timeToday";            
$userQuery=mysql_query($sql);
$num=mysql_num_rows($userQuery);
$pagecount=(($num%$pagesize)==0)?($num/$pagesize):(int)($num/$pagesize+1);} 
              else{
              $sql="select * from `bike_user`";
              $userQuery=mysql_query($sql);
              $num=mysql_num_rows($userQuery);
              $pagecount=(($num%$pagesize)==0)?($num/$pagesize):(int)($num/$pagesize+1);}

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

    <title>用户管理 - <?php echo $siteName;?></title>

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
            <li class="active"><a href="./user.php">用户管理</a></li>
            <li><a href="./lend.php">借还管理</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
          <h2 class="sub-header"><?php if($_GET['type']=='new'){ echo '新增用户';}else if(isset($_GET['id'])){echo '该用户个人信息';}else if(!empty($_GET['keys'])){echo '搜索用户结果';}else{ echo '全部用户';} ?><small><?php if(!empty($_GET['keys'])){;}else if(isset($_GET['id'])){;}else if($_GET['type']=='new'){ echo "（".$countNewUser."）";}else{ echo "（".$count."）";} ?></small>
            <small><a href="./user.php?type=new"><?php if(!empty($_GET['keys'])){;}else if(isset($_GET['id'])){;}else if($_GET['type']=='new'){;}else{echo "（新增用户：".$countNewUser."）";} ?></a></small></h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr><?php if($pagecount==0){;}else{ ?>
                  <th>微信名</th>
                  <th>性别</th>
                  <th>注册时间</th>
                  <th>借车次数</th>
                  <th>状态</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                  <?php
                      while($rs=mysql_fetch_array($query)){
                        $userId=$rs['id'];
                        $sql="select count(*) as count from `bike_lend` where userId=$userId";
                        $lendQuery=mysql_query($sql);
                        $rsLend=mysql_fetch_array($lendQuery);
                        $countLend=$rsLend[0];

                        $sql="select * from `bike_lend` where userId=$userId order by id desc";
                        // print_r($sql);exit;
                        $statusQuery=mysql_query($sql);
                        $rsStatus=mysql_fetch_array($statusQuery);

                  ?>
                <tr>
                  <td><a href="./lend.php?person=<?php echo $userId; ?>"><?php echo $rs['wechatName'];if($_GET['type']=='new'){echo （新）;}else{;} ?><a></td>
                  <td><?php if($rs['gender']==1){echo 男;}else{echo 女;} ?></td>
                  <td><?php $dates=$rs['createAt']; echo date("Y-m-d",$dates); ?></td>
                  <td><?php echo $countLend; ?></td>
                  <td><?php if(!$rsStatus){echo '未借';}else if($rsStatus['status']==1){echo '已还';}else{echo '未还';} ?></td>  
                  <!-- 先查询数据库是否有这条数据，再判断status的值； -->
                </tr> 
                  <?php
                }
                  ?> 
              </tbody>
            </table>
            <div style="text-align:center"><h4><?php if($pagecount==0){
           if($_GET['type']=='new'){
            echo '暂无新用户';
           }else{
            echo "未找到该用户！";
           }
              } ?></h4>
 <div style="text-align:center"><?php if($pagecount==0){;}else{echo "共 ".$pagecount." 页";} ?>
  <a href="<?php if($prevStatus){ if($_GET['type']=='new'){echo "./user.php?type=new&p=".($p-1);}
                                  else{echo "./user.php?p=".($p-1);}}
                 else{echo '#';} ?>"><?php if($pagecount==0){;}else{echo "上一页";} ?></a>
  <a href="<?php if($nextStatus){ if($_GET['type']=='new'){echo "./user.php?type=new&p=".($p+1);}
                                  else{echo "./user.php?p=".($p+1);}}
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
