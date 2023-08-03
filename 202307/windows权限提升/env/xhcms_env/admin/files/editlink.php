<?php
require '../inc/checklogin.php';
require '../inc/conn.php';
$linklistopen='class="open"';
$id=$_GET['id'];
$query = "SELECT * FROM link WHERE id='$id'";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$link = mysql_fetch_array($resul);

$save=$_POST['save'];
$name=$_POST['name'];
$url=$_POST['url'];
$mail=$_POST['mail'];
$jieshao=$_POST['jieshao'];
$xs=$_POST['xs'];
if ($xs==""){
$xs=1;	
	}

if ($save==1){
	
if ($name==""){
echo "<script>alert('抱歉，链接名称不能为空。');history.back()</script>";
exit;
}
if ($url==""){
echo "<script>alert('抱歉，链接地址不能为空。');history.back()</script>";
exit;
}

$query = "UPDATE link SET 
name='$name',
url='$url',
mail='$mail',
jieshao='$jieshao',
xs='$xs',
date=now()
WHERE id='$id'";
@mysql_query($query) or die('修改错误：'.mysql_error());
echo "<script>alert('亲爱的，链接已经成功编辑。');location.href='?r=linklist'</script>"; 
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>编辑链接 - 熊海CMS后台管理系统</title> 
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
	      <h2 class="pull-left">编辑链接
          <!-- page meta -->
          <span class="page-meta"> </span>
        </h2>


        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="?r=index"><i class="icon-home"></i> 首页</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">编辑链接</a>
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

                    <h6>编辑链接</h6>
                    <hr />

 <form class="form-horizontal" role="form" method="post" action=""  enctype="multipart/form-data">
<div class="form-group">
<label class="col-lg-4 control-label">链接名称</label>
<div class="col-lg-8">
<input name="name" type="text" class="form-control" placeholder="name" value="<?php echo $link['name']?>">
</div>
</div>
                       
<div class="form-group">
 <label class="col-lg-4 control-label">链接地址</label>
<div class="col-lg-8">
<input name="url" type="text" class="form-control" placeholder="url" value="<?php echo $link['url']?>" >
</div>
</div>
<div class="form-group">
 <label class="col-lg-4 control-label">站长邮箱</label>
<div class="col-lg-8">
<input name="mail" type="text" class="form-control" placeholder="mail" value="<?php echo $link['mail']?>">
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">链接介绍</label>
<div class="col-lg-8">
<textarea name="jieshao" class="form-control col-lg-12" placeholder="jieshao"><?php echo $link['jieshao']?></textarea>
</div>
</div>
                       
<div class="form-group">
<label class="col-lg-4 control-label">属性</label>
 <div class="col-lg-8">
<label class="checkbox-inline">
<input name="xs" type="checkbox" value="0" <?php if ($link['xs']<>1){echo 'checked="CHECKED"';}?>> 隐藏
</label>
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