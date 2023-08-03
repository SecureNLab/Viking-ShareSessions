  <header>
    <div class="container">
      <div class="row">

        <!-- Logo section -->
        <div class="col-md-4">
          <!-- Logo. -->
          <div class="logo">
            <h1><a href="?r=index"><img src="img/logo.png" title="熊海内容管理系统（SEACMS）"><span class="bold"></span></a></h1>
          </div>
          <!-- Logo ends -->
        </div>

        <!-- Button section -->
        <div class="col-md-4">

          <!-- Buttons -->
          <ul class="nav nav-pills">
<?php
$query="select sum(hit) from content";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$ll=mysql_fetch_row($result);

$query="select sum(hit) from download";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$softll=mysql_fetch_row($result);
$ll=$ll[0]+$softll[0];

$query="select * FROM interaction WHERE type=2 AND rcontent='' ORDER BY id DESC  LIMIT 5";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$lyzs = mysql_num_rows($result);
?>
            <!-- Comment button with number of latest comments count -->
            <li class="dropdown dropdown-big">
              <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="icon-envelope-alt"></i>&nbsp; 留言 <span   class="label label-info"><?php echo $lyzs?></span> 
              </a>

                <ul class="dropdown-menu">
                  <li>
                    <!-- Heading - h5 -->
                    <h5><i class="icon-comments"></i> 未回复留言</h5>
                    <!-- Use hr tag to add border -->
                    <hr />
                  </li>
                  
<?php
while($ly = mysql_fetch_array($result)){ 
?>
<li>
<!-- List item heading h6 -->
 <h6><?php echo $ly['name']?>：<span class="label label-warning pull-right"><?php echo date('m-d',strtotime($ly['date']))?></span></h6>
 <p><a href="?r=reply&type=<?php echo $ly['type']?>&id=<?php echo $ly['id']?>"><?php echo mb_substr($ly['content'],0,10,'utf8')?>..</a></p>
<div class="clearfix"></div>
<hr />
 </li>
                  
<?php }?>
<li>
<div class="drop-foot">
<a href="?r=commentlist&type=message">所有留言</a>
</div>
</li>                   
</ul>
</li>
<?php
$query1="select * FROM interaction WHERE (type=1  AND rcontent='') or (type=3 AND rcontent='')";
$result1 = mysql_query($query1) or die('SQL语句有误：'.mysql_error());
$plzs = mysql_num_rows($result1);
?>
<!-- Message button with number of latest messages count-->
<li class="dropdown dropdown-big">
<a class="dropdown-toggle" href="#" data-toggle="dropdown">
<i class="icon-comments"></i>  评论 <span class="label label-success"><?php echo $plzs?></span> 
</a>
<ul class="dropdown-menu">
<li>
 <!-- Heading - h5 -->
<h5><i class="icon-envelope-alt"></i> 未回复评论</h5>
                    <!-- Use hr tag to add border -->
                    <hr />
                  </li>
<?php
$query="select * FROM interaction WHERE (type=1  AND rcontent='') or (type=3 AND rcontent='')  ORDER BY id DESC  LIMIT 5";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
while($pl = mysql_fetch_array($result)){ 
?>
                  <li>
                    <!-- List item heading h6 -->
<h6><?php echo $pl['name']?>：<span class="label label-warning pull-right"><?php echo date('m-d',strtotime($pl['date']))?></span></h6>
                    <!-- List item para -->
                    <p><a href="?r=reply&type=<?php echo $pl['type']?>&id=<?php echo $pl['id']?>"><?php echo mb_substr($pl['content'],0,10,'utf8')?>..</a></p>
                    <hr />
                  </li>
<?php }?>
                  <li>
                    <div class="drop-foot">
                      <a href="?r=commentlist&type=comment">文章评论</a> | <a href="?r=commentlist&type=download">下载评论</a>
                    </div>
                  </li>                                    
                </ul>
            </li>

          </ul>

        </div>

        <!-- Data section -->

        <div class="col-md-4">
          <div class="header-data">

            <!-- Traffic data -->
            <div class="hdata">
              <div class="mcol-left">
                <!-- Icon with red background -->
                <i class="icon-signal bred"></i> 
              </div>
              <div class="mcol-right">
                <!-- Number of visitors -->
                <p><a href="#"><?php echo $ll?></a> <em>访问</em></p>
              </div>
              <div class="clearfix"></div>
            </div>
<?php 
$query = "select * from interaction where (id IN ( select max(id) from interaction GROUP BY name )) ORDER BY id DESC";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$userzs = mysql_num_rows($result);
?>
            <!-- Members data -->
            <div class="hdata">
              <div class="mcol-left">
                <!-- Icon with blue background -->
                <i class="icon-user bblue"></i> 
              </div>
              <div class="mcol-right">
                <!-- Number of visitors -->
                <p><a href="#"><?php echo $userzs?></a> <em>用户</em></p>
              </div>
              <div class="clearfix"></div>
            </div>

<?php 
$query = "SELECT id FROM interaction";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$hdzs = mysql_num_rows($result);
?>
            <!-- revenue data -->
            <div class="hdata">
              <div class="mcol-left">
                <!-- Icon with green background -->
                <i class="icon-money bgreen"></i> 
              </div>
              <div class="mcol-right">
                <!-- Number of visitors -->
                <p><a href="#"><?php echo $hdzs?></a><em>互动</em></p>
              </div>
              <div class="clearfix"></div>
            </div>                        

          </div>
        </div>

      </div>
    </div>
  </header>