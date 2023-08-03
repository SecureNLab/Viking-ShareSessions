<?php 
require 'inc/conn.php';
require 'inc/time.class.php';
$query = "SELECT * FROM settings";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$info = mysql_fetch_array($resul);
$navid=addslashes($_GET['class']);
$llink=addslashes($_GET['r']);
if ($navid==""){
$query = "SELECT * FROM nav WHERE link='$llink'";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$navs = mysql_fetch_array($resul);
$pageyema="r=".$navs['link'];
}else{
$query = "SELECT * FROM navclass WHERE id='$navid'";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$navs = mysql_fetch_array($resul);
$tiaojian="AND navclass='$navid'";
$pageyema="r=list&class=".$navs['id'];
	}


$yemas=$_GET['page'];
if ($yemas<>""){
$yema=" - 第 $yemas 页";
}else{
$yema="";	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $navs['name']?><?php echo $yema ?> - <?php echo $info['name']?></title>
<meta name="keywords" content="<?php echo $nav['keywords']?>" />
<meta name="description" content="<?php echo $nav['description']?>" />
<meta name="version" content="seacms V1.0.0310" />
<?php require 'template/header.php';?>
<div class="barn">
<div id="body">
<div id="imgtext">
<strong>菜鸟程序猿</strong>
<span>储存与分享与程序相关的那些事儿。</span>
</div>
<img src="images/list.jpg">
</div></div>
<div id="body">
<div class="content">

<div class="lblist">

<div class="bt">当前位置：<?php echo $navs['name']?></div>

<?php
$perpagenum =6;   
$total = mysql_fetch_array(mysql_query("SELECT count(*)FROM content WHERE xs=1 $tiaojian"));      
$Total = $total[0];   
if(addslashes($_GET['page'])=="")   
{    
$page=1;    
}    
else    
{    
$page=addslashes($_GET['page']);    
}
$startnum = ($page-1)*$perpagenum;  
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
 
$query=mysql_query("SELECT * FROM content WHERE xs=1 $tiaojian ORDER BY id DESC limit $startnum,$perpagenum ") ;
$i=$perpagenum*($page-1)+1; 
while($list = mysql_fetch_array($query)){  
$navclassid=$list['navclass'];
$query1 = "SELECT * FROM navclass WHERE id='$navclassid'";
$resul1 = mysql_query($query1) or die('SQL语句有误：'.mysql_error());
$navclass = mysql_fetch_array($resul1);
$imgsrc=$list['images'];
if($imgsrc==""){
$imgsrc='images/noimages.jpg';
	}
//查询评论
$cid=$list['id'];
$query2 = "SELECT id FROM interaction WHERE cid='$cid' AND xs=1 AND type=1";
$result2 = mysql_query($query2) or die('SQL语句有误：'.mysql_error());
$plzs = mysql_num_rows($result2);
?>
<div class="tdata">
<a href="?r=content&cid=<?php echo $list['id']?>"><img src="<?php echo $imgsrc ?>" ></a>
<div class="rdata">
<h5><a href="?r=content&cid=<?php echo $list['id']?>"><?php echo mb_substr($list['title'],0,30,'utf8')?></a></h5>
<div class="content">
<?php echo mb_substr(strip_tags($list['content']),0,80,'utf8') ?>...
</div>
<ul>
<li>分类：<a href="?r=list&class=<?php echo $list['navclass']?>"><?php echo $navclass['name']?></a></li>
<li>作者：<a><?php echo $list['author']?></a></li>
<li>点击：<a><?php echo $list['hit']?></a></li>
<li>评论：<a href="?r=content&cid=<?php echo $list['id']?>#Comment"><?php echo $plzs?></a></li>
<li>时间：<a><?php echo tranTime(strtotime($list['date']))?></a></li>
</ul>
</div>
</div>
<?php }?>
<div class="pagecode">
<span>
<a href="?<?php echo $pageyema?>">首页</a> -
<a href="<?php echo "?$pageyema&page=$per" ?>">上一页</a> -
<a href="<?php echo "?$pageyema&page=$next" ?>">下一页</a> -
<a href="<?php echo "?$pageyema&page=$Totalpage" ?>">尾页</a>
</span>

<a>第 <?php echo $page?> - <?php echo $Totalpage?> 页 共 <?php echo $Total?> 条</a>
</div>

</div>
</div>
<?php require 'template/sidebar.php';?>
<div id="qcfd"></div>
</div>
</div>
<?php require 'template/footer.php';?>
</body>
</html>