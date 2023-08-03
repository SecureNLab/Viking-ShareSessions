<?php
require '../inc/checklogin.php';
require '../inc/conn.php';
$columnlistopen='class="open"';
$type=$_GET['type'];

$save=$_POST['save'];
$name=$_POST['name'];
$keywords=$_POST['keywords'];
$description=$_POST['description'];
$px=$_POST['px'];
$xs=$_POST['xs'];
if ($xs==""){
$xs=1;	
}
$tuijian=$_POST['tuijian'];
if ($tuijian==""){
$$tuijian=0;	
}

$content=$_POST['content'];

if ($save==1){
	
if ($name==""){
echo "<script>alert('抱歉，名称不能为空。');history.back()</script>";
exit;
}
if ($px==""){
echo "<script>alert('抱歉，排序不能为空。');history.back()</script>";
exit;
}

if ($type==1){
	
$query = "INSERT INTO nav (
name,keywords,description,xs,px,link,type,content,date
) VALUES (
'$name','$keywords','$description','$xs','$px','pages','5','$content',now()
)";@mysql_query($query) or die('新增错误：'.mysql_error());
echo "<script>alert('亲爱的，一级单页已经成功添加。');location.href='?r=columnlist'</script>"; 
exit;
}

if ($type==2){
$query = "INSERT INTO navclass (
nav,name,keywords,description,xs,px,tuijian,date
) VALUES (
'2','$name','$keywords','$description','$xs','$px','$tuijian',now()
)";@mysql_query($query) or die('新增错误：'.mysql_error());

echo "<script>alert('亲爱的，二级分类已经成功添加。');location.href='?r=columnlist'</script>"; 
exit;
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>编辑栏目 - 熊海CMS后台管理系统</title> 
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
	      <h2 class="pull-left">编辑栏目
          <!-- page meta -->
          <span class="page-meta"> </span>
        </h2>


        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="?r=index"><i class="icon-home"></i> 首页</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">编辑栏目</a>
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
<h6>编辑栏目</h6>
<hr />
<form class="form-horizontal" role="form" method="post" action=""  enctype="multipart/form-data">
<div class="form-group">
<label class="col-lg-4 control-label">名称</label>
<div class="col-lg-8">
<input name="name" type="text" class="form-control" >
</div>
</div>
<div class="form-group">
 <label class="col-lg-4 control-label">关键字</label>
<div class="col-lg-8">
<input name="keywords" type="text" class="form-control" >
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">描述</label>
<div class="col-lg-8">
<input name="description" type="text" class="form-control"  >
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">排序</label>
<div class="col-lg-8">
<input name="px" type="text" class="form-control"  >
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">属性</label>
<div class="col-lg-8">
<label class="checkbox-inline">
<input name="xs" type="checkbox" value="0" > 隐藏
</label>
<?php if ($type==2){?>
<label class="checkbox-inline">
<input name="tuijian" type="checkbox" value="1" > 推荐
</label>
<?php }?> 
</div>
</div>
<?php if ($type==1){?>
<div class="form-group">
<label class="col-lg-4 control-label">内容</label>
<div class="col-lg-8">
<textarea name="content" id="editor"></textarea>
</div>
</div>    
<?php }?>                   
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