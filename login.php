<?php
session_start();
 include("conn.php");
header("Content-Type: text/html;charset=utf-8");
 if(!empty($_POST['sub'])){

$username=$_POST['username'];
$password=$_POST['password'];
 $sql="select * from `bike_admin` where username='$username' and password='$password'";
$query=mysql_query($sql);
$rs=mysql_fetch_array($query);


if($rs){
  $_SESSION['id']=$rs['id'];
  $_SESSION['ps']=$rs['password'];
  // echo "success";
header('Location:./index.php');
}else{
  echo "用户名或密码错误！";
}
exit;
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

    <title>登录 - <?php echo $siteName; ?></title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

  </head>

  <body>

    <div class="container">

      <form action="login.php" method="post" class="form-signin" role="form">
        <h2 class="form-signin-heading">管理员登录</h2>
        <input type="text" name="username" class="form-control" placeholder="用户名" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="密码" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me">记住该账号
          </label>
        </div>
       <button class="btn btn-lg btn-primary btn-block" type="submit" name="sub" value="1">登录</button>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
