<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<title><?php echo ($setting["site_name"]); ?>-管理中心</title>
<meta name="keywords" content="">
<meta name="description" content="">
<script type="text/javascript" src="/Public/js/sea.js"></script>
<script type="text/javascript" src="/Public/admin/js/sea_config.js"></script>
<link href="/Public/admin/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
<link href="/Public/admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
<link href="/Public/admin/css/animate.min.css" rel="stylesheet">
<link href="/Public/admin/css/style.min.css?v=4.0.0" rel="stylesheet">
<link href="/Public/admin/css/plugins/minicolors/jquery.minicolors.css" rel="stylesheet">
<link href="/Public/js/plugins/layer/skin/layer.css" rel="stylesheet" type="text/css" />
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<!--[if lte IE 6]>
<style type="text/css">#ie6shengji{position:absolute;top:10px;left:0;font-size:14px;color:#ff0000;width:97%;padding: 2px 15px 2px 23px;text-align:left;}</style>
<div id="ie6shengji">绿茶笑话系统提醒：亲爱的朋友，您正在使用浏览器版本严重过低(IE6，或使用IE内核的国产浏览器)，请升级新版IE8，Chrome，火狐等浏览器。</div>
<script type="text/javascript">
function position_fixed(el, eltop, elleft){
// check if this is IE6
if(!window.XMLHttpRequest)
window.onscroll = function(){
el.style.top = (document.documentElement.scrollTop + eltop)+"px";
el.style.left = (document.documentElement.scrollLeft + elleft)+"px";
}
else el.style.position = "fixed";
}
position_fixed(document.getElementById("ie6-warning"),0, 0);
</script>
<![endif]-->
<div id="wrapper">
  <div class="top-navbar">
    <div class="top-navbar-inner">
      <div class="logo-brand">绿茶笑话系统</div>
      <div class="top-nav-content">
        <div class="btn-collapse-sidebar-left">
          <nav class="navbar-switch">
              <a class="navbar-minimalize" href="#"><i class="fa fa-bars"></i> </a>
            </nav>
        </div>
        <div class="btn-collapse-nav" data-toggle="collapse" data-target="#main-fixed-nav"> <i class="fa fa-plus icon-plus"></i> </div>
        <ul class="nav-user navbar-right">
          <li> <a href="javascript:;" data-toggle="dropdown"> <img src="/Public/admin/image/profile_small.jpg" class="header-avatar img-circle" alt="user" title="user"> <span class="hidden-xs ml10"><?php echo ($admin_info["username"]); ?></span> <i class="ti-angle-down ti-caret hidden-xs"></i> </a>
      <ul class="dropdown-menu animated fadeInRight">
        <!-- <li> <a href="javascript:;">设置</a> </li>
        <li> <a href="javascript:;">升级</a> </li>
        <li> <a href="javascript:;">
          <div class="badge bg-danger pull-right">3</div>
          <span>通知</span> </a> </li>
        <li> <a href="javascript:;">帮助</a> </li> -->
        <li> <a href="<?php echo U('public/logout');?>">退出</a> </li>
      </ul>
    </li>
        </ul>
        <div class="collapse navbar-collapse" id="main-fixed-nav">
          <ul class="nav navbar-nav navbar-left" id="topmenu">

          </ul>
        </div>
      </div>
    </div>
  </div>
  <!--左侧导航开始-->
  <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i> </div>
    <div class="sidebar-collapse">
      <ul class="nav" id="side-menu">

      </ul>
    </div>
  </nav>

  <!--左侧导航结束-->
  <!--右侧部分开始-->
  <div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="row content-tabs">
      <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i> </button>
      <nav class="page-tabs J_menuTabs">
        <div class="page-tabs-content"> <a href="javascript:;" class="active J_menuTab" data-id="<?php echo U('index/main');?>">系统桌面</a> </div>
      </nav>
      <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i> </button>
      <div class="btn-group roll-nav roll-right">
        <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span> </button>
        <ul role="menu" class="dropdown-menu dropdown-menu-right">
          <li class="J_tabShowActive"><a>定位当前选项卡</a> </li>
          <li class="divider"></li>
          <li class="J_tabCloseAll"><a>关闭全部选项卡</a> </li>
          <li class="J_tabCloseOther"><a>关闭其他选项卡</a> </li>
        </ul>
      </div>
      <a href="javascript:void(0)" data-action="App.cache_clear" data-url="<?php echo U('cache/clear');?>" class="roll-nav roll-right Clearcache">清除缓存 </a>
  <!--     <a href="<?php echo U('front/logout');?>" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>  -->
    </div>
    <div class="row J_mainContent J_iframe" id="content-main">

    </div>
    <div class="footer">
      <div class="pull-right">&copy; 2019 <a href="http://www.lvchakeji.com/" target="_blank">LVCHAKEJI</a> </div>
    </div>
  </div>
  <!--右侧部分结束-->
</div>

<!-- 顶部一级菜单 -->
<script id="tpl_menu" type="text/html">
<%for(var i in menu){ if(menu[i]['is_show']) { %>
<li class="dropdown"><a href="javascript:void(0)" class="show_submenu" data-id="<%=menu[i].id%>" title="<%=menu[i].name%>"><%=menu[i].name%></a></li>
<%} } %>
</script>
<!-- 左侧子级菜单 -->
<script id="tpl_submenu" type="text/html">
<% for (var i = 0;i < menu.length; i ++) { if(menu[i]['is_show']) { %>
  <%for(var j=0;j<menu[i].sub.length;j++){ if(menu[i].sub[j].is_show) { %>
    <li data-pid="<%=menu[i].id%>" style="display:none"> <a class="J_menuItem" href="/index.php?m=Admin&c=<%=menu[i].sub[j].c%>&a=<%=menu[i].sub[j].a%>"><i class="fa <%=menu[i].sub[j].icon%>"></i> <span class="nav-label"><%=menu[i].sub[j].name%></span><%if (menu[i].sub[j].sub){%><span class="fa arrow"></span><%}%></a>
      <%if (menu[i].sub[j].sub){%>
        <ul class="nav nav-second-level collapse">
          <%for(var k=0;k<menu[i].sub[j].sub.length;k++){ if(menu[i].sub[j].sub[k].is_show) { %>
            <li data-pid="<%=menu[i].id%>"><a class="J_menuItem" data-index="<%=menu[i].id%>" href="/index.php?m=Admin&c=<%=menu[i].sub[j].sub[k].c%>&a=<%=menu[i].sub[j].sub[k].a%>"> <%=menu[i].sub[j].sub[k].name%></a></li>
          <%} } %>
        </ul>
      <%}%>
    </li>
  <%} } %>
<%} } %>
</script>
<script>
var load_cate = false;
  seajs.use(['app','manage','menu'], function(app,manage,menu){
    manage.main();
    app.load_page('<?php echo U("index/main");?>');
    //权限判断
    var node_ids = '<?php echo ($node_ids); ?>';
    node_ids = node_ids.split(',');
    for (var i = 0; i < menu.length; i++) {
        var c = check(node_ids,menu[i].id);
        menu[i]['is_show'] = false;
        if(c)  menu[i]['is_show'] = true;

        if(menu[i]['sub']) {
            var sub = menu[i]['sub'];
            for (var j = 0; j < sub.length; j++) {
                var c = check(node_ids,sub[j].id);
                sub[j]['is_show'] = false;
                if(c)  sub[j]['is_show'] = true;

                if(sub[j]['sub']) {
                    var ssub = sub[j]['sub'];
                    for (var k = 0; k < ssub.length; k++) {
                        var c = check(node_ids,ssub[k].id);
                        ssub[k]['is_show'] = false;
                        if(c)  ssub[k]['is_show'] = true;
                    }
                }
            }
        }
    }
    var html = template('tpl_menu', {menu:menu});
    document.getElementById('topmenu').innerHTML = html;
    var html = template('tpl_submenu', {menu:menu});
    document.getElementById('side-menu').innerHTML = html;
    function submenu(pid){
      $('#side-menu li').each(function(){
        var id = $(this).data('pid');
        if(id == pid){
          $(this).css('display','block');
        }
        if(id != pid){
          $(this).css('display','none');
        }
      })
      if(load_cate == false && pid == 300) {
        load_cate = true;
        $.post('/index.php?m=Admin&c=cate&a=getcate',{},function(data) {
          var menu = manage.cate_menu(data.msg,pid);
          $('#side-menu').append(menu);
          $("#side-menu").metisMenu();
        });
      }

    }
    submenu(100);
    $('.show_submenu').click(function(){
      var id = $(this).data('id');
      $('.show_submenu').removeClass('current');
      $(this).addClass('current');
      submenu(id);
    })

    $('#main-fixed-nav a').click(function(){
       $('#main-fixed-nav').removeClass('in');
       $('body').removeClass('mini-navbar');
       $('.top-navbar').addClass('toggle');
    })
    $('.btn-collapse-nav').click(function(){
      $('.top-navbar').removeClass('toggle');
       $('body').addClass('mini-navbar');
    })

    //菜单的点击处理
    $('body').delegate('li a[class="J_menuItem"]','click',function(event){
        event.preventDefault();
        var bw = $(document).width();
        if(bw < 768){
          $('.top-navbar').removeClass('toggle');
          $('body').addClass('mini-navbar');
        }

        var url = $(this).attr('href');
         app.load_page(url);
    });
    //右侧内容展示区
    $('#content-main').on('click','a[link-url]',function() {
        var url = $(this).attr('link-url');
        app.load_page(url);
    });
     //右侧内容展示区
    $('#content-main').on('click','a[exe-url]',function() {
        var url = $(this).attr('exe-url');
        app.exe_page(url);
    });
    //导航点击处理
    $('.J_menuTabs').on('click','a[class="J_menuTab"]',function() {
        var url = $(this).attr('data-id');
        app.load_page(url);
    });
  });

function check(arr,val) {
    for(var i=0 ; i < arr.length; i++) {
        if(arr[i] == val) {
            return true;
        }
    }
    return false;
}
</script>
</body>
</html>