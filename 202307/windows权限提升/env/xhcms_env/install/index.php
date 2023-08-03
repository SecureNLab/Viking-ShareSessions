<?PHP
ob_start();
error_reporting(0);
header('Content-Type:text/html;charset=utf-8');
if(file_exists('InstallLock.txt'))
 {
echo "你已经成功安装熊海内容管理系统，如果需要重新安装请删除install目录下的InstallLock.txt";
exit;
 }
$save=$_POST['save'];
$user=$_POST['user'];
$password=md5($_POST['password']);
$dbhost=$_POST['dbhost'];
$dbuser=$_POST['dbuser'];
$dbpwd=$_POST['dbpwd'];
$dbname=$_POST['dbname'];
if ($save<>""){
if ($user==""){
echo "<script>alert('抱歉，管理用户名不能为空！');history.back()</script>";
exit;	
	}
if ($_POST['password']==""){
echo "<script>alert('抱歉，管理密码不能为空！');history.back()</script>";
exit;	
	}
if ($dbhost==""){
echo "<script>alert('抱歉，数据库地址不能为空！');history.back()</script>";
exit;	
	}
	if ($dbname==""){
echo "<script>alert('抱歉，数据库名不能为空！');history.back()</script>";
exit;	
	}
	if ($dbuser==""){
echo "<script>alert('抱歉，数据库用户名不能为空！');history.back()</script>";
exit;	
	}
	if ($dbpwd==""){
echo "<script>alert('抱歉，数据库密码不能为空！');history.back()</script>";
exit;	
	}
include '../inc/db.class.php';
$db = new DBManage ( $dbhost, $dbuser, $dbpwd, $dbname, 'utf8' );
$db->restore ('seacms.sql');
$content = "<?php
\$DB_HOST='".$dbhost."';
\$DB_USER='".$dbuser."';
\$DB_PWD='".$dbpwd."';
\$DB_NAME='".$dbname."';
?>
";
$of = fopen('../inc/conn.info.php','w');
if($of){
 fwrite($of,$content);
}
echo "MySQL数据库连接配置成功!<br /><br />";


$conn = @mysql_connect($dbhost,$dbuser,$dbpwd) or die('数据库连接失败，错误信息：'.mysql_error());
mysql_select_db($dbname) or die('数据库错误，错误信息：'.mysql_error());
mysql_query('SET NAMES UTF8') or die('字符集设置错误'.mysql_error());

$query = "UPDATE manage SET user='$user',password='$password',name='$user'";
@mysql_query($query) or die('修改错误：'.mysql_error());
echo "管理信息已经成功写入!<br /><br />";


$content = "熊海内容管理系统 V1.0\r\n\r\n安装时间：".date('Y-m-d H:i:s');
$of = fopen('InstallLock.txt','w');
if($of){
 fwrite($of,$content);
}
fclose($of);
echo "为防止重复安装，安装锁已经生成!<br /><br />";
echo "<font color='#006600'>恭喜,熊海网站管理系统已经成功安装！</font>";
exit;
ob_end_flush();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统安装 - 熊海网站内容管理系统</title>
<style>
body{
	margin:0px;
	padding:0px;
	font-size:14px;
	font-family:"Microsoft Yahei", Arial, Helvetica, sans-serif;
	color:#333;
	background:#f2f2f2;
	}
a{
	color:#06f;
	text-decoration:none;
	}
img {border:0px;}
#body{width:800px; margin-left:auto;margin-right:auto; margin-top:50px; border:1px double #ccc; background:#FFF; margin-bottom:50px;}
#body h1{ text-align:center; border-bottom:1px dotted #FFF; line-height:30px;font-size:26px; color:#06f;}
#body #content{ padding:20px; line-height:30px; text-indent:20px; clear:both}
#body #content span{ margin-left:100px;}
#data { padding:20px; margin-left:50px; margin-bottom:20px;}
#data li {line-height:40px; list-style:none; float:left; margin-right:40px;}
#data li span{ display:block; width:150px;}
#data li input{ width:300px; border:#CCC 1px double; height:25px;vertical-align:middle;padding-left:10px;}
.qcfd{clear:both;}
#in2{
	clear:both;
	width:120px;
	height:35px;
	margin-top:20px;
	text-align:center;
	border:1px #F60 double;
	background:#F60;
	color:#FFF;
	}
#sm{
	clear:both;
	text-align:center;
	padding:5px;
	border:1px #FF0000 double;
	margin-top:20px;
	}
</style>
</head>

<body>
<div id="body">
<h1>系统安装</h1>
<div id="content">
熊海网站内容管理系统（SEACMS）是由熊海开发的一款可广泛应用于个人博客，个人网站，企业网站的一套网站管理系统。
目前系统已经集成：代码高亮、广告模块、文件图片上传、图片水印、图片缩略图，智能头像，互动邮件通知等。部份模块添加多种实用功能，欢迎体验。
<br />
程序作者：熊海  <span>博客：<a href="http://www.isea.so" target="_blank">www.isea.so</a></span> <span>个人网站：<a href="http://www.isea.pw" target="_blank">www.isea.pw</a></span><br />
交流QQ群：22206973   因本人工作繁忙，恕不接待程序安装及使用问题，如有问题请加群或在官网反馈。
<br />
<div id="sm">声明：请勿将本程序用于任何非法目的，一切后果与作者无关。</div>
</div>
<h1>系统配置</h1>
<div id="data">
<form id="form1" name="form1" method="post" action="">
<li><span>管理帐号：</span><input type="text"  name="user" value="admin" /></li>
<li><span>管理密码：</span><input name="password" type="text" /></li>

<li><span>数据库服务器：</span><input type="text" name="dbhost" value="localhost" /></li>
<li><span>数据库名称：</span><input name="dbname" type="text" /></li>
<li><span>数据库用户名：</span><input name="dbuser" type="text" /></li>
<li><span>数据库密码：</span><input name="dbpwd" type="text" /></li>
<div class="qcfd"></div>
<input name="save" type="submit" value="确认正确并提交" id="in2"/>
</form>
<div class="qcfd"></div>
</div>
</div>
</body>
</html>
