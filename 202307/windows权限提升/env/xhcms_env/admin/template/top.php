<div class="navbar navbar-fixed-top bs-docs-nav" role="banner">
<div class="conjtainer">
<!-- Menu button for smallar screens -->
<div class="navbar-header">
<button class="navbar-toggle btn-navbar" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
<span>菜单</span>
</button>
<!-- Site name for smallar screens -->
<a href="?r=index" class="navbar-brand hidden-lg">控制台</a>
</div>
<!-- Navigation starts -->
<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">         
<ul class="nav navbar-nav">  
<!-- Upload to server link. Class "dropdown-big" creates big dropdown -->
<li class="dropdown dropdown-big">
<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-success"><i class="icon-cloud-upload"></i></span> 官方网站</a>
<!-- Dropdown -->
<ul class="dropdown-menu">
<li>
 <!-- Progress bar -->
<p><span class="label label-info"></span>官网：<a href="http://www.isea.pw" target="_blank">http://www.isea.pw</a></p>
<p><span class="label label-info"></span>博客：<a href="http://www.isea.so" target="_blank">http://www.isea.so</a></p>

<hr />             
<!-- Dropdown menu footer -->
<div class="drop-foot">
<a href="#">相关站点</a>
</div>
</li>
</ul>
</li>
<!-- Sync to server link -->
<li class="dropdown dropdown-big">
<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-danger"><i class="icon-refresh"></i></span> 系统信息</a>
<!-- Dropdown -->
<ul class="dropdown-menu">
<li>
<!-- Using "icon-spin" class to rotate icon. -->
<p><span class="label label-info"></span>名称：熊海CMS</p>
<p><span class="label label-info"></span>作者：熊海</p>
<p><span class="label label-info"></span>版本：V1.0</p>
<hr />
<!-- Dropdown menu footer -->
<div class="drop-foot">
<a href="#">软件信息</a>
</div>
</li>
</ul>
</li>
</ul>

<!-- Links -->
<?php 
$user=$_COOKIE['user'];
$query = "SELECT * FROM manage WHERE user='$user'";
$resul = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$user = mysql_fetch_array($resul);
?>
<ul class="nav navbar-nav pull-right">
<li class="dropdown pull-right">            
<a data-toggle="dropdown" class="dropdown-toggle" href="#">
<i class="icon-user"></i> <?php echo $user['name']?> <b class="caret"></b>              
</a>
<!-- Dropdown menu -->
<ul class="dropdown-menu">
<li><a href="?r=manageinfo"><i class="icon-user"></i> 资料</a></li>
<li><a href="?r=outlogin"><i class="icon-off"></i> 退出</a></li>
</ul>
</li>
</ul>
</nav>
</div>
</div>