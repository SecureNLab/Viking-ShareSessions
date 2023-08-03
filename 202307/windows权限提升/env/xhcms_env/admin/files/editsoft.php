<?php
require '../inc/checklogin.php';
require '../inc/conn.php';
$wzlistopen='class="open"';
$id=$_GET['id'];
$query = "SELECT * FROM download WHERE id='$id'";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$download = mysql_fetch_array($resul);

$save=$_POST['save'];
$title=$_POST['title'];
$author=$_POST['author'];
$keywords=$_POST['keywords'];
$description=$_POST['description'];
$images=$_POST['images'];
$daxiao=$_POST['daxiao'];
$language=$_POST['language'];
$version=$_POST['version'];
$demo=$_POST['demo'];
$url=$_POST['url'];
$softadd=$_POST['softadd'];
$softadd2=$_POST['softadd2'];
$content=$_POST['content'];
$xs=$_POST['xs'];
if ($xs==""){ $xs=1;}

if ($save==1){
//处理图片上传
if(!empty($_FILES['images']['tmp_name'])){
$query = "SELECT * FROM imageset";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$imageset = mysql_fetch_array($result);
include '../inc/up.class.php';
if (empty($HTTP_POST_FILES['images']['tmp_name']))//判断接收数据是否为空
{
		$tmp = new FileUpload_Single;
		$upload="../upload/soft/".date('Ymd');//图片上传的目录，这里是当前目录下的upload目录，可自已修改
		$tmp -> accessPath =$upload;
		if ( $tmp -> TODO() )
		{
			$filename=$tmp -> newFileName;//生成的文件名
			$filename=$upload.'/'.$filename;
			$imgsms="及图片";
			
		}
				
}
$img_kg=$imageset['img_kg'];;//水印开关
$img_logo=$imageset['img_logo'];//水印图片
$img_weizhi=$imageset['img_weizhi'];//水印位置
$img_slt=$imageset['img_slt'];//缩略图片开关
$img_moshi=$imageset['img_moshi']; //缩放模式
$img_wzkd=$imageset['img_wzkd']; //文章图片宽度
$img_wzgd=$imageset['img_wzgd']; //文章图片高度

require '../inc/images.class.php';   
$obj=new Img();
//裁剪图片
$Img_srcName = $obj->Img_BigToSamll($filename,$img_wzkd,$img_wzgd,"$filename",$img_moshi);
//生成缩略图
if ($img_slt==1){
$filename2="s_".str_replace($upload."/","",$filename);//得到文件名
$Img_srcName = $obj->Img_BigToSamll($filename,85,70,$upload.'/'.$filename2,$img_moshi);
}
//图片水印
if ($img_kg==1){
$obj->Img_Watermark($filename,$img_logo,$filename,$img_weizhi);
}

}

if ($title==""){
echo "<script>alert('抱歉，标题不能为空。');history.back()</script>";
exit;
	}
	
if ($author==""){
echo "<script>alert('抱歉，作者不能为空。');history.back()</script>";
exit;
	}
if ($daxiao==""){
echo "<script>alert('抱歉，大小不能为空。');history.back()</script>";
exit;
	}
if ($language==""){
echo "<script>alert('抱歉，环境不能为空。');history.back()</script>";
exit;
	}
if ($version==""){
echo "<script>alert('抱歉，版本不能为空。');history.back()</script>";
exit;
	}

if ($content==""){
echo "<script>alert('抱歉，内容不能为空。');history.back()</script>";
exit;
	}
		
if ($filename<>""){
$images="images='$filename',";	
	}

$query = "UPDATE download SET 
title='$title',
keywords='$keywords',
description='$description',
$images
daxiao='$daxiao',
language='$language',
version='$version',
author='$author',
demo='$demo',
url='$url',
softadd='$softadd',
softadd2='$softadd2',
xs='$xs',
content='$content',
date=now()
WHERE id='$id'";
@mysql_query($query) or die('修改错误：'.mysql_error());
echo "<script>alert('亲爱的，下载,".$imgsms."成功更新。');location.href='?r=softlist'</script>"; 
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>编辑软件 - 熊海CMS后台管理系统</title> 
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
	      <h2 class="pull-left">编辑软件
          <!-- page meta -->
          <span class="page-meta"> </span>
        </h2>


        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="?r=index"><i class="icon-home"></i> 首页</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">编辑软件</a>
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

                    <h6>编辑软件</h6>
                    <hr />
                    <!-- Form starts.  -->
                     <form class="form-horizontal" role="form" method="post" action=""  enctype="multipart/form-data">
                              
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">名称</label>
                                  <div class="col-lg-8">
<input type="text" name="title" class="form-control" placeholder="title" value="<?php echo $download['title']?>" >
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">作者</label>
                                  <div class="col-lg-8">
<input type="text" name="author" class="form-control" placeholder="author" value="<?php echo $download['author']?>" >
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">版本</label>
                                  <div class="col-lg-8">
                                    <input type="text" name="version" class="form-control" placeholder="version" value="<?php echo $download['version']?>">
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">关键字</label>
                                  <div class="col-lg-8">
<input type="text" name="keywords" class="form-control" placeholder="keywords" value="<?php echo $download['keywords']?>">
                                  </div>
                                </div>
                                
                                 <div class="form-group">
                                  <label class="col-lg-4 control-label">描述</label>
                                  <div class="col-lg-8">
<input type="text" name="description" class="form-control" placeholder="description" value="<?php echo $download['description']?>">
                                  </div>
                                </div>
                                 <div class="form-group">
                                  <label class="col-lg-4 control-label">大小</label>
                                  <div class="col-lg-8">
                                    <input type="text" name="daxiao" class="form-control" placeholder="daxiao" value="<?php echo $download['daxiao']?>">
                                  </div>
                                </div>
                             <div class="form-group">
                                  <label class="col-lg-4 control-label">环境</label>
                                  <div class="col-lg-8">
<input type="text" name="language" class="form-control" placeholder="language" value="<?php echo $download['language']?>">
                                  </div>
                                </div>
                                
                             <div class="form-group">
                                  <label class="col-lg-4 control-label">文件</label>
                                  <div class="col-lg-8">
                                    <input type="text" name="softadd" class="form-control" placeholder="softadd" value="<?php echo $download['softadd']?>">
                                  </div>
                                </div>
                                
                             <div class="form-group">
                                  <label class="col-lg-4 control-label">网盘</label>
                                  <div class="col-lg-8">
<input type="text" name="softadd2" class="form-control" placeholder="softadd2" value="<?php echo $download['softadd2']?>">
                                  </div>
                                </div>
                                 <div class="form-group">
                                  <label class="col-lg-4 control-label">图片</label>
                                  <div class="col-lg-8">
                                    <input type="file" name="images" class="form-control">
                                  </div>
                                </div>
                         <div class="form-group">
                                  <label class="col-lg-4 control-label">官网</label>
                                  <div class="col-lg-8">
<input type="text" name="url" class="form-control" placeholder="url" value="<?php echo $download['url']?>">
                                  </div>
                                </div>
 
                           <div class="form-group">
                                  <label class="col-lg-4 control-label">演示</label>
                                  <div class="col-lg-8">
<input type="text" name="demo" class="form-control" placeholder="demo" value="<?php echo $download['demo']?>">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">属性</label>
                                  <div class="col-lg-8">
                                    <label class="checkbox-inline">
<input name="xs" type="checkbox" id="inlineCheckbox1" value="0" <?php if ($download['xs']==0){echo 'checked="CHECKED"';}?>> 隐藏
                                    </label>
                                  </div>
                                </div>
                               
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">内容</label>
                                  <div class="col-lg-8">
<textarea name="content" id="editor"><?php echo $download['content']?></textarea>
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