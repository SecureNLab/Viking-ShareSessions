<?php
require '../inc/checklogin.php';
require '../inc/conn.php';
$columnlistopen='class="open"';

$delete=$_GET['delete'];

$delete2=$_GET['delete2'];

if ($delete<>""){
$query = "DELETE FROM nav WHERE id='$delete'";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
echo "<script>alert('亲，ID为".$delete."的栏目已经成功删除！');location.href='?r=columnlist'</script>";
exit; 
}
if ($delete2<>""){
$query = "DELETE FROM navclass WHERE id='$delete2'";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
echo "<script>alert('亲，ID为".$delete2."的二级栏目已经成功删除！');location.href='?r=columnlist'</script>";
exit; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>栏目列表 - 熊海CMS后台管理系统</title> 
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
        <h2 class="pull-left"><i class="icon-table"></i> 栏目列表</h2>

        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="?r=index"><i class="icon-home"></i> 首页</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">栏目列表</a>
        </div>

        <div class="clearfix"></div>

      </div>
      <!-- Page heading ends -->

	    <!-- Matter -->

	    <div class="matter">
        <div class="container">

          <!-- Table -->

            <div class="row">

              <div class="col-md-12">


                  <div class="widget-content">





                <div class="widget">

                <div class="widget-head">
                  <div class="pull-left">栏目列表</div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                    <a href="#" class="wclose"><i class="icon-remove"></i></a>
                  </div>  
                  <div class="clearfix"></div>
                </div>

                  <div class="widget-content">

                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                      
                        <tr>
                          <th>#</th>
                          <th>标题</th>
                          <th>类型</th>
                          <th>状态</th>
                          <th>排序</th>
                          <th>操作</th>
                        </tr>
           
                      </thead>
                      <tbody>
<?php
$query=mysql_query("select * FROM nav");
while($nav = mysql_fetch_array($query)){
switch($nav['type'])
{
case 1:
$type="关于";
break;
case 2:
$type="分类";
break;
case 3:
$type="下载";
break;
case 4:
$type="联系";
break;
}

$xs=$nav['xs'];
if ($xs==1){
$xs='<span class="label label-success">显示</span>';
	}else{
$xs='<span class="label label-danger">隐藏</span>';		
}
?>
<tr>
<td><?php echo $nav['id']?></td>
<td> <span class="label label-info"><?php echo  $nav['name']?></span></td>
<td><span class="label label-primary">一级栏目</span> [ <?php echo  $type?> ]</td>
<td><?php echo  $xs?></td>
<td><span class="label label-info"><?php echo  $nav['px']?></span></td>
<td>
<a href="?r=editcolumn&type=1&id=<?php echo $nav['id']?>"><button class="btn btn-xs btn-warning"><i class="icon-pencil"></i> </button></a>
<a href="?r=columnlist&delete=<?php echo $nav['id']?>" onClick="return confirm('操作警告：\n\n请注意，删除可能会影响整个系统关联项\n\n您确定要删除吗？') "><button class="btn btn-xs btn-danger"><i class="icon-remove"></i> </button></a>
</td>
</tr>
<?php 
$navid=$nav['id'];
$query2=mysql_query("select * FROM navclass WHERE nav='$navid'");
while($navclass = mysql_fetch_array($query2)){
$classxs=$navclass['xs'];
if ($classxs==1){
$classxs='<span class="label label-success">显示</span>';
	}else{
$classxs='<span class="label label-danger">隐藏</span>';		
}
?>
<tr>
<td><span class="label label-primary"><?php echo $nav['id']?></span> <span class="label label-default"><?php echo $navclass['id']?></span></td>
<td><span class="label label-success"><?php echo  $navclass['name']?></span></td>
<td><span class="label label-warning">二级栏目</span> [ 二级<?php echo  $type?> ]</td>
<td><?php echo  $classxs?></td>
<td><span class="label label-default"><?php echo  $navclass['px']?></span></td>
<td>
<a href="?r=editcolumn&type=2&id=<?php echo $navclass['id']?>"><button class="btn btn-xs btn-warning"><i class="icon-pencil"></i> </button></a>
<a href="?r=columnlist&delete2=<?php echo $navclass['id']?>" onClick="return confirm('操作警告：\n\n请注意，删除可能会影响整个系统关联项\n\n您确定要删除吗？') "><button class="btn btn-xs btn-danger"><i class="icon-remove"></i> </button></a>
</td>
</tr>
<?php }?>

<?php }?>
</tbody>
</table>

<div class="widget-foot">

<div class="clearfix"></div> 

</div></div></div>

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