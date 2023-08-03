<?php
require '../inc/checklogin.php';
require '../inc/conn.php';
$hdopen='class="open"';

$type=$_GET['type'];
if ($type==1){
$fhlink="?r=commentlist&type=comment";
$fhname="评论";
$biao="content";
}
if ($type==2){
$fhlink="?r=commentlist&type=message";
$fhname="留言";
$biao="content";
}

if ($type==3){
$fhlink="?r=commentlist&type=download";
$fhname="软件评论";
$biao="download";
}

$id=$_GET['id'];
$query = "SELECT * FROM interaction WHERE id='$id'";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$reply = mysql_fetch_array($resul);
$cid=$reply['cid'];
$query = "SELECT * FROM $biao WHERE id='$cid'";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$contents = mysql_fetch_array($resul);


$save=$_POST['save'];
$xs=$_POST['xs'];
if ($xs==""){
$xs=0;	}
$name=$_POST['name'];
$mail=$_POST['mail'];
$url=$_POST['url'];
$touxiang=$_POST['touxiang'];
$content=$_POST['content'];
$tz=$_POST['tz'];
if ($tz==""){
$tz=0;	
	}
$rcontent=$_POST['rcontent'];
if ($save==1){
	
if ($name==""){
echo "<script>alert('抱歉，昵称不能为空。');history.back()</script>";
exit;
	}
	
if ($touxiang==""){
echo "<script>alert('抱歉，头像不能为空。');history.back()</script>";
exit;
	}
if ($mail==""){
echo "<script>alert('抱歉，邮箱不能为空。');history.back()</script>";
exit;
	}
if ($content==""){
echo "<script>alert('抱歉，内容不能为空。');history.back()</script>";
exit;
	}	

$rip=$_SERVER["REMOTE_ADDR"];

//设备类型
$useragent = $_SERVER['HTTP_USER_AGENT'];
//var_dump($user_agent);
if(stristr($useragent,'iPad')) {
$rshebei= "iPad";
}else if(stristr($useragent,'Android')) {
$rshebei= "Android";
}else if(stristr($useragent,'iPhone')){
$rshebei= "iPhone";
}else if(stristr($useragent,'Linux')){
$rshebei= "Linux";
}else{
$rshebei= "PC";
}

$query = "UPDATE interaction SET 
xs='$xs',
name='$name',
mail='$mail',
url='$url',
touxiang='$touxiang',
content='$content',
tz='$tz',
rip='$rip',
rshebei='$rshebei',
rcontent='$rcontent',
rdate=now() WHERE id='$id'";
@mysql_query($query) or die('修改错误：'.mysql_error());

//查询系统高级设置
$query = "SELECT * FROM seniorset";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$advanced = mysql_fetch_array($result);
$huifu=$advanced ['huifu'];//回复通知

if ($huifu==1 AND $tz==1 AND $rcontent<>"" AND $mail<>""){	
//发送邮件
$query = "SELECT * FROM settings";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$settings = mysql_fetch_array($result);

include "../inc/mail.class.php";  
$smtpserver = $advanced['smtpname']; 
$port =25; //smtp服务器的端口，一般是 25 
$smtpuser = $advanced['faname']; //您登录smtp服务器的用户名 
$smtppwd = $advanced['fapass']; //您登录smtp服务器的密码 
$mailtype = "HTML"; //邮件的类型，可选值是 TXT 或 HTML ,TXT 表示是纯文本的邮件,HTML 表示是 html格式的邮件 
$sender = $advanced['faname']; 
//发件人,一般要与您登录smtp服务器的用户名($smtpuser)相同,否则可能会因为smtp服务器的设置导致发送失败 
$smtp = new smtp($smtpserver,$port,true,$smtpuser,$smtppwd,$sender); 
//$smtp->debug = true; //是否开启调试,只在测试程序时使用，正式使用时请将此行注释 
$to = $mail; //收件人
$subject = $name."，你在".$settings['name']."上的".$fhname."有了新的回复"; 

$url=$settings['url'];
$wzname=$settings['name'];
$zz=$settings['zz'];//站长

if ($type==1){
$query = "SELECT * FROM content WHERE( id= $cid)";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$wz = mysql_fetch_array($result);
$title=$wz['title'];
$body ='
<div style="border:1px double #090;">
<div style="background:#090; padding:10px 10px 10px 20px; color:#FFF; font-size:16px;">
您曾在 <a style="text-decoration:none;color:#fff;" href="'.$url.'"  target="_blank">'.$wzname.'</a> 上的'.$fhname.'有了回复：
</div>
<div style=" padding:10px 10px 5px 20px; font-size:12px">亲爱的 [ '.$name.' ] ：您好!</div>
<div style=" padding:5px 10px 10px 20px; font-size:12px">您曾对 [ '.$wzname.' ] 文章: 《 <a style="text-decoration:none;" href="'.$url.'/?r=content&cid='.$cid.'"  target="_blank"> '.$title.' </a> 》'.$fhname.'：</div>
<div style="padding:10px 10px 10px 10px; font-size:12px; background:#f2f2f2;border:1px double #ccc; margin:0px 15px 0px 15px; line-height:25px;" >'.$content.'</div>
<div style=" padding:10px 10px 10px 20px; font-size:12px">[ '.$zz.' ] 给您的回复如下：</div>
<div style="padding:10px 10px 10px 10px; font-size:12px; background:#f2f2f2;border:1px double #ccc;margin:0px 15px 0px 15px; line-height:25px;">'.$rcontent.'</div>
<div style=" padding:10px 10px 10px 20px; font-size:12px">→ 您可以点击 <a style="text-decoration:none;" href="'.$url.'/?r=content&cid='.$cid.'#Comment" target="_blank">查看完整內容</a></div>
<div style=" padding:10px 10px 10px 20px; font-size:12px"><strong>温馨提示</strong> 本邮件由系统自动发出，可以直接回复！</div>
</div>
'; }

if ($type==2){
$body = '
<div style="border:1px double #f60;">
<div style="background:#f60; padding:10px 10px 10px 20px; color:#FFF; font-size:16px;">
您在 <a style="text-decoration:none;color:#fff;" href="'.$url.'"  target="_blank">'.$wzname.'</a> 上'.$fhname.'有了回复：
</div>
<div style=" padding:10px 10px 5px 20px; font-size:12px">亲爱的 [ '.$name.' ] ：您好!</div>
<div style=" padding:5px 10px 10px 20px; font-size:12px">您曾在 [ '.$wzname.' ] '.$fhname.'说道：</div>
<div style="padding:10px 10px 10px 10px; font-size:12px; background:#f2f2f2;border:1px double #ccc; margin:0px 15px 0px 15px; line-height:25px;" >'.$content.'</div>
<div style=" padding:10px 10px 10px 20px; font-size:12px">[ '.$zz.' ] 给您的回复如下：</div>
<div style="padding:10px 10px 10px 10px; font-size:12px; background:#f2f2f2;border:1px double #ccc;margin:0px 15px 0px 15px; line-height:25px;">'.$rcontent.'</div>
<div style=" padding:10px 10px 10px 20px; font-size:12px">→ 您可以点击 <a style="text-decoration:none;" href="'.$url.'/?r=contact#Comment" target="_blank">查看完整內容</a></div>
<div style=" padding:10px 10px 10px 20px; font-size:12px"><strong>温馨提示</strong> 本邮件由系统自动发出，可以直接回复！</div>
</div>'; }

if ($type==3){
$query = "SELECT * FROM download WHERE( id= $cid)";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$soft = mysql_fetch_array($result);
$title=$soft['title'];
$body ='
<div style="border:1px double #06f;">
<div style="background:#06f; padding:10px 10px 10px 20px; color:#FFF; font-size:16px;">
您曾在 <a style="text-decoration:none;color:#fff;" href="'.$url.'"  target="_blank">'.$wzname.'</a> 上的'.$fhname.'有了回复：
</div>
<div style=" padding:10px 10px 5px 20px; font-size:12px">亲爱的 [ '.$name.' ] ：您好!</div>
<div style=" padding:5px 10px 10px 20px; font-size:12px">您曾对 [ '.$wzname.' ] 软件: 《 <a style="text-decoration:none;" href="'.$url.'/?r=software&cid='.$cid.'"  target="_blank"> '.$title.' </a> 》'.$fhname.'：</div>
<div style="padding:10px 10px 10px 10px; font-size:12px; background:#f2f2f2;border:1px double #ccc; margin:0px 15px 0px 15px; line-height:25px;" >'.$content.'</div>
<div style=" padding:10px 10px 10px 20px; font-size:12px">[ '.$zz.' ] 给您的回复如下：</div>
<div style="padding:10px 10px 10px 10px; font-size:12px; background:#f2f2f2;border:1px double #ccc;margin:0px 15px 0px 15px; line-height:25px;">'.$rcontent.'</div>
<div style=" padding:10px 10px 10px 20px; font-size:12px">→ 您可以点击 <a style="text-decoration:none;" href="'.$url.'/?r=software&cid='.$cid.'#Comment" target="_blank">查看完整內容</a></div>
<div style=" padding:10px 10px 10px 20px; font-size:12px"><strong>温馨提示</strong> 本邮件由系统自动发出，可以直接回复！</div>
</div>
'; }

$send=$smtp->sendmail($to,$sender,$subject,$body,$mailtype); 

if($send==1){ 
$msg=",并已发送邮件通知.";
}else{ 
$msg=",但邮件发送失败."; 
}

}

if($tz<>1 or $huifu<>1){
$msg="恭喜,".$fhname."信息已成功保存。";
}

if($huifu==1 AND $tz==1 AND $rcontent<>"" AND $mail<>""){
$msg="恭喜,".$fhname."信息已成功保存".$msg;
	}
	
if($huifu==1 AND $tz==1 AND $rcontent==""){
$msg="恭喜,".$fhname."信息已成功保存。";
	}
	
if($huifu==1 AND $tz==1 AND $rcontent<>"" AND $mail==""){
$msg="恭喜,".$fhname."信息已成功保存,因邮箱为空，所以邮件未发送。";
	}

echo "<script>alert('".$msg."');location.href='".$fhlink."'</script>"; 
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>回复<?php echo $fhname?> - 熊海CMS后台管理系统</title> 
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
	      <h2 class="pull-left">回复<?php echo $fhname?>
          <!-- page meta -->
          <span class="page-meta"> </span>
        </h2>


        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="?r=index"><i class="icon-home"></i> 首页</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">回复<?php echo $fhname?></a>
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

                    <h6>回复<?php echo $fhname?></h6>
                    <hr />
                    <!-- Form starts.  -->
                     <form class="form-horizontal" role="form" method="post" action=""  enctype="multipart/form-data">
<div class="form-group">
<label class="col-lg-4 control-label"><?php echo $fhname?></label>
<div class="col-lg-8">
<h6><?php echo $contents['title']?></h6>
</div>
                                </div>
                         <div class="form-group">
                         <label class="col-lg-4 control-label">昵称</label>
                          <div class="col-lg-8">
<input type="text" name="name" class="form-control" value="<?php echo $reply['name']?>" >
                                  </div>
                                </div>
                              
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">邮箱</label>
                                  <div class="col-lg-8">
<input type="text" name="mail" class="form-control"  value="<?php echo $reply['mail']?>" >
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">网址</label>
                                  <div class="col-lg-8">
<input type="text" name="url" class="form-control"  value="<?php echo $reply['url']?>" >
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">头像</label>
                                  <div class="col-lg-8">
<input type="text" name="touxiang" class="form-control" value="<?php echo $reply['touxiang']?>" >
                                  </div>
                                </div>
                                
<div class="form-group">
<label class="col-lg-4 control-label">内容</label>
<div class="col-lg-8">
<textarea name="content" class="form-control col-lg-12" ><?php echo $reply['content']?></textarea>
</div>
</div>
            
<h6>回复<?php echo $fhname?></h6>
<hr />
                  
<div class="form-group">
<label class="col-lg-4 control-label">属性</label>
<div class="col-lg-8">
<label class="checkbox-inline">
<input name="xs" type="checkbox"  value="1" <?php if ($reply['xs']==1){echo 'checked="CHECKED"';}?> > 显示
</label>
<label class="checkbox-inline">
<input type="checkbox" name="tz"  value="1" <?php if ($reply['tz']==1){echo 'checked="CHECKED"';}?>> 邮件通知
</label>
</div>
</div>

<div class="form-group">
<label class="col-lg-4 control-label">回复</label>
<div class="col-lg-8">
<textarea name="rcontent" class="form-control col-lg-12"><?php echo $reply['rcontent']?></textarea>
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