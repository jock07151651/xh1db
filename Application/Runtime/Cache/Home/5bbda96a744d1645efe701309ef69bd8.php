<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title><?php echo ($title); ?> - <?php echo ($setting["site_name"]); ?></title>
<script type="text/javascript">
var url = "<?php echo ($setting['site_murl']); ?>";
function GetUrlRelativePath(){var url=document.location.toString(),arrUrl=url.split("//"),start = arrUrl[1].indexOf("/"),relUrl = arrUrl[1].substring(start);if(relUrl.indexOf("?") != -1){relUrl = relUrl.split("?")[0]}return relUrl;}
if((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iPad)/i))){location.replace(url+GetUrlRelativePath());};
</script>
<link rel="icon" href="/Public/index/xxhh/images/favicon.ico" type="image/x-icon" >
<meta name="keywords" content="<?php if($keywords != NULL): echo ($keywords); else: echo ($title); endif; ?>" />
<meta name="description" content="<?php if($description != NULL): echo ($description); else: echo ($title); endif; ?>" />
<?php echo (htmlspecialchars_decode($setting['qq_code'])); ?>
<?php echo (htmlspecialchars_decode($setting['sina_code'])); ?>
<link rel="alternate" type="application/rss+xml" title="<?php echo ($setting["site_name"]); ?>" href="<?php echo ($setting['site_url']); ?>/rss"/>
<link rel="stylesheet" type="text/css" href="/Public/index/xxhh/css/main.css">
<link rel="stylesheet" type="text/css" href="/Public/js/plugins/slide/css/slide.min.css">
<script type="text/javascript" src="/Public/js/sea.js"></script>
<script type="text/javascript" src="/Public/index/xxhh/js/sea_config.js"></script>
</head>
<body>


<!-- 顶部-开始 -->
<div class="header">
	<div class="header-nav clearfix">
		<div class="logo"><a href="/"><img src="<?php echo ($setting['site_logo']); ?>"></a></div>
		<ul class="clearfix menu">
			<li><a href="/">最新笑话</a></li>
			<li><a href="/hotjoke">热门笑话</a></li>
			<li><a href="/tags">笑点</a></li>
			<li><a href="/godreply">神回复</a></li>
			<li><a href="/shop">积分商城</a></li>
			<li><a href="/user/followinfo">好友动态</a></li>
		</ul>
		<div class="header-user clearfix">
		<?php if($user == NULL): ?><a href="/account/login">登录</a>　
			<a href="/account/register">注册</a>
			<script type="text/javascript">var test = 0;</script>
			<?php else: ?>
			<!--登录状态-->
			<div class="username clearfix">
				<span><a href="/user"><?php echo ($user["username"]); ?></a>，欢迎回来！</span>
				<ul class="clearfix username-nav">
					<li><a href="/user">我的消息</a></li>
					<li><a href="/user/joke">我的投稿</a></li>
					<li><a href="/user/review">我的评论</a></li>
					<li><a href="/user/followlist">我的关注</a></li>
					<li><a href="/user/fanslist">我的粉丝</a></li>
					<li><a href="/user/msg">我的私信</a></li>
					<li><a href="/user/followinfo">好友动态</a></li>
					<li><a href="/user/gift">我的礼品</a></li>
					<li><a href="/user/info">个人资料</a></li>
					<li><a href="/account/logout">退出</a></li>
				</ul>
				<script type="text/javascript">var test = 1;</script>
			</div><?php endif; ?>
		</div>
	</div>
</div>
<!-- 顶部-结束 -->


<script type="text/javascript" src="http://7xl3wn.com2.z0.glb.qiniucdn.com/socket.io.min.js"></script>
<script type="text/javascript" src="http://7xjfim.com2.z0.glb.qiniucdn.com/Iva.js"></script>
<!-- 主体内容-开始 -->

<div class="main clearfix" style="position:relative;">
  <div class="main-left fl xiaoxie_info" id="j-main-list">

    <!-- 详细-开始 -->
    <dl class="main-list">
      <dt> <a href="/user/<?php echo ($user_joke["user_info"]["id"]); ?>" target="_blank"> <img src="<?php echo ($user_joke["user_info"]["avatar"]); ?>" alt="<?php echo ($user_joke["user_info"]["username"]); ?>"> </a>
        <p class="user">
        	<a href="/user/<?php echo ($user_joke["user_info"]["id"]); ?>" title="<?php echo ($user_joke["user_info"]["username"]); ?>"><?php echo ($user_joke["user_info"]["username"]); ?></a>&nbsp;

        	<span class="fr">
        	<?php if($user != NULL): if($user['id'] != $user_joke['user_info']['id']): ?><a href="javascript:void(0);" title="私信" data-username="<?php echo ($user_joke["user_info"]["username"]); ?>" data-userid="<?php echo ($user_joke["user_info"]["id"]); ?>" class="user-dm">私信</a>
          <?php
 if(check_follow($user['id'],$user_joke['user_info']['id']) == 0){ ?>
        <a href="javascript:void(0);" data-ajax="follow" data-userid="<?php echo ($user_joke["user_info"]["id"]); ?>" class="user-follow"><i class="icon icon10 icon-add-h"></i>关注</a>
        <?php
 }else{ ?>
        <a href="javascript:void(0);" data-ajax="follow" data-userid="<?php echo ($user_joke["user_info"]["id"]); ?>" class="user-follow user-cancelfollow"><i class="icon icon10 icon-cut"></i>已关注</a>
        <?php } endif; endif; ?>
        &nbsp;
        </span>
        </p>
        <span class="title"><?php echo ($user_joke["title"]); ?></span> </dt>
      <dd class="content<?php if($user_joke['type'] == 3 || $user_joke['type'] == 2){echo ' content-pic'; } ?>">
        <?php
 if($user_joke['type'] == 3) { $content = htmlspecialchars_decode(stripcslashes($user_joke['content'])); $content = str_replace('alt=""','alt="'.$user_joke['title'].'"',$content); $img = $content; preg_match_all('/src="(.*?)"/i',$img,$array); if(count($array) > 1) { foreach($array[1] as $k => $v) { $src = $v; $img = str_replace($v,$src,$img); } } echo $img; }else if($user_joke['type'] == 4) { echo '<div id="video" style="width:600px;height:340px; margin-left:auto; margin-right:auto"></div>'; }else if($user_joke['type'] == 2){ $content = htmlspecialchars_decode(stripcslashes($user_joke['content'])); $content = str_replace('alt=""','alt="'.$user_joke['title'].'"',$content); $pattern="/<img\s[^<>]*?src=[\'\"]([^\'\"<>]+?)[\'\"][^<>]*?>/i"; preg_match_all($pattern,$content,$match); $piccount = count($match[0]); if($piccount > 1){ echo '<div class="article-content">' . "\r\n"; echo '  <div class="multiple-article-wrapper">' . "\r\n"; echo '    <div class="multiple-article-zone clearfix">' . "\r\n"; echo '      <div class="multiple-article-arrow prev"> <a href="javascript:;" class="deactive"> <i class="icon-left-open-big"></i> </a> </div>' . "\r\n"; echo '      <div class="multiple-pics-wrapper">' . "\r\n"; echo '        <div class="multiple-pics-zone">' . "\r\n"; echo '          <ul class="multiple-pics-list">' . "\r\n"; for($i=0;$i<$piccount;$i++){ $img = $match[0][$i]; preg_match_all('/src="(.*?)"/i',$img,$array); if(count($array) > 1) { foreach($array[1] as $k => $v) { $src = $v; $img = str_replace($v,$src,$img); } } if($i == 0){ echo '<li class="active">'.$img.'</li>' . "\r\n"; }else{ echo '<li>'.$img.'</li>' . "\r\n"; } } echo '</ul>' . "\r\n"; echo '        </div>' . "\r\n"; echo '      </div>' . "\r\n"; echo '      <div class="multiple-article-arrow next"> <a href="javascript:;"> <i class="icon-right-open-big"></i> </a> </div>' . "\r\n"; echo '    </div>' . "\r\n"; echo '    <div class="multiple-thumbnail-zone clearfix">' . "\r\n"; echo '      <div class="multiple-thumbnail-arrow thumbprev"> <a href="javascript:;" class="deactive"> <i class="icon-left-open-big"></i> </a> </div>' . "\r\n"; echo '      <div class="multiple-thumbnail-area">' . "\r\n"; echo '        <ul class="multiple-thumbnail-list">' . "\r\n"; echo '</ul>' . "\r\n"; echo '      </div>' . "\r\n"; echo '      <div class="multiple-thumbnail-arrow thumbnext"> <a href="javascript:;"> <i class="icon-right-open-big"></i> </a> </div>' . "\r\n"; echo '    </div>' . "\r\n"; echo '  </div>' . "\r\n"; echo '</div>' . "\r\n"; }else{ $content = htmlspecialchars_decode(stripcslashes($user_joke['content'])); $content = str_replace('alt=""','alt="'.$user_joke['title'].'"',$content); $img = $content; preg_match_all('/src="(.*?)"/i',$img,$array); if(count($array) > 1) { foreach($array[1] as $k => $v) { $src = $v; $img = str_replace($v,$src,$img); } } echo $img; } }else{ echo htmlspecialchars_decode($user_joke['content']); }?>
      </dd>
      <dd class="direction clearfix">
        <?php if($rel_joke['pre_joke_id'] > 0): ?><a href="/xiaohua/<?php echo ($rel_joke['pre_joke_id']); ?>.html" class="fl direction-before" title="上一条"></a><?php endif; ?>
        <?php if($rel_joke['next_joke_id'] > 0): ?><a href="/xiaohua/<?php echo ($rel_joke['next_joke_id']); ?>.html" class="fr direction-after" title="下一条"></a><?php endif; ?>
      </dd>
      <dd class="x_tags">
          笑点：<?php if(is_array($joke_tags)): $i = 0; $__LIST__ = $joke_tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><a href="/tags/<?php echo ($tag["id"]); ?>_1.html" target="_blank"><?php echo ($tag["name"]); ?></a>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
      </dd>
      <dd class="operation clearfix">
        <div class="operation-btn"> <a href="javascript:void(0);" data-id="<?php echo ($user_joke["id"]); ?>" class="ding <?php if(($user_joke["record"] != NULL) AND ($user_joke['record']['type'] == 'good')): ?>ding-hover<?php endif; ?>
          " title="顶">
          <div class="dingcai"> <span></span> <i><?php echo ($user_joke["good_num"]); ?></i> </div>
          </a>
          <div class="operation-line"></div>
        </div>
        <div class="operation-btn"> <a href="javascript:void(0);" data-id="<?php echo ($user_joke["id"]); ?>" class="cai <?php if(($user_joke["record"] != NULL) AND ($user_joke['record']['type'] == 'bad')): ?>cai-hover<?php endif; ?>
          " title="踩">
          <div class="dingcai"> <span></span> <i><?php echo ($user_joke["bad_num"]); ?></i> </div>
          </a>
          <div class="operation-line"></div>
        </div>
        <div class="operation-btn"> <a href="javascript:void(0);" data-id="<?php echo ($user_joke["id"]); ?>" class="detail-comment comment" title="评论">
          <div class="dingcai"><span></span><i><?php echo (review($user_joke["id"])); ?></i></div>
          </a>
          <div class="operation-line"></div>
        </div>
        <div class="share-box">
							<span class="action-btn sharebtn" data-id="<?php echo ($user_joke["id"]); ?>"><img src="/Public/images/fen.png" h_src="/Public/images/fen-h.png" alt="分享" style="height: 18px;">
								<div style="display:none" id="sharedata-<?php echo ($user_joke["id"]); ?>"><?php echo ($user_joke["title"]); ?>（来自:<?php echo ($setting["site_name"]); ?>）|#|<?php echo ($setting["site_domain"]); ?>/xiaohua/<?php echo ($user_joke["id"]); ?>.html|#|<?php echo ($user_joke['image']); ?>|#|<?php echo ($setting["site_domain"]); ?>/xiaohua/<?php echo ($user_joke["id"]); ?>.html</div>
								<span class="bdsharebuttonbox bdsharebtn" style="display:none">
									<a href="javascript:void(0);" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
									<a href="javascript:void(0);" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
									<a href="javascript:void(0);" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
									<a href="javascript:void(0);" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
								</span>
							</span>
						</div>
        <div class="f-r">
        <?php if(($user_joke["record"] == NULL) OR ($user_joke['record']['award'] == 0)): ?><a class="reward" href="javascript:void(0)" data-award="<?php echo ($user_joke["award_num"]); ?>" data-id="<?php echo ($user_joke["id"]); ?>">打赏</a><?php endif; ?>
        <?php if(($user_joke["record"] != NULL) AND ($user_joke['record']['award'] > 0)): ?><a class="rewarded" href="javascript:void(0)">已打赏</a><?php endif; ?>
        <?php if(($user_joke["is_package"] == 1) AND ($user_joke["package_user_id"] == 0)): ?><a class="buy" href="javascript:void(0)" data-id="<?php echo ($user_joke["id"]); ?>" data-fee="<?php echo ($user_joke["package_fee"]); ?>">包养</a><?php endif; ?>
        <?php if(($user_joke["is_package"] == 1) AND ($user_joke["package_user_id"] > 0)): ?><div class="kepted"> <a href="/user/<?php echo ($user_joke['record']['package_info']['id']); ?>"><?php echo ($user_joke['record']['package_info']['username']); ?></a> <span>包养了Ta</span> </div><?php endif; ?>
        </div>
      </dd>
    </dl>

    <!-- 详细-结束 -->
	<?php echo ($adv['Joke_dibu']); ?> 

    <div class="object-comment comment" id="object-comment" >
      <div class="title" id="comment-num-data" total="0" >笑友评论(<span><?php echo (review($user_joke["id"])); ?></span>条评论)</div>
      <div class="comment-input">
        <form id="comment">
          <textarea name="content" id="comment-content" class="comment-input-text" title="吐槽一下吧，您的神回复将名垂青史" style="color: rgb(201, 201, 201);"></textarea>
          <input type="hidden" name="id" id="joke_id" value="<?php echo ($user_joke["id"]); ?>" />
          <input type="hidden" name="at_user_id" class="at_user_id" />
          <p id="text-length" style="display:none;">0/140字</p>
          <div>
            <p><span>发评论，奖积分，积分可以换礼品哦!</span><span class="message"></span></p>
            <input type="button" id="comment-submit" value="评论" />
          </div>
        </form>
      </div>
      <?php if(review == NULL): ?><ul class="comment-list" id="comment-list">
          <li class="nocomment">还没有人评论过，赶快抢沙发吧！</li>
        </ul>
        <?php else: ?>
        <input type="hidden" id="count" name="count" value="<?php echo ($count); ?>" >
        <div id="comment-box">
          <ul class="comment-list" id="comment-list">
            <?php if(is_array($review)): $k = 0; $__LIST__ = $review;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k;?><li>
                <div class="comment-content"> <a class="user_id" data-id="<?php echo ($val["user_info"]["id"]); ?>" href="/user/<?php echo ($val["user_info"]["id"]); ?>"><img src="<?php echo ($val["user_info"]["avatar"]); ?>" alt="<?php echo ($val["user_info"]["username"]); ?>" /><i></i></a>
                  <p class="comment-username"><a href="/user/<?php echo ($val["user_info"]["id"]); ?>"><?php echo ($val["user_info"]["username"]); ?></a></p>
                  <p class="p-content"><?php echo ($val["content"]); ?></p>
                </div>
                <div class="comment-ding">
                  <?php $num = ($count - ((1 - 1) * 5))-($k-1); ?>
                  <span><?php echo ($num); ?> 楼</span> <a href="javascript:void(0);" class="comment-ding-icon" rel="nofollow" data-id="<?php echo ($val["id"]); ?>"><?php echo ($val["good_num"]); ?></a> <a class="comment-reply" href="javascript:void(0);" rel="nofollow">回复</a> </div>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
        <div class="page"></div><?php endif; ?>
      <div class="joke-ba joke-ba-bottom clearfix">
        <?php if($rel_joke['pre_joke_id'] > 0): ?><a href="/xiaohua/<?php echo ($rel_joke['pre_joke_id']); ?>.html" class="joke-before" title="上一条"></a><?php endif; ?>
        <?php if($rel_joke['next_joke_id'] > 0): ?><a href="/xiaohua/<?php echo ($rel_joke['next_joke_id']); ?>.html" class="joke-after" title="下一条"></a><?php endif; ?>
      </div>
    </div>
    <div id="reward" class="joke-buy-box" style="display: none; top: 0; left: 0;"> </div>
  </div>
  <div class="main-right fr">
  	<script type="text/javascript">
	function checkSearch() {
		if($('#key').val() == '') {
			return false;
		}
		return true;
	}
</script>
<?php echo ($adv['PC_Index']); ?>
<dl class="tags-list">
	<dt>
		<a href="/tags" target="_blank"><h2>笑点</h2></a>
		<a href="/tags" class="more" target="_blank">更多</a>
	</dt>
	<dd>
		<?php if(is_array($tags)): $i = 0; $__LIST__ = array_slice($tags,0,20,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a href="/tags/<?php echo ($val["id"]); ?>_1.html" target="_blank"><?php echo ($val["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
	</dd>
	<dd>
		<div class="search">
			<input type="text" id="key" class="search-text" placeholder="你想找点啥 ?" title="你想找点啥 ?" name="key" style="color: rgb(204, 204, 204);">
			<input type="hidden" name="p" value="1" />
			<input type="buttom" value="" class="search-submit">
		</div>
	</dd>
</dl>
    <dl class="img-list">
	<dt>
		<a href="javascript:;" target="_blank"><h2>搞笑图片</h2></a>
	</dt>
	<dd class="clearfix">
		<?php if(is_array($pic)): $i = 0; $__LIST__ = array_slice($pic,0,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a href="/xiaohua/<?php echo ($val["id"]); ?>.html" target="_blank">
			<div><img alt="" src="<?php echo ($val["image"]); ?>"></div>
			<span><?php echo ($val["title"]); ?></span>
		</a><?php endforeach; endif; else: echo "" ;endif; ?>
	</dd>
</dl>
<?php echo ($adv['Pc_Indexys']); ?>
</br>
    <dl class="text-list">
	<dt><a href="javascript:;" target="_blank"><h2>推荐段子</h2></a></dt>
	<div class="textlist clearfix">
        <ul>
            <?php if(is_array($text)): $i = 0; $__LIST__ = $text;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><a target="_blank" class="title" href="/xiaohua/<?php echo ($val["id"]); ?>.html"><?php echo ($val["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</dl>
<dl class="text-list">
            <script type="text/javascript">
var cpro_id="u2728689";
(window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",rsi0:"300",rsi1:"250",pat:"1",tn:"baiduCustNativeAD",rss1:"#FFFFFF",conBW:"1",adp:"1",ptt:"1",ptc:"%E7%8C%9C%E4%BD%A0%E6%84%9F%E5%85%B4%E8%B6%A3",ptFS:"14",ptFC:"#FFFFFF",ptBC:"#FF6633",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",titSU:"0",tft:"1",tlt:"1",ptbg:"60",piw:"0",pih:"0",ptp:"1"}
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
  </div>
</dl>
  </div>

</div>
<!--自动推送-开始-->
<script>
(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https'){
   bp.src = "https://zz.bdstatic.com/linksubmit/push.js';
  }
  else{
  bp.src = 'http://push.zhanzhang.baidu.com/push.js';
  }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script><script>
(function(){
   var src = (document.location.protocol == "http:") ? "http://js.passport.qihucdn.com/11.0.1.js?29eb3ebac225dbae4c3bf7187cfcb7b1":"https://jspassport.ssl.qhimg.com/11.0.1.js?29eb3ebac225dbae4c3bf7187cfcb7b1";
   document.write('<script src="' + src + '" id="sozz"><\/script>');
})();
</script>
<!--自动推送-结束-->

<!-- 主体内容-结束 -->



<!-- 底部-开始 -->
<div class="footer">

	<div class="footer-content">
		<div class="about">
			<dl>
				<dt>关于<?php echo ($setting["site_name"]); ?></dt>
				<dd><a href="/about/jianjie.html" target="_blank"><?php echo ($setting["site_name"]); ?>简介</a><a href="/about/gonggao.html" target="_blank"><?php echo ($setting["site_name"]); ?>公告</a></dd>
				<dd><a href="/about/shengming.html" target="_blank">免责声明</a><a href="/about/feedback.html" target="_blank" class="a-color-red">反馈意见</a></dd>
			</dl>
			<dl>
				<dt>互动规则</dt>
				<dd><a href="/about/tougao.html" target="_blank">投稿规则</a><a href="/about/shengao.html" target="_blank" class="a-color-red">审稿规则</a></dd>
				<dd><a href="/about/shengji.html" target="_blank">升级规则</a><a href="/about/jifen.html" target="_blank">积分规则</a></dd>
			</dl>
			<dl>
				<dt>关注<?php echo ($setting["site_name"]); ?></dt>
				<dd><a href="http://weibo.com/gxbjxh" target="_blank" class="footer-weibo" rel="nofollow">新浪微博</a><a href="http://user.qzone.qq.com/88525903/" target="_blank" class="footer-qzone">QQ空间</a></dd>
				<dd><a href="http://t.qq.com/jokephb" target="_blank" class="footer-QQweibo" rel="nofollow">腾讯微博</a><a href="#" target="_blank" class="footer-weixin">微信订阅</a></dd>
			</dl>
			<dl>
				<dt><?php echo ($setting["site_name"]); ?>合作</dt>
				<dd>粉丝Q群:<i></i>3984850214</dd>
				<dd>合作：<?php echo ($setting['site_email']); ?></dd>
			</dl>
			<dl>
				<dt><?php echo ($setting["site_name"]); ?>微信公众</dt>
				<dd><img src="<?php echo ($setting['site_qrcode']); ?>" width="110" height="110"></dd>
			</dl>
		</div>
		<div class="coypright">
			<p><?php echo ($setting["site_copyright"]); ?>　ICP备：<?php echo ($setting["site_icp"]); ?>　<?php echo (htmlspecialchars_decode($setting["site_tongji_code"])); ?></p>
		</div>
	</div>
</div>
<!-- 底部-结束 -->

<!--回到顶部-开始-->
<div class="return-top" id="j-return-top">
	<div class="return-code">
		<img class="qrcode" src="<?php echo ($setting['site_qrcode']); ?>">
		<img class="arrow" src="/Public/index/xxhh/images/reutrn-code-bg.png">
	</div>
	<div class="return-btn"></div>
</div>
<!--回到顶部-结束-->
<!--自动推送-开始-->
<?php include_once("baidu_js_push.php") ?>
<script>
(function(){
   var src = (document.location.protocol == "http:") ? "http://js.passport.qihucdn.com/11.0.1.js?29eb3ebac225dbae4c3bf7187cfcb7b1":"https://jspassport.ssl.qhimg.com/11.0.1.js?29eb3ebac225dbae4c3bf7187cfcb7b1";
   document.write('<script src="' + src + '" id="sozz"><\/script>');
})();
</script>
<!--自动推送-结束-->
<?php echo ($adv['pc_fumeiti']); echo ($adv['pc_duilian']); ?>
</body>
</html>
<?php if($user_joke['type'] == 4): ?><!--视频播放api--><script type="text/javascript">
var ivaInstance = new Iva(
 'video',
 {
   appkey: '<?php echo ($setting["site_appkey"]); ?>',
   live: false,
   video: '<?php echo ($user_joke["content"]); ?>',
   title: '<?php echo ($user_joke["title"]); ?>',
   cover:'<?php echo ((isset($user_joke["image"]) && ($user_joke["image"] !== ""))?($user_joke["image"]):"/Public/images/fengmian.png"); ?>',
 }
);
</script><!--End--><?php endif; ?>
<script type="text/javascript">
seajs.use(['app','user','share','page','template'], function(App,user,share) {


	$(window).load(function(){
		user.jokeList(test);
	});

	var commentBox = $('#comment-box');
	commentBox.on('click','.comment-ding-icon',function(){
		var self = $(this),
			id = self.data('id');
		user.commentDing(self,id);
	});
	commentBox.on('click','.comment-reply',function(){
		var box = $('#comment'),
			input = $('#comment-content'),
			at_user = box.find('.at_user_id'),
			self = $(this).parents('li'),
			id = self.find('.user_id').data('id'),
			p = self.find('.p-content').text(),
			username = self.find('.comment-username a').text();
		var str = '//@'+username+' '+p+' ';
		at_user.val(id);
		input.val(str);
	});


	//分页
	var count = $('#count').val(),
		joke_id = $('#joke_id').val();
	if(count>=5){
		$('.page').pagination(count, {
			num_edge_entries: 1, //边缘页数
			num_display_entries: 4, //主体页数
			callback: view,
			items_per_page: 5, //每页显示1项
			prev_text: '前一页',
			next_text: '后一页'
		});
	};

	//评论
	var submit = $('#comment-submit'),
		form = $('#comment'),
		commentList = $('#comment-list');
	submit.click(function(){
		if(!user.isLogin()){
			user.loginDialog();
			return;
		};
		var data = form.serializeObject();
		if(!data.content || data.content.length > 150){
			App.alert('回复内容不能为空！最大长度150个字符！');
			return;
		};
		App.request({
			url : '/ajax/review',
			data : data,
			success : function(result){
				var re = result || {};
				if(re.err){
					$('#comment-content').val('');
					App.alert('评论成功，请耐心等待审核！');
					return;
					var obj = re.msg[0];
					var _html = '<li>\
									<div class="comment-content">\
										<a class="user_id" href="/user/'+obj.user_info.id+'" data-id="'+obj.user_info.id+'"> <img src="'+obj.user_info.avatar+'" alt="'+obj.user_info.username+'" /><i></i> </a>\
										<p class="comment-username"><a href="/user/'+obj.user_info.id+'">'+obj.user_info.username+'</a></p>\
										<p class="p-content">'+obj.content+'</p>\
									</div>\
									<div class="comment-ding">\
										<span>'+(parseInt(count)+1)+'楼</span>\
										<a href="javascript:void(0);" class="comment-ding-icon" data-id="'+obj.id+'">0</a>\
										<a class="comment-reply" href="javascript:void(0);">回复</a>\
									</div>\
							</li>';
						commentList.prepend(_html);
				}else{
					App.alert(re.msg);
				};
			}
		});
	});




	var flag = false,
		html = '<ul class="comment-list" id="comment-list">\
				<% for(var i in list) { %>\
				<li>\
					<div class="comment-content">\
						<a href="/user/<%=list[i].user_id%>"><img src="<%=list[i].user_info.avatar%>" alt="<%=list[i].user_info.username%>"><i></i></a>\
						<p class="comment-username"><a href="/user/<%=list[i].user_id%>"><%=list[i].user_info.username%></a></p>\
						<p><%=list[i].content%></p>\
					</div>\
					<div class="comment-ding">\
						<span><%=start--%> 楼</span>\
						<a href="javascript:void(0);" class="comment-ding-icon" rel="nofollow" data-id="<%=list[i].id%>"><%=list[i].good_num%></a>\
						<a class="comment-reply" href="javascript:void(0);" rel="nofollow">回复</a>\
					</div>\
				</li>\
				<% } %>\
				</ul>';
	function view(i,obj){
		if(!i && !flag) return;
		flag = true;
		App.request({
			url : '/xiaohua/getreview',
			data : {id : joke_id,p : i+1},
			success : function(result){
				var re = result || {};
				if(re.err){
					var obj = {list : re.msg};
					obj.start = count - ((i) * 5);
					commentBox.html(template.compile(html)(obj));
				}else{
					App.alert(re.msg);
				};
			}
		});
	};
window._bd_share_config={"common":{"bdSnsKey":{"tsina":"","tqq":""},"bdMini":"2","bdMiniList":false,"bdStyle":"1","bdSize":"16","onBeforeClick":function(cmd){if(cmd == 'weixin'){return {bdUrl:shareweixin};}return {bdUrl:shareurl,bdPic:sharepic,bdText:sharecon}},"bdCustomStyle":'/Public/images/bdshare.css'},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];$('.sharebtn').on({mouseover:function(){$(this).children('span').stop().fadeIn();$(this).children('img').attr('src','/Public/images/fen-h.png');shareid = $(this).attr('data-id');var data = $('#sharedata-'+shareid).text().split('|#|');sharecon = data[0];shareurl = data[1];sharepic = data[2];shareweixin = data[3];},mouseout:function(){$(this).children('img').attr('src','/Public/images/fen.png');$(this).children('span').stop().fadeOut();}});});
</script>