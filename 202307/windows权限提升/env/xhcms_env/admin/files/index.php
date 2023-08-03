<?php
require '../inc/checklogin.php';
require '../inc/conn.php';
$indexopen='class="open"';
?>

<!DOCTYPE html>

<html lang="en">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta charset="utf-8">

  <!-- Title and other stuffs -->

  <title>控制台 - 熊海内容管理系统</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="author" content="">

  <!-- Stylesheets -->

  <link href="style/bootstrap.css" rel="stylesheet">

  <!-- Font awesome icon -->

  <link rel="stylesheet" href="style/font-awesome.css"> 

  <!-- jQuery UI -->

  <link rel="stylesheet" href="style/jquery-ui.css"> 

  <!-- Calendar -->

  <link rel="stylesheet" href="style/fullcalendar.css">

  <!-- prettyPhoto -->

  <link rel="stylesheet" href="style/prettyPhoto.css">  

  <!-- Star rating -->

  <link rel="stylesheet" href="style/rateit.css">

  <!-- Date picker -->

  <link rel="stylesheet" href="style/bootstrap-datetimepicker.min.css">

  <!-- CLEditor -->

  <link rel="stylesheet" href="style/jquery.cleditor.css"> 

  <!-- Uniform -->

  <link rel="stylesheet" href="style/uniform.default.css"> 

  <!-- Bootstrap toggle -->

  <link rel="stylesheet" href="style/bootstrap-switch.css">

  <!-- Main stylesheet -->

  <link href="style/style.css" rel="stylesheet">

  <!-- Widgets stylesheet -->

  <link href="style/widgets.css" rel="stylesheet">   

  

  <!-- HTML5 Support for IE -->

  <!--[if lt IE 9]>

  <script src="js/html5shim.js"></script>

  <![endif]-->



  <!-- Favicon -->

  <link rel="shortcut icon" href="../images/favicon.ico">

</head>



<body>

<?php require 'template/top.php';?>

<!-- Header starts -->

<?php require 'template/header.php';?>

<!-- Header ends -->

<!-- Main content starts -->

<?php require 'template/sidebar.php';?>

<!-- Sidebar ends -->

<!-- Main bar -->

  	<div class="mainbar">

      

	    <!-- Page heading -->

	    <div class="page-head">

	      <h2 class="pull-left"><i class="icon-home"></i> 首页</h2>



        <!-- Breadcrumb -->

        <div class="bread-crumb pull-right">

          <a href="?r=index"><i class="icon-home"></i> 首页</a> 

          <!-- Divider -->

          <span class="divider">/</span> 

          <a href="#" class="bread-current">控制台</a>

        </div>



        <div class="clearfix"></div>



	    </div>

	    <!-- Page heading ends -->

	    <!-- Matter -->

	    <div class="matter">

        <div class="container">

          <!-- Today status. jQuery Sparkline plugin used. -->



          <div class="row">

            <div class="col-md-12"> 

              <!-- List starts -->

              <ul class="today-datas">

                <!-- List #1 -->

                <li>

                  <!-- Graph -->

                  <div><span id="todayspark1" class="spark"></span></div>

<?php 

$query = "SELECT id FROM content";

$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());

$wzzs = mysql_num_rows($result);

?>

                  <!-- Text -->

                  <div class="datas-text"><?php echo $wzzs?> 文章</div>

                </li>

<?php

$query="select sum(hit) from content";

$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());

$ll=mysql_fetch_row($result);



$query="select sum(hit) from download";

$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());

$softll=mysql_fetch_row($result);

$ll=$ll[0]+$softll[0];

?>

                <li>

                  <div><span id="todayspark2" class="spark"></span></div>

                  <div class="datas-text"><?php echo $ll?> 浏览</div>

                </li>

<?php 

$query = "SELECT id FROM interaction WHERE type=2";

$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());

$lyzs = mysql_num_rows($result);

?>

                <li>

                  <div><span id="todayspark3" class="spark"></span></div>

                  <div class="datas-text"><?php echo $lyzs?> 留言</div>

                </li>

<?php 

$query = "SELECT id FROM interaction WHERE type=1 or type=2";

$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());

$plzs = mysql_num_rows($result);

?>

                <li>

                  <div><span id="todayspark4" class="spark"></span></div>

                  <div class="datas-text"><?php echo $plzs?> 评论</div>

                </li>

<?php 

$query = "SELECT id FROM download";

$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());

$rjzs = mysql_num_rows($result);

?>

                <li>

                  <div><span id="todayspark5" class="spark"></span></div>

                  <div class="datas-text"><?php echo $rjzs?> 软件</div>

                </li> 

                                                                                                              

              </ul> 

            </div>

          </div>



          <!-- Today status ends -->



          <!-- Dashboard Graph starts -->







          <!-- Chats, File upload and Recent Comments -->

          <div class="row">



            <div class="col-md-4">

              <!-- Widget -->

              <div class="widget">

                <!-- Widget title -->

                <div class="widget-head">

                  <div class="pull-left">最新文章</div>

                  <div class="widget-icons pull-right">

                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 

                    <a href="#" class="wclose"><i class="icon-remove"></i></a>

                  </div>  

                  <div class="clearfix"></div>

                </div>



                <div class="widget-content">

                  <!-- Widget content -->

                  <div class="padd">

                    

                    <ul class="chats">

<?php

$query2 = "SELECT * FROM manage";

$resul2 = mysql_query($query2) or die('SQL语句有误：'.mysql_error());

$manage2 = mysql_fetch_array($resul2);

if ($manage2['img']==""){

$touxiang="images/manage.jpg";

} else{

$touxiang=$manage2['img'];		

}

$query=mysql_query("select * FROM content ORDER BY id DESC  LIMIT 6");

while($content = mysql_fetch_array($query)){ 

?>

                      <!-- Chat by us. Use the class "by-me". -->

                      <li class="by-me">

                        <!-- Use the class "pull-left" in avatar -->

                        <div class="avatar pull-left">

                          <img src="<?php echo $touxiang?>"  width="45px"/>

                        </div>



                        <div class="chat-content">

                          <!-- In meta area, first include "name" and then "time" -->

                          <div class="chat-meta"><?php echo $content['author']?> <span class="pull-right"><?php echo date('Y-m-d',strtotime($content['date']))?></span></div>

                          <?php echo $content['title']?>

                          <div class="clearfix"></div>

                        </div>

                      </li> 

                      

<?php }?>

                                                      



                    </ul>



                  </div>

                  <!-- Widget footer -->

                  <div class="widget-foot">

                      

                      <form class="form-inline">

						<div class="form-group">

							<input type="text" class="form-control" placeholder="文章标题...">

						</div>

                        <button type="submit" class="btn btn-primary">搜索</button>

                      </form>





                  </div>

                </div>





              </div> 

            </div>





            <!-- File Upload widget -->

            <div class="col-md-4">



              <div class="widget">

                <!-- Widget title -->

                <div class="widget-head">

                  <div class="pull-left">热门排行</div>

                  <div class="widget-icons pull-right">

                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 

                    <a href="#" class="wclose"><i class="icon-remove"></i></a>

                  </div>  

                  <div class="clearfix"></div>

                </div>

                <div class="widget-content referrer">

                  <!-- Widget content -->

                  

                  <table class="table table-striped table-bordered table-hover">

                    <tr>

                      <th><center>#</center></th>

                      <th>名称</th>

                      <th>点击</th>

                    </tr>

<?php 

$query=mysql_query("select * FROM content  ORDER BY hit DESC  LIMIT 13");

while($content = mysql_fetch_array($query)){ 

?>

                    <tr>

                      <td><img src="img/icons/chrome.png" alt="" />

                      <td><?php echo $content['title']?></td>

                      <td><?php echo $content['hit']?></td>

                    </tr> 

<?php }?>                                                         

                  </table>



                  <div class="widget-foot">

                  </div>

                </div>

              </div>



            </div>





            <div class="col-md-4">

              <!-- Widget -->

              <div class="widget">

                <!-- Widget title -->

                <div class="widget-head">

                  <div class="pull-left">最近评论</div>

                  <div class="widget-icons pull-right">

                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 

                    <a href="#" class="wclose"><i class="icon-remove"></i></a>

                  </div>  

                  <div class="clearfix"></div>

                </div>

                <div class="widget-content">

                  <!-- Widget content -->

                  <div class="padd">



                    <ul class="recent">



<?php

$query=mysql_query("select * FROM interaction ORDER BY id DESC  LIMIT 7");

while($interaction = mysql_fetch_array($query)){ 

?>

                      <li>

                        <div class="recent-content">

                          <div class="recent-meta"><?php echo date('Y-m-d',strtotime($interaction['date']))?> by <?php echo $interaction['name']?></div>

                          <div>

                       <?php echo mb_substr($interaction['content'],0,50,'utf8')?>   

                          </div>

                          <div class="btn-group">

                      <a href="?r=reply&type=<?php echo $interaction['type']?>&id=<?php echo $interaction['id']?>"><button class="btn btn-xs btn-default"><i class="icon-pencil"></i> </button></a>

                          </div>

                     <?php if  ($interaction['rcontent']=="") {?>

                          <button class="btn btn-xs btn-danger pull-right">未回复</button>

                           <?php }else{?>

                           <button class="btn btn-xs btn-danger pull-right">已回复</button>

                           

                           <?php }?>

                          <div class="clearfix"></div>

                        </div>

                      </li>

<?php }?>

                    </ul>



                  </div>

                  

                </div>  



              </div> 



            </div>

          </div>







                  

       



        </div>

		  </div>



		<!-- Matter ends -->



    </div>



   <!-- Mainbar ends -->

   <div class="clearfix"></div>



</div>

<!-- Content ends -->



<!-- Footer starts -->

<?php require 'template/footer.php';?>

<!-- Footer ends -->



<!-- Scroll to top -->

<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span> 



<!-- JS -->

<script src="js/jquery.js"></script> <!-- jQuery -->

<script src="js/bootstrap.js"></script> <!-- Bootstrap -->

<script src="js/jquery-ui-1.9.2.custom.min.js"></script> <!-- jQuery UI -->

<script src="js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->

<script src="js/jquery.rateit.min.js"></script> <!-- RateIt - Star rating -->

<script src="js/jquery.prettyPhoto.js"></script> <!-- prettyPhoto -->



<!-- jQuery Flot -->

<script src="js/excanvas.min.js"></script>

<script src="js/jquery.flot.js"></script>

<script src="js/jquery.flot.resize.js"></script>

<script src="js/jquery.flot.pie.js"></script>

<script src="js/jquery.flot.stack.js"></script>



<!-- jQuery Notification - Noty -->

<script src="js/jquery.noty.js"></script> <!-- jQuery Notify -->

<script src="js/themes/default.js"></script> <!-- jQuery Notify -->

<script src="js/layouts/bottom.js"></script> <!-- jQuery Notify -->

<script src="js/layouts/topRight.js"></script> <!-- jQuery Notify -->

<script src="js/layouts/top.js"></script> <!-- jQuery Notify -->

<!-- jQuery Notification ends -->



<script src="js/sparklines.js"></script> <!-- Sparklines -->

<script src="js/jquery.cleditor.min.js"></script> <!-- CLEditor -->

<script src="js/bootstrap-datetimepicker.min.js"></script> <!-- Date picker -->

<script src="js/jquery.uniform.min.js"></script> <!-- jQuery Uniform -->

<script src="js/bootstrap-switch.min.js"></script> <!-- Bootstrap Toggle -->

<script src="js/filter.js"></script> <!-- Filter for support page -->

<script src="js/custom.js"></script> <!-- Custom codes -->

<script src="js/charts.js"></script> <!-- Charts & Graphs -->



<!-- Script for this page -->

<script type="text/javascript">

$(function () {



    /* Bar Chart starts */



    var d1 = [];

    for (var i = 0; i <= 20; i += 1)

        d1.push([i, parseInt(Math.random() * 30)]);



    var d2 = [];

    for (var i = 0; i <= 20; i += 1)

        d2.push([i, parseInt(Math.random() * 30)]);





    var stack = 0, bars = true, lines = false, steps = false;

    

    function plotWithOptions() {

        $.plot($("#bar-chart"), [ d1, d2 ], {

            series: {

                stack: stack,

                lines: { show: lines, fill: true, steps: steps },

                bars: { show: bars, barWidth: 0.8 }

            },

            grid: {

                borderWidth: 0, hoverable: true, color: "#777"

            },

            colors: ["#ff6c24", "#ff2424"],

            bars: {

                  show: true,

                  lineWidth: 0,

                  fill: true,

                  fillColor: { colors: [ { opacity: 0.9 }, { opacity: 0.8 } ] }

            }

        });

    }



    plotWithOptions();

    

    $(".stackControls input").click(function (e) {

        e.preventDefault();

        stack = $(this).val() == "With stacking" ? true : null;

        plotWithOptions();

    });

    $(".graphControls input").click(function (e) {

        e.preventDefault();

        bars = $(this).val().indexOf("Bars") != -1;

        lines = $(this).val().indexOf("Lines") != -1;

        steps = $(this).val().indexOf("steps") != -1;

        plotWithOptions();

    });



    /* Bar chart ends */



});





/* Curve chart starts */



$(function () {

    var sin = [], cos = [];

    for (var i = 0; i < 14; i += 0.5) {

        sin.push([i, Math.sin(i)]);

        cos.push([i, Math.cos(i)]);

    }



    var plot = $.plot($("#curve-chart"),

           [ { data: sin, label: "sin(x)"}, { data: cos, label: "cos(x)" } ], {

               series: {

                   lines: { show: true, fill: true},

                   points: { show: true }

               },

               grid: { hoverable: true, clickable: true, borderWidth:0 },

               yaxis: { min: -1.2, max: 1.2 },

               colors: ["#1eafed", "#1eafed"]

             });



    function showTooltip(x, y, contents) {

        $('<div id="tooltip">' + contents + '</div>').css( {

            position: 'absolute',

            display: 'none',

            top: y + 5,

            left: x + 5,

            border: '1px solid #000',

            padding: '2px 8px',

            color: '#ccc',

            'background-color': '#000',

            opacity: 0.9

        }).appendTo("body").fadeIn(200);

    }



    var previousPoint = null;

    $("#curve-chart").bind("plothover", function (event, pos, item) {

        $("#x").text(pos.x.toFixed(2));

        $("#y").text(pos.y.toFixed(2));



        if ($("#enableTooltip:checked").length > 0) {

            if (item) {

                if (previousPoint != item.dataIndex) {

                    previousPoint = item.dataIndex;

                    

                    $("#tooltip").remove();

                    var x = item.datapoint[0].toFixed(2),

                        y = item.datapoint[1].toFixed(2);

                    

                    showTooltip(item.pageX, item.pageY, 

                                item.series.label + " of " + x + " = " + y);

                }

            }

            else {

                $("#tooltip").remove();

                previousPoint = null;            

            }

        }

    }); 



    $("#curve-chart").bind("plotclick", function (event, pos, item) {

        if (item) {

            $("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");

            plot.highlight(item.series, item.datapoint);

        }

    });



});



/* Curve chart ends */

</script>



</body>

</html>