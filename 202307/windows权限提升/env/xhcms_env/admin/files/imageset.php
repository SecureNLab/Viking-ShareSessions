<?php
require '../inc/checklogin.php';
require '../inc/conn.php';
$setopen='class="open"';
$query = "SELECT * FROM imageset";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$image = mysql_fetch_array($resul);

$save=$_POST['save'];
$img_kg=$_POST['img_kg'];
$img_logo=$_POST['img_logo'];
$img_weizhi=$_POST['img_weizhi'];
$img_slt=$_POST['img_slt'];
$img_moshi=$_POST['img_moshi'];
$img_wzkd=$_POST['img_wzkd'];
$img_wzgd=$_POST['img_wzgd'];
if ($save==1){
//处理图片上传
if(!empty($_FILES['images']['tmp_name'])){
include '../inc/up.class.php';
if (empty($HTTP_POST_FILES['images']['tmp_name']))//判断接收数据是否为空
{
		$tmp = new FileUpload_Single;
		$upload="../upload/watermark";//图片上传的目录，这里是当前目录下的upload目录，可自已修改
		$tmp -> accessPath =$upload;
		if ( $tmp -> TODO() )
		{
			$filename=$tmp -> newFileName;//生成的文件名
			$filename=$upload.'/'.$filename;		
		}		
}

}
	
if ($filename<>""){
$images="img_logo='$filename',";	
	}
$query = "UPDATE imageset SET 
img_kg='$img_kg',
$images
img_weizhi='$img_weizhi',
img_slt='$img_slt',
img_moshi='$img_moshi',
img_wzkd='$img_wzkd',
img_wzgd='$img_wzgd'";
@mysql_query($query) or die('修改错误：'.mysql_error());
echo "<script>alert('亲爱的，图片设置成功更新。');location.href='?r=imageset'</script>"; 
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>图片设置 - 熊海CMS后台管理系统</title> 
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
	      <h2 class="pull-left">图片设置
          <!-- page meta -->
          <span class="page-meta"> </span>
        </h2>


        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="?r=index"><i class="icon-home"></i> 首页</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">图片设置</a>
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
<h6>图片设置</h6>
 <hr />
<!-- Form starts.  -->
<form class="form-horizontal" role="form" method="post" action=""  enctype="multipart/form-data">                  
<div class="form-group">
<label class="col-lg-4 control-label">属性</label>
<div class="col-lg-8">
<label class="checkbox-inline">
<input name="img_kg" type="checkbox"  value="1" <?php if ($image['img_kg']==1){echo 'checked="CHECKED"';}?>> 水印
</label>
<label class="checkbox-inline">
<input type="checkbox" name="img_slt" value="1" <?php if ($image['img_slt']==1){echo 'checked="CHECKED"';}?>> 缩略图
</label>
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">水印图片</label>
<div class="col-lg-8">
<input type="text"  class="form-control" placeholder="images" value="<?php echo $image['img_logo']?>" >
                                  </div>
                                </div>
<div class="form-group">
<label class="col-lg-4 control-label">水印上传</label>
<div class="col-lg-8">
<input type="file" name="images" class="form-control" >
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">水印位置</label>
<div class="col-lg-8">
<div class="radio">
<label>
<input type="radio" name="img_weizhi"  value="1" <?php if ($image['img_weizhi']==1){echo 'checked';}?>>
左上角
</label>
</div>
<div class="radio">
<label>
<input type="radio" name="img_weizhi"  value="2" <?php if ($image['img_weizhi']==2){echo 'checked';}?>>
居中
</label>
</div>
<div class="radio">
<label>
<input type="radio" name="img_weizhi"  value="3" <?php if ($image['img_weizhi']==3){echo 'checked';}?>>
右下角
</label>
</div>
</div>
</div>
                                
<div class="form-group">
<label class="col-lg-4 control-label">缩放模式</label>
<div class="col-lg-8">
<div class="radio">
<label>
<input type="radio" name="img_moshi"  value="1" <?php if ($image['img_moshi']==1){echo 'checked';}?>  >
居中
</label>
</div>
<div class="radio">
<label>
<input type="radio" name="img_moshi"  value="2" <?php if ($image['img_moshi']==2){echo 'checked';}?>>
裁剪
</label>
</div>
<div class="radio">
<label>
<input type="radio" name="img_moshi"  value="3" <?php if ($image['img_moshi']==3){echo 'checked';}?>>
等比例
</label>
</div>
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">图片宽度</label>
<div class="col-lg-8">
<input type="text" name="img_wzkd" class="form-control" placeholder="img_wzkd" value="<?php echo $image['img_wzkd']?>" >
</div>
</div>
<div class="form-group">
<label class="col-lg-4 control-label">图片高度</label>
<div class="col-lg-8">
<input type="text" name="img_wzgd" class="form-control" placeholder="img_wzgd" value="<?php echo $image['img_wzgd']?>" >
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