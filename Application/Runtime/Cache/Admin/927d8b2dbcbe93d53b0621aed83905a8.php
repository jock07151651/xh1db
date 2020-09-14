<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>跳转提示</title>
<link href="/Public/admin/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
<link href="/Public/admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
<link href="/Public/admin/css/animate.min.css" rel="stylesheet">
<link href="/Public/admin/css/style.min.css?v=4.0.0" rel="stylesheet">
<link href="/Public/admin/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeIn">
    <div class="sweet-alert" style="display:block;margin-top:-125px;">
        <div class="sa-icon sa-error" title="错误" style="display:<?php if(isset($message)) {echo("none");}else{echo("block");}?>;">
            <span class="sa-x-mark animateXMark">
                <span class="sa-line sa-left"></span>
                <span class="sa-line sa-right"></span>
            </span>
        </div>
        <div class="sa-icon sa-warning" title="提示" style="display: none;">
            <span class="sa-body"></span>
            <span class="sa-dot"></span>
        </div>

        <div class="sa-icon sa-success animate" title="成功" style="display:<?php if(isset($message)) {echo("block");}else{echo("none");}?>">
            <span class="sa-line sa-tip animateSuccessTip"></span>
            <span class="sa-line sa-long animateSuccessLong"></span>
            <div class="sa-placeholder"></div>
            <div class="sa-fix"></div>
        </div>
        <h2><?php if(isset($message)) {echo($message);}else{echo($error);}?></h2>
        <p>页面将会自动跳转，等待时间：<b id="wait"><?php echo($waitSecond); ?></b><a id="href" style="display:none" href="<?php echo($jumpUrl); ?>">点击跳转</a></p>
    </div>
</div>

<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
 var time = --wait.innerHTML;
 if(time <= 0) {
     location.href = href;
     clearInterval(interval);
 };
}, 1000);
})();
</script>
</body>
</html>