<div class="rightcontent">


<div class="fllist">
<div class="bt">分类列表</div>
<ul>
<?php
$query=mysql_query("select * FROM navclass");
while($listclass = mysql_fetch_array($query)){ 
if ($navid==$listclass['id']){
$libg='id="libg"';
}else{
$libg='';	
	}
?>
<a href="?r=list&class=<?php echo $listclass['id']?>"><li <?php echo $libg?>><?php echo $listclass['name']?></li></a>
<?php }?>
</ul>
<div id="qcfd"></div>
</div>
<div class="top">
<div class="bt">最近更新</div>
<ul>
<?php 
$query2=mysql_query("select * FROM content WHERE xs=1 ORDER BY id DESC  LIMIT 5");
while($content = mysql_fetch_array($query2)){ 
?>
<li><span><?php echo $content['hit']?></span><a href="?r=content&cid=<?php echo $content['id']?>"><?php echo $content['title']?></a></li>
<?php }?>
</ul>
</div>

<div class="top">
<div class="bt">点击排行</div>
<ul>
<?php 
$query2=mysql_query("select * FROM content WHERE xs=1 ORDER BY hit DESC  LIMIT 5");
while($content = mysql_fetch_array($query2)){ 
?>
<li><span><?php echo $content['hit']?></span><a href="?r=content&cid=<?php echo $content['id']?>"><?php echo $content['title']?></a></li>
<?php }?>
</ul>
</div>

<?php
$query = "SELECT ad2 FROM adword";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$ad2 = mysql_fetch_array($resul);	
if ($ad2['ad2']<>""){
?>
<div id="ad2">
<div class="bt">广告链接</div>
<?php echo $ad2['ad2']?>
</div>
</div>
<?php }?>