<?php 
require 'inc/conn.php';
require 'inc/time.class.php';
$query = "SELECT * FROM settings";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$info = mysql_fetch_array($resul);

$id=addslashes($_GET['cid']);
$query = "SELECT * FROM content WHERE id='$id'";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$content = mysql_fetch_array($resul);

$navid=$content['navclass'];
$query = "SELECT * FROM navclass WHERE id='$navid'";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$navs = mysql_fetch_array($resul);

//浏览计数
$query = "UPDATE content SET hit = hit+1 WHERE id=$id";
@mysql_query($query) or die('修改错误：'.mysql_error());
?>
<?php
$query=mysql_query("select * FROM interaction WHERE (cid='$id' AND type=1 and xs=1)");
$pinglunzs = mysql_num_rows($query)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $content['title']?> - <?php echo $info['name']?></title>
<meta name="keywords" content="<?php echo $content['keywords']?>" />
<meta name="description" content="<?php echo $content['description']?>" />
<meta name="version" content="seacms V1.0.0310" />
<link rel="stylesheet" href="css/shCoreDefault.css" />
<script src="css/shCore.js"></script>
<script type="text/javascript">       
SyntaxHighlighter.all();        
</script>
<?php require 'template/header.php';?>
<div class="barn">
<div id="body">
<div id="imgtext">
<strong>添砖加瓦</strong>
<span>开放、平等、协作、分享。</span>
</div>
<img src="images/content.jpg">
</div></div>
<div id="body">
<div class="content">
<div class="yuedu">
<div class="tt">阅读</div>
<h1><div id="hit">点击：<?php echo $content['hit']?></div><?php echo $content['title']?></h1>
<div class="cinfo">
<span>时间：<?php echo tranTime(strtotime($content['date']))?></span>
<li>分类：<?php echo $navs['name']?></li>
<li>作者：<?php echo $content['author']?></li>
<li>评论：<a href="#Comment"><?php echo $pinglunzs?></a></li>
<div id="qcfd"></div>
</div>
<div class="ttcontent">

<?php if ($content['images']<>""){?>
<div id="ad1">
<a title="<?php echo $content['title']?>"><img src="<?php echo $content['images']?>"></a>
</div>
<?php }else{
$query = "SELECT ad1 FROM adword";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$ad = mysql_fetch_array($resul);
if ($ad['ad1']<>""){
echo '<div id="ad1">';	
echo $ad['ad1'];
echo '</div>';
}
}?>
<?php echo $content['content']?>
</div>
<div class="cinfo2">

<strong><div class="bdsharebuttonbox"><a class="bds_more" href="#" data-cmd="more"></a><a title="分享到QQ空间" class="bds_qzone" href="#" data-cmd="qzone"></a><a title="分享到新浪微博" class="bds_tsina" href="#" data-cmd="tsina"></a><a title="分享到腾讯微博" class="bds_tqq" href="#" data-cmd="tqq"></a><a title="分享到人人网" class="bds_renren" href="#" data-cmd="renren"></a><a title="分享到微信" class="bds_weixin" href="#" data-cmd="weixin"></a></div>
<script>
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script></strong>
<span>© 除非注明，否则均为原创，转载请注明来源。</span>
</div>

<?php 
$query = "SELECT ad3 FROM adword";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$ad = mysql_fetch_array($resul);
if ($ad['ad3']<>""){?>
<div id="ad3">
<?php echo $ad['ad3'];?>
</div>
<?php }?>
<div id="pinglun">
<a id="Comment"></a>
<div id="plbt"><span><a>所有评论</a></span>评论列表 - [ <?php echo $pinglunzs?> ]</div>
<?php
$query=mysql_query("select * FROM interaction WHERE (cid='$id' AND type=1 and xs=1) ORDER BY id  DESC LIMIT 5");
$pinglunzs = mysql_num_rows($query);
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

<div id="plbt"><strong>→ 和谐网络，文明发言！</strong>发表评论：</div>
<form  name="form" method="post" action="/?r=submit&type=comment&cid=<?php echo $id?>">
<input name="cid" type="hidden" value="<?php echo $id?>"/>
<ul>
<li><span>昵称</span><input name="name" type="text" value="<?php echo $_COOKIE['name']?>" /></li>
<li><span>邮箱</span><input name="mail" type="text" value="<?php echo $_COOKIE['mail']?>"/></li>
<li><span>网址</span><input name="url" type="text" value="<?php echo $_COOKIE['url']?>"/></li>
<textarea name="content" cols="" rows=""></textarea>
<input name="save" type="submit"  value="提交" id="input2"/>
<div id="code"><span>验证码</span><input name="randcode" type="text" /> <span id="yspan"><img src="../inc/code.class.php" onClick="this.src=this.src+'?'+Math.random();" title="看不清楚?点击刷新验证码?"></span>
</div>
<div id="xx">
<span><input name="jz" type="checkbox" value="1" checked="checked"/> 记住我的个人信息</span>
<span><input name="tz" type="checkbox" value="1" checked="checked"/> 回复后邮件通知我</span>
</div>

<div id="qcfd"></div>
</ul>
</form>
</div>
</div>
<?php require 'template/sidebar.php';?>
<div id="qcfd"></div>
</div>
</div>
<?php require 'template/footer.php';?>
</body>
</html>