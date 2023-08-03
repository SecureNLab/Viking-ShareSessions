<?php
require '../inc/checklogin.php';
require '../inc/conn.php';
$setopen='class="open"';
$query = "SELECT * FROM manage";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$manage = mysql_fetch_array($resul);

$save=$_POST['save'];

$user=$_POST['user'];
$name=$_POST['name'];
$password=$_POST['password'];
$password2=$_POST['password2'];
$img=$_POST['img'];
$mail=$_POST['mail'];
$qq=$_POST['qq'];

if ($save==1){
	
	
if ($user==""){
echo "<script>alert('抱歉，帐号不能为空。');history.back()</script>";
exit;
	}
	
if ($name==""){
echo "<script>alert('抱歉，名称不能为空。');history.back()</script>";
exit;
	}
if ($password<>$password2){
echo "<script>alert('抱歉，两次密码输入不一致！');history.back()</script>";
exit;
	}

//处理图片上传
if(!empty($_FILES['images']['tmp_name'])){
$query = "SELECT * FROM imageset";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$imageset = mysql_fetch_array($result);
include '../inc/up.class.php';
if (empty($HTTP_POST_FILES['images']['tmp_name']))//判断接收数据是否为空
{
		$tmp = new FileUpload_Single;
		$upload="../upload/touxiang";//图片上传的目录，这里是当前目录下的upload目录，可自已修改
		$tmp -> accessPath =$upload;
		if ( $tmp -> TODO() )
		{
			$filename=$tmp -> newFileName;//生成的文件名
			$filename=$upload.'/'.$filename;
			$imgsms="及图片";
			
		}		
}
}

if ($filename<>""){
$images="img='$filename',";	
}

if ($password<>""){
$password=md5($password);
$password="password='$password',";
}

$query = "UPDATE manage SET 
user='$user',
name='$name',
$password
$images
mail='$mail',
qq='$qq',
date=now()";
@mysql_query($query) or die('修改错误：'.mysql_error());
echo "<script>alert('亲爱的，资料".$imgsms."设置已成功更新！');location.href='?r=manageinfo'</script>"; 
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>资料设置 - 熊海CMS后台管理系统</title> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="">
  <!-- Stylesheets -->
  <link href="style/bootstrap.css" rel="stylesheet">
  <!-- Font awesome icon -->
  <link rel="stylesheet" href="style/font-awesome.css"> 
  <!-- jQuery UI -->
  <link rel="stylesheet" href="style/jquery-ui.css"> 
  <!-- Calendar -->
  <link rel="stylesheet" href="style/fullcalendar.css">
  <!-- prettyPhoto -->
  <link rel="stylesheet" href="style/prettyPhoto.css">  
  <!-- Star rating -->
  <link rel="stylesheet" href="style/rateit.css">
  <!-- Date picker -->
  <link rel="stylesheet" href="style/bootstrap-datetimepicker.min.css">
  <!-- CLEditor -->
  <link rel="stylesheet" href="style/jquery.cleditor.css"> 
  <!-- Uniform -->
  <link rel="stylesheet" href="style/uniform.default.css"> 
  <!-- Bootstrap toggle -->
  <link rel="stylesheet" href="style/bootstrap-switch.css">
  <!-- Main stylesheet -->
  <link href="style/style.css" rel="stylesheet">
  <!-- Widgets stylesheet -->
  <link href="style/widgets.css" rel="stylesheet">   
  
  <!-- HTML5 Support for IE -->
  <!--[if lt IE 9]>
  <script src="js/html5shim.js"></script>
  <![endif]-->

  <!-- Favicon -->
  <link rel="shortcut icon" href="../images/favicon.ico">
  
  <script type="text/javascript" charset="utf-8" src="../seacmseditor/ueditor.config.js"></script>
  <script type="text/javascript" charset="utf-8" src="../seacmseditor/ueditor.all.min.js"> </script>
  <script type="text/javascript" charset="utf-8" src="../seacmseditor/lang/zh-cn/zh-cn.js"></script>
  <script type="text/javascript">
    UE.getEditor('editor');
  </script>
</head>

<body>
<?php require 'template/top.php';?>
<!-- Header starts -->
<?php require 'template/header.php';?>
<!-- Header ends -->
<!-- Main content starts -->
<?php require 'template/sidebar.php';?>
<!-- Sidebar ends -->
  	<!-- Main bar -->
  	<div class="mainbar">
      
	    <!-- Page heading -->
	    <div class="page-head">
        <!-- Page heading -->
	      <h2 class="pull-left">资料设置
          <!-- page meta -->
          <span class="page-meta"> </span>
        </h2>


        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="?r=index"><i class="icon-home"></i> 首页</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">资料设置</a>
        </div>

        <div class="clearfix"></div>

	    </div>
	    <!-- Page heading ends -->



	    <!-- Matter -->

	    <div class="matter">
        <div class="container">

          <div class="row">

            <div class="col-md-12">


              <div class="widget wgreen">
                
                <div class="widget-head">
                  <div class="pull-left">表单</div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                    <a href="#" class="wclose"><i class="icon-remove"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="widget-content">
                  <div class="padd">

                    <h6>资料设置</h6>
                    <hr />
                    <!-- Form starts.  -->
                     <form class="form-horizontal" role="form" method="post" action=""  enctype="multipart/form-data">
                     
<div class="form-group">
<label class="col-lg-4 control-label">帐号</label>
<div class="col-lg-8">
<input type="text" name="user" class="form-control" value="<?php echo $manage['user']?>" >
</div>
</div>
                                
                         <div class="form-group">
                         <label class="col-lg-4 control-label">名称</label>
                          <div class="col-lg-8">
<input type="text" name="name" class="form-control"  value="<?php echo $manage['name']?>" >
                                  </div>
                                </div>
                              
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">密码</label>
                                  <div class="col-lg-8">
<input type="password" name="password" class="form-control" placeholder="不修改请保持为空"  >
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">重复密码</label>
                                  <div class="col-lg-8">
<input type="password" name="password2" class="form-control" placeholder="不修改请保持为空" >
                                  </div>
                                </div>
                                
                                 <div class="form-group">
                                  <label class="col-lg-4 control-label">邮箱</label>
                                  <div class="col-lg-8">
<input type="text" name="mail" class="form-control"  value="<?php echo $manage['mail']?>">
                                  </div>
                                </div>
<div class="form-group">
<label class="col-lg-4 control-label">QQ</label>
<div class="col-lg-8">
<input type="text" name="qq" class="form-control" value="<?php echo $manage['qq']?>">
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">头像</label>
<div class="col-lg-8">
<input type="text" class="form-control" value="<?php echo $manage['img']?>" readonly>
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">上传</label>
<div class="col-lg-8">
<input type="file" name="images" class="form-control">
</div>
</div>
<hr />
<div class="form-group">
<div class="col-lg-offset-1 col-lg-9">
<button type="submit" class="btn btn-primary" name="save" value="1">保存</button>
<button type="reset" class="btn btn-success">重置</button>
</div>
</div>
</form>
                  </div>
                </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
              </div>  

            </div>

          </div>

        </div>
		  </div>

		<!-- Matter ends -->

    </div>

   <!-- Mainbar ends -->	    	
   <div class="clearfix"></div>

</div>
<!-- Content ends -->

<!-- Footer starts -->
<?php require 'template/footer.php';?>	
<!-- Footer ends -->

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span> 

<!-- JS -->
<script src="js/jquery.js"></script> <!-- jQuery -->
<script src="js/bootstrap.js"></script> <!-- Bootstrap -->
<script src="js/jquery-ui-1.9.2.custom.min.js"></script> <!-- jQuery UI -->
<script src="js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->
<script src="js/jquery.rateit.min.js"></script> <!-- RateIt - Star rating -->
<script src="js/jquery.prettyPhoto.js"></script> <!-- prettyPhoto -->

<!-- jQuery Flot -->
<script src="js/excanvas.min.js"></script>
<script src="js/jquery.flot.js"></script>
<script src="js/jquery.flot.resize.js"></script>
<script src="js/jquery.flot.pie.js"></script>
<script src="js/jquery.flot.stack.js"></script>

<!-- jQuery Notification - Noty -->
<script src="js/jquery.noty.js"></script> <!-- jQuery Notify -->
<script src="js/themes/default.js"></script> <!-- jQuery Notify -->
<script src="js/layouts/bottom.js"></script> <!-- jQuery Notify -->
<script src="js/layouts/topRight.js"></script> <!-- jQuery Notify -->
<script src="js/layouts/top.js"></script> <!-- jQuery Notify -->
<!-- jQuery Notification ends -->

<script src="js/sparklines.js"></script> <!-- Sparklines -->
<script src="js/jquery.cleditor.min.js"></script> <!-- CLEditor -->
<script src="js/bootstrap-datetimepicker.min.js"></script> <!-- Date picker -->
<script src="js/jquery.uniform.min.js"></script> <!-- jQuery Uniform -->
<script src="js/bootstrap-switch.min.js"></script> <!-- Bootstrap Toggle -->
<script src="js/filter.js"></script> <!-- Filter for support page -->
<script src="js/custom.js"></script> <!-- Custom codes -->
<script src="js/charts.js"></script> <!-- Charts & Graphs -->

</body>
</html>