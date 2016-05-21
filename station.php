<?php  
include("judge.php");
  include("conn.php");//引入链接数据库  

  if(!empty($_POST['sub'])){  
 // print_r($_POST);exit;
    $name=$_POST['name'];  
    $x=$_POST['x'];
    $y=$_POST['y'];
    $number=$_POST['number'];  
    $initNumber=$_POST['initNumber'];  
    $sql="insert into `bike_station`(id,name,number,x,y,initNumber) values (null,'$name','$number','$x','$y','$initNumber')";
    mysql_query($sql); 
  }  

  if(!empty ($_POST['del_sub'])){
  //print_r($_POST);exit;  
     $d=$_POST['id'];
     $sql="delete from `bike_station` where id='$d'";  
     //echo $sql;exit;
     mysql_query($sql); 

  }

    if(!empty ($_POST['edit_sub'])){  
    // print_r($_POST);exit;
     $sql="select * from `bike_station` where id='".$_POST['id']."'";
     //echo $sql;exit;
     $query=mysql_query($sql);  
     $rs=mysql_fetch_array($query);  
     //print_r($rs);exit;
  }  

    if(!empty($_POST['edit_sub'])){  
    $name=$_POST['name'];  
    $x=$_POST['x'];
    $y=$_POST['y'];
    $number=$_POST['number']; 
    $initNumber=$_POST['initNumber'];
    $sql="update `bike_station` set name='$name',number='$number',x='$x',y='$y',initNumber='$initNumber' where id='".$_POST['id']."' limit 1 ";  
    mysql_query($sql); 
  }

  $sql="SELECT COUNT(*) AS count FROM `bike_station`";
  $query=mysql_query($sql);
  if($rs=mysql_fetch_array($query)){
  $count=$rs[0];
  }else{
  $count=0;  //计算站点数量；
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

    <title>站点管理 - <?php echo $siteName; ?></title>

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
          <form action="./user.php" method="get" class="navbar-form navbar-right">
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
            <li class="active"><a href="./station.php">站点管理</a></li>
            <li><a href="./user.php">用户管理</a></li>
            <li><a href="./lend.php">借还管理</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
          <h2 class="sub-header">全部站点<small>（<?php echo $count; ?>）</small></h2>
          <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">添加站点</button>

<!-- 添加站点的模态框 -->
<form action="station.php" method="post" class="form-horizontal" role="form">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">添加一个站点:</h4>
      </div>
      <div class="modal-body">
  <div class="form-group">
    <label for="inputzdwz" class="col-sm-2 control-label">站点位置</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputStationId" name="name" placeholder="站点名">
    </div>
  </div>
  <div class="form-group">
    <label for="inputxzb" class="col-sm-2 control-label">X坐标</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputX" name="x" placeholder="X坐标">
    </div>
  </div>
  <div class="form-group">
    <label for="inputyzb" class="col-sm-2 control-label">Y坐标</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputY" name="y" placeholder="Y坐标">
    </div>
  </div>
  <div class="form-group">
    <label for="inputtfsl" class="col-sm-2 control-label">停放数量</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputNumber" name="number"placeholder="停放数量">
    </div>
  </div>
     <div class="form-group">
    <label for="inputtfsl" class="col-sm-2 control-label">初始数量</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputInitNumber" name="initNumber" placeholder="初始数量">
    </div>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" name="sub" value="1" class="btn btn-primary">确认</button>
      </div>
    </div>
  </div>
</div>
</form>

          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <!-- <th>站点号</th> -->
                  <th>站点位置</th>
                  <th>X坐标</th>
                  <th>Y坐标</th>
                  <th>停放数量</th>
                  <th>初始数量</th>
                  <th>流量</th>
                  <th><span id="xxx">操作</span></th>
                </tr>
              </thead>
              <tbody>
                  <?php
                        $sql="select * from `bike_station` order by id desc";
                        $query=mysql_query($sql);

                      while($rs=mysql_fetch_array($query)){
                        $stationId=$rs['id'];
                        $sql="select count(*) as count from `bike_lend` where lendStationId=$stationId";
                        $lendQuery=mysql_query($sql);
                        $rsLend=mysql_fetch_array($lendQuery);
                        $countLend=$rsLend[0];

                        $sql="select count(*) as count from `bike_lend` where returnStationId=$stationId";
                        $returnQuery=mysql_query($sql);
                        $rsReturn=mysql_fetch_array($returnQuery);
                        $countReturn=$rsReturn[0];
                  ?>
                  <tr>
                  <!-- <td>站点<?php echo $rs['id'] ?></td> -->
                  <td><?php echo $rs['name'] ?></td>
                  <td><?php echo $rs['x'] ?></td>
                  <td><?php echo $rs['y'] ?></td>
                  <td><?php echo $rs['number'] ?></td>
                  <td><?php echo $rs['initNumber'] ?></td>
                  <td><?php echo $sumStation=$countLend+$countReturn; ?></td>
                  <td><a class="edit" href="#" stationId="<?php echo $rs['id'] ?>"
                       inputEditStationId="<?php echo $rs['name'] ?>" 
                       inputEditX="<?php echo $rs['x'] ?>"
                       inputEditY="<?php echo $rs['y'] ?>"
                       inputEditNumber="<?php echo $rs['number'] ?>"
                       inputEditInitNumber="<?php echo $rs['initNumber'] ?>" >编辑</a> 
                       <a class="del" href="#" stationId="<?php echo $rs['id'] ?>">删除</a></td>
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

<!-- 编辑的模态框  -->             
<form action="station.php" method="post" class="form-horizontal" role="form">
<div class="modal fade" id="myEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">修改该站点的内容:</h4>
      </div>
      <div class="modal-body">
  <div class="form-group">
    <label for="inputzdwz" class="col-sm-2 control-label">站点位置</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEditStationId" name="name" value="">
    </div>
  </div>
  <div class="form-group">
    <label for="inputxzb" class="col-sm-2 control-label">X坐标</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEditX" name="x">
    </div>
  </div>
  <div class="form-group">
    <label for="inputyzb" class="col-sm-2 control-label">Y坐标</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEditY" name="y">
    </div>
  </div>
  <div class="form-group">
    <label for="inputtfsl" class="col-sm-2 control-label">停放数量</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEditNumber" name="number">
    </div>
  </div>
   <div class="form-group">
    <label for="inputtfsl" class="col-sm-2 control-label">初始数量</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEditInitNumber" name="initNumber">
    </div>
  </div>
      <input type="hidden" class="form-control" id="editStationId" value="" name="id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" name="edit_sub" value="1" class="btn btn-primary">确认</button>
      </div>
    </div>
  </div>
</div>
</form>


<!-- 删除的模态框 -->
<form action="station.php" method="post" class="form-horizontal" role="form">
<div class="modal fade" id="myDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h5 class="modal-title" id="myModalLabel">提示:</h5>
      </div>
      <div class="modal-body">
      <div style="text-align:center">确认删除？</div>
      <input type="hidden" class="form-control" id="delStationId" value="" name="id">
  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" name="del_sub" value="1" class="btn btn-primary">确认</button>
      </div>
    </div>
  </div>
</div>
</form>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jQuery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

<script type="text/javascript">
$(".del").on("click",function(){
var stationId=$(this).attr("stationId");
//alert(stationId);
$("#delStationId").val(stationId);
  $("#myDelete").modal();
});
</script>

<script type="text/javascript">
$(".edit").on("click",function(){
var stationId=$(this).attr("stationId");
// alert(stationId);
var inputEditStationId=$(this).attr("inputEditStationId");
var inputEditX=$(this).attr("inputEditX");
var inputEditY=$(this).attr("inputEditY");
var inputEditNumber=$(this).attr("inputEditNumber");
var inputEditInitNumber=$(this).attr("inputEditInitNumber");
$("#editStationId").val(stationId);
$("#inputEditStationId").val(inputEditStationId);
$("#inputEditX").val(inputEditX);
$("#inputEditY").val(inputEditY);
$("#inputEditNumber").val(inputEditNumber);
$("#inputEditInitNumber").val(inputEditInitNumber);
  $("#myEdit").modal();
});
</script>

  </body>
</html>
















