<link rel="shortcut icon" href="images/favicon.ico" />
<link rel="stylesheet" href="css/seacms-style.css" />
<script src="css/navclass.js"></script>
</head>
<body>
<div id="body">
<div id="head">
<div id="logo"><a href="/"><img src="images/logo.png"  title="<?php echo $info['name']?>"/></a></div>
<div id="logotxt"><?php echo $info['stitle']?></div>
<div id="logoright">
<div class="telrx">
服务热线：<?php echo $info['tel']?>
</div>
</div>
</div>
<div id="qcfd"></div>
</div>
<div class="nav">
<ul>
<a href="/"><li>首页</li></a>
<?php
//循环查询语句
$query=mysql_query("select * FROM nav WHERE xs=1 ORDER BY px asc");
while($nav = mysql_fetch_array($query)){ 
if ($nav['type']<>2){
if ($nav['type']==5){
$navlink="?r=".$nav['link']."&did=".$nav['id'];
}else{
$navlink="?r=".$nav['link'];		
}
?>
<a href="<?php echo $navlink?>"><li><?php echo $nav['name']?></li></a>
<?php }else{ ?>
<li id="fw"><a href="?r=<?php echo $nav['link']?>"><?php echo $nav['name']?> <sjx></sjx></a>
<div id="liclass">
<?php
//循环查询语句
$query2=mysql_query("select * FROM navclass  WHERE xs=1 ORDER BY px asc");
while($navclass = mysql_fetch_array($query2)){ 
?>
<span><a href="?r=<?php echo $nav['link']?>&class=<?php echo $navclass['id']?>"><?php echo $navclass['name']?></a></span>
<?php }?>
</div>
</li> 
<?php } }?>
<li id="right_text"><?php echo date('Y年n月j日')?></li>
</ul>
</div>