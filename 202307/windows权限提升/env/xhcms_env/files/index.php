<?php 
require 'inc/301.php';
require 'inc/conn.php';
require 'inc/time.class.php';
$query = "SELECT * FROM settings";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$info = mysql_fetch_array($resul);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $info['title']?></title>
<meta name="keywords" content="<?php echo $info['keywords']?>" />
<meta name="description" content="<?php echo $info['description']?>" />
<meta name="version" content="seacms V1.0.0310" />
<?php require 'template/header.php';?>
<div class="barn">
<div id="body">
<div id="imgtext">
<strong>Oh,Perfect</strong>
<span>个人免费开源程序倡导者</span>
</div>
<img src="images/banner.jpg">
</div></div>
<div id="body">
<div class="div1">
<div class="toutiaoimg">
<?php
$query = "SELECT * FROM content WHERE images<>'' AND xs=1 ORDER BY id DESC  LIMIT 1";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$toutiaoimg = mysql_fetch_array($resul);
?>
<a href="?r=content&cid=<?php echo $toutiaoimg['id']?>" title="<?php echo $toutiaoimg['title']?>"><img src="<?php echo $toutiaoimg['images']?>"></a>
</div>
<div class="toutiao">
<?php
$query = "SELECT * FROM content WHERE toutiao=1 AND xs=1 ORDER BY id DESC  LIMIT 5";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$toutiao = mysql_fetch_array($resul);
?>
<div class="tt">头条</div>
<h1><a href="?r=content&cid=<?php echo $toutiao['id']?>"><?php echo $toutiao['title']?></a></h1>
<div class="ttcontent">
<?php echo mb_substr(strip_tags($toutiao['content']),0,240,'utf8')?> ...
</div>
</div>
<div id="qcfd"></div>
</div>

<div class="listdiv">

<?php 
$query=mysql_query("select * FROM navclass WHERE tuijian=1");
while($navclass = mysql_fetch_array($query)){ 
?>
<div class="lmlist">
<div class="bt"> <?php echo $navclass['name']?></div>
<ul>
<?php 
$navclassid=$navclass['id'];
$query2=mysql_query("select * FROM content WHERE navclass='$navclassid' AND xs=1 ORDER BY id DESC  LIMIT 5");
while($content = mysql_fetch_array($query2)){ 
?>
<li><span><?php echo tranTime(strtotime($content['date']))?></span><a href="?r=content&cid=<?php echo $content['id']?>"><?php echo $content['title']?></a></li>
<?php }?>
</ul>
</div>
<?php }?>

<?php 
$query = "SELECT * FROM nav WHERE id=3";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$nav = mysql_fetch_array($resul);
if ($nav['xs']==1) {
?>
<div id="qcfd"></div>
</div>
<div class="products">
<div class="bt"> 最新下载</div>
<ul>
<?php 
$query2=mysql_query("select * FROM download WHERE images<>'' AND xs=1 ORDER BY id DESC  LIMIT 6");
while($download = mysql_fetch_array($query2)){ 
?>
<li><a href="?r=software&cid=<?php echo $download['id']?>"><img src="<?php echo $download['images']?>"><span><?php echo $download['title']?></span></a></li>
<?php }?>
</ul>
<div id="qcfd"></div>
</div>
<?php }?>
<div id="qcfd"></div>
<div id="link">
<ul>
<?php
$query=mysql_query("select * FROM link WHERE xs=1 ORDER BY id DESC");
while($link = mysql_fetch_array($query)){ 
?>
<li><a href="<?php echo $link['url']?>" target="_blank" title="<?php echo $link['jieshao']?>"><?php echo $link['name']?></a></li>
<?php }?>
<div id="qcfd"></div>
</ul>
</div>
</div>
<?php require 'template/footer.php';?>
</body>
</html>