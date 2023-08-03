<div class="content">
  	<!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-dropdown"><a href="#">导航菜单</a></div>
        <!--- Sidebar navigation -->
        <ul id="nav">
          <!-- Main menu with font awesome icon -->
          <li><a href="?r=index" <?php echo $indexopen?> ><i class="icon-home"></i> 首页</a></li>
          <li class="has_sub"><a href="#" <?php echo $newopen?>><i class="icon-pencil"></i> 发布内容  <span class="pull-right"><i class="icon-chevron-right"></i></span></a>
            <ul>
              <li><a href="?r=newwz" ><i class="icon-file-alt"></i> 发布文章</a></li>
              <li><a href="?r=newsoft"><i class="icon-file-alt"></i> 发布下载</a></li>
            </ul>
          </li>  
          <li class="has_sub"><a href="#" <?php echo $wzlistopen?>><i class="icon-tasks"></i> 内容管理 <span class="pull-right"><i class="icon-chevron-right"></i></span></a>
            <ul>
              <li> <a href="?r=wzlist"><i class="icon-file-alt"></i> 文章列表</a></li>
              <li><a href="?r=softlist"><i class="icon-file-alt"></i> 下载列表</a></li>
            </ul>
          </li> 
          <li class="has_sub"><a href="#" <?php echo $columnlistopen?>><i class="icon-list-alt"></i> 栏目管理 <span class="pull-right"><i class="icon-chevron-right"></i></span></a>
            <ul>
              <li><a href="?r=newcolumn&type=1"><i class="icon-file-alt"></i> 新建单页</a></li>
              <li><a href="?r=newcolumn&type=2"><i class="icon-file-alt"></i> 新建分类</a></li>
              <li><a href="?r=columnlist"><i class="icon-file-alt"></i> 栏目列表</a></li>
            </ul>
          </li> 
          <li class="has_sub"><a href="#" <?php echo $linklistopen?>><i class="icon-magic"></i> 友情链接  <span class="pull-right"><i class="icon-chevron-right"></i></span></a>
            <ul>
            <li><a href="?r=newlink"><i class="icon-file-alt"></i> 添加链接</a></li>
            <li><a href="?r=linklist"><i class="icon-file-alt"></i> 链接列表</a></li>
            </ul>
          </li> 
       <li class="has_sub"><a href="#" <?php echo $hdopen?>><i class="icon-comments"></i> 互动  <span class="pull-right"><i class="icon-chevron-right"></i></span></a>
            <ul>
              <li><a href="?r=commentlist&type=comment"><i class="icon-file-alt"></i> 评论列表</a></li>
              <li><a href="?r=commentlist&type=message"><i class="icon-file-alt"></i> 留言列表</a></li>
              <li><a href="?r=commentlist&type=download"><i class="icon-file-alt"></i> 下载评论</a></li>
            </ul>
          </li> 
       <li class="has_sub"><a href="#" <?php echo $setopen?>><i class="icon-cogs"></i> 设置  <span class="pull-right"><i class="icon-chevron-right"></i></span></a>
            <ul>
              <li><a href="?r=siteset"><i class="icon-file-alt"></i> 基本设置</a></li>
              <li><a href="?r=seniorset"><i class="icon-file-alt"></i> 高级设置</a></li>
              <li><a href="?r=imageset"><i class="icon-file-alt"></i> 图片设置</a></li>
              <li><a href="?r=adset"><i class="icon-file-alt"></i> 广告设置</a></li>
            </ul>
          </li>                          
          <!--<li><a href="?r=datamanage"><i class="icon-bar-chart"></i>数据管理</a></li>--> 
        </ul>
    </div>