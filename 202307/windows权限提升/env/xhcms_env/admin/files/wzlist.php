<?php
require '../inc/checklogin.php';
require '../inc/conn.php';
$wzlistopen='class="open"';
$pageyema="?r=wzlist&page=";

$delete=$_GET['delete'];
if ($delete<>""){
$query = "DELETE FROM content WHERE id='$delete'";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
echo "<script>alert('亲，ID为".$delete."的内容已经成功删除！');location.href='?r=wzlist'</script>";
exit; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>文章列表 - 熊海CMS后台管理系统</title> 
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
        <h2 class="pull-left"><i class="icon-table"></i> 列表</h2>

        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="?r=index"><i class="icon-home"></i> 首页</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">列表</a>
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
                  <div class="pull-left">文章列表</div>
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
                          <th>分类</th>
                          <th>状态</th>
                          <th>时间</th>
                          <th>操作</th>
                        </tr>
           
                      </thead>
                      <tbody>
<?php
$perpagenum =15;//定义每页显示几条    
$total = mysql_fetch_array(mysql_query("select count(*) from content WHERE id>0"));      
   
$Total = $total[0];   
if($_GET['page']=="")   
{    
$page=1;    
}    
else    
{    
$page=$_GET['page'];    
}    
//获得当前页    
$startnum = ($page-1)*$perpagenum;//每页的其实位置    
if($page>1)   
$per=$page-1;   
else  
$per=1;   
if($Total%$perpagenum==0)   
$Totalpage=$Total/$perpagenum;   
else  
$Totalpage=(integer)($Total/$perpagenum)+1;   
$next=$page+1;   
if($next>=$Totalpage)   
 $next=$Totalpage;   
 
$query=mysql_query("select * from content ORDER BY id DESC limit $startnum,$perpagenum ") ;
$i=$perpagenum*($page-1)+1; 
while($list = mysql_fetch_array($query)){
$fl_id=$list['navclass'];
$query1 = "SELECT * FROM navclass WHERE id='$fl_id'";
$resul1 = mysql_query($query1) or die('SQL语句有误：'.mysql_error());
$classname = mysql_fetch_array($resul1); 
$xs=$list['xs'];
if ($xs==1){
$xs='<span class="label label-success">显示</span>';
	}else{
$xs='<span class="label label-danger">隐藏</span>';		
		}
if ($list['toutiao']==1){;	
$toutiao=' <span class="label label-info">头条</span>';
}else{
$toutiao=' ';
}
if ($list['images']<>""){;	
$images=' <span class="label label-warning">图</span>';
}else{
$images=' ';
}
?>
                        <tr>
                          <td><?php echo $list['id']?></td>
                          <td><?php echo  $list['title']?></td>
                          <td><?php echo $classname ['name'];?></td>
                          <td><?php echo $xs .$toutiao .$images?></td>
                          <td><?php echo  date('Y-m-d',strtotime($list['date']))?></td>
                          <td>
<a href="/?r=content&cid=<?php echo $list['id']?>" target="_blank"><button class="btn btn-xs btn-success"><i class="icon-ok"></i> </button></a>
<a href="?r=editwz&id=<?php echo $list['id']?>"><button class="btn btn-xs btn-warning"><i class="icon-pencil"></i> </button></a>
<a href="?r=wzlist&delete=<?php echo $list['id']?>" onClick="return confirm('操作警告：\n\n请注意，删除可能会影响整个系统关联项\n\n您确定要删除吗？') "><button class="btn btn-xs btn-danger"><i class="icon-remove"></i> </button></a>
                          
                          </td>
                        </tr>

<?php }?>
                           

                      </tbody>
                    </table>

                    <div class="widget-foot">
<ul class="pagination pull-left">
<li><a>第 <?php echo $page?> - <?php echo $Totalpage?> 页 共 <?php echo $Total?> 条</a></li>
</ul>
<ul class="pagination pull-right">
<li><a href="<?php echo $pageyema.$key.$kemus.$zt ?>">首</a></li>
<li><a href="<?php echo $pageyema.$per.$key.$kemus.$zt ?>">上</a></li>
<li><a href="<?php echo $pageyema.$next.$key.$kemus.$zt ?>">下</a></li>
<li><a href="<?php echo $pageyema.$Totalpage.$key.$kemus.$zt ?>">尾</a></li>

                      </ul>
                     
                      <div class="clearfix"></div> 

                    </div>

                  </div>

                </div></div></div>


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