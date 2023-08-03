<?php 
require 'inc/conn.php';
require 'inc/time.class.php';
$query = "SELECT * FROM settings";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$info = mysql_fetch_array($resul);
$llink=addslashes($_GET['r']);
$query = "SELECT * FROM nav WHERE link='$llink'";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$navs = mysql_fetch_array($resul);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $navs['name']?> - <?php echo $info['name']?></title>
<meta name="keywords" content="<?php echo $nav['keywords']?>" />
<meta name="description" content="<?php echo $nav['description']?>" />
<meta name="version" content="seacms V1.0.0310" />
<?php require 'template/header.php';?>
<div class="barn">
<div id="body">
<div id="imgtext">
<strong><?php echo $navs['name']?></strong>
<span>取人之长，补己之短。</span>
</div>
<img src="images/about.jpg">
</div></div>
<div id="body">
<div class="content">
<div class="contact">
<div class="bt">当前位置：<?php echo $navs['name']?></div>
<ul>
<?php echo $navs['content']?>
</ul>
</div>
<?php require 'template/sidebar.php';?>
<div id="qcfd"></div>
</div>
</div>
<?php require 'template/footer.php';?>
</body>
</html>