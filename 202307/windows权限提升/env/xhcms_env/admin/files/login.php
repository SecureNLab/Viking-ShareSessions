<?php 
ob_start();
require '../inc/conn.php';
$login=$_POST['login'];
$user=$_POST['user'];
$password=$_POST['password'];
$checkbox=$_POST['checkbox'];

if ($login<>""){
$query = "SELECT * FROM manage WHERE user='$user'";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$users = mysql_fetch_array($result);

if (!mysql_num_rows($result)) {  
echo "<Script language=JavaScript>alert('抱歉，用户名或者密码错误。');history.back();</Script>";
exit;
}else{
$passwords=$users['password'];
if(md5($password)<>$passwords){
echo "<Script language=JavaScript>alert('抱歉，用户名或者密码错误。');history.back();</Script>";
exit;	
	}
//写入登录信息并记住30天
if ($checkbox==1){
setcookie('user',$user,time()+3600*24*30,'/');
}else{
setcookie('user',$user,0,'/');
}
echo "<script>this.location='?r=index'</script>";
exit;
}
exit;
ob_end_flush();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>登录 - 熊海CMS后台管理系统</title> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="">
  <!-- Stylesheets -->
  <link href="style/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="style/font-awesome.css">
  <link href="style/style.css" rel="stylesheet">
  <link href="style/bootstrap-responsive.css" rel="stylesheet">
  
  <!-- HTML5 Support for IE -->
  <!--[if lt IE 9]>
  <script src="js/html5shim.js"></script>
  <![endif]-->

  <!-- Favicon -->
  <link rel="shortcut icon" href="../images/favicon.ico">
</head>

<body>

<!-- Form area -->
<div class="admin-form">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <!-- Widget starts -->
            <div class="widget worange">
              <!-- Widget head -->
              <div class="widget-head">
                <i class="icon-lock"></i> 管理登录 
              </div>

              <div class="widget-content">
                <div class="padd">
                  <!-- Login form -->
                  <form method="post" class="form-horizontal" action="">
                    <!-- Email -->
                    <div class="form-group">
                      <label class="control-label col-lg-3" for="inputEmail">帐号</label>
                      <div class="col-lg-9">
                        <input type="text" name="user" class="form-control" id="inputEmail" placeholder="user">
                      </div>
                    </div>
                    <!-- Password -->
                    <div class="form-group">
                      <label class="control-label col-lg-3" for="inputPassword">密码</label>
                      <div class="col-lg-9">
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
                      </div>
                    </div>
                    <!-- Remember me checkbox and sign in button -->
                    <div class="form-group">
					<div class="col-lg-9 col-lg-offset-3">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="checkbox" value="1"> 记住一个月
                        </label>
						</div>
					</div>
					</div>
                        <div class="col-lg-9 col-lg-offset-2">
							<button type="submit" class="btn btn-danger" name="login" value="yes">登录</button>
							<button type="reset" class="btn btn-default">重置</button>
						</div>
                    <br />
                  </form>
				  
				</div>
                </div>
              
                <div class="widget-foot">
                  不是管理员? <a href="/">返回首页</a>
                </div>
            </div>  
      </div>
    </div>
  </div> 
</div>
	
		

<!-- JS -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>