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
$pageyema="r=contact";
$page=addslashes($_GET['page']);
if ($page<>""){
if ($page<>1){
$pages="第".$page."页 - ";
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $navs['name']?> - <?php echo $pages.$info['name']?></title>
<meta name="keywords" content="<?php echo $nav['keywords']?>" />
<meta name="description" content="<?php echo $nav['description']?>" />
<meta name="version" content="seacms V1.0.0310" />
<?php require 'template/header.php';?>
<div class="barn">
<div id="body">
<div id="imgtext">
<strong>联系我们</strong>
<span>你联不联系，我都在这里。</span>
</div>
<img src="images/contact.jpg">
</div></div>
<div id="body">
<div class="content">
<div class="contact">
<div class="bt">当前位置：<?php echo $navs['name']?></div>
<ul>
<?php echo $navs['content']?>
</ul>


<div class="contactlist">
<div class="lylist">
<div id="pinglun">
<a id="Comment"></a>
<?php
$perpagenum =5;   
$total = mysql_fetch_array(mysql_query("SELECT count(*)FROM interaction WHERE (xs=1 AND cid=0 AND type=2) $tiaojian"));      
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
 
$query=mysql_query("SELECT * FROM interaction WHERE (xs=1 AND cid=0 AND type=2) ORDER BY id DESC limit $startnum,$perpagenum ") ;
$i=$perpagenum*($page-1)+1; 
?>
<div id="plbt"><span><a>所有留言</a></span>留言列表 - [ <?php echo $Total?> ]</div>
<?php
while($pinglun = mysql_fetch_array($query)){  
?>
<!--评论内容-->
<div id="plcontent">
<ul>
<div class="userinfo">
<div class="lou">#<?php echo $pinglun['id']?> 楼</div>
<?php if ($pinglun['url']<>""){?> 
<a href="<?php echo $pinglun['url']?>" target="_blank" ><img src="upload/portrait/<?php echo $pinglun['touxiang']?>.jpg"></a>
<?php }else{?>
<img src="upload/portrait/<?php echo $pinglun['touxiang']?>.jpg">
<?php }?>
<strong><a href="<?php echo $pinglun['url']?>" target="_blank"><?php echo $pinglun['name']?></a><span>Lv 1</span></strong>
<li>位置：<a><?php echo $pinglun['ip']?></a></li>
<li>时间：<a><?php echo tranTime(strtotime($pinglun['date']))?></a></li>
<li>来自：<a><?php echo $pinglun['shebei']?></a></li>
</div>
<div class="content">
<?php echo $pinglun['content']?>
</div>
</ul>
<?php if ($pinglun['rcontent']<>""){?>
<div class="manageinfo">
<ul>
<div class="lou">回复 #<?php echo $pinglun['id']?> 楼</div>
<?php 
$query2 = "SELECT * FROM manage";
$resul2 = mysql_query($query2) or die('SQL语句有误：'.mysql_error());
$manage2 = mysql_fetch_array($resul2);
if ($manage2['img']==""){
$touxiang="images/manage.jpg";
} else{
$touxiang=$manage2['img'];		
}
?>
<img src="<?php echo $touxiang?>">
<strong><?php echo $manage2['name']?><span>认证站长</span></strong>
<li>位置：<a><?php echo $pinglun['rip']?></a></li>
<li>时间：<a><?php echo tranTime(strtotime($pinglun['rdate']))?></a></li>
<li>来自：<a><?php echo $pinglun['rshebei']?></a></li>
</ul>
</div>
<div class="content2">
<?php echo $pinglun['rcontent']?>
</div>
<?php }?>
<div id="qcfd"></div>
</div>
<!--评论内容end-->
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

<div id="plbt"><strong>→ 和谐网络，文明发言！</strong>发表留言：</div>
<form  name="form" method="post" action="/?r=submit&type=message">
<input name="cid" type="hidden" value="0"/>
<ul>
<li><span>昵称</span><input name="name" type="text" value="<?php echo $_COOKIE['name']?>" /></li>
<li><span>邮箱</span><input name="mail" type="text" value="<?php echo $_COOKIE['mail']?>"/></li>
<li><span>网址</span><input name="url" type="text" value="<?php echo $_COOKIE['url']?>"/></li>
<textarea name="content" cols="" rows=""></textarea>
<input name="save" type="submit"  value="提交" id="input2"/>
<div id="code"><span>验证码</span><input name="randcode" type="text" /> <span id="yspan"><img src="../inc/code.class.php" onClick="this.src=this.src+'?'+Math.random();" title="看不清楚?点击刷新验证码?"></span>
</div>
<div id="xx">选项：
<span><input name="jz" type="checkbox" value="1" checked="checked"/> 记住我的个人信息</span>
<span><input name="tz" type="checkbox" value="1" checked="checked"/> 回复后邮件通知我</span>
</div>
<div id="qcfd"></div>
</ul>
</form>
</div>


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