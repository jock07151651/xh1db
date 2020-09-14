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



<!-- 主体内容-开始 -->

<div class="main clearfix">
  <div class="main-left fl" id="j-main-list">
    <div class="main-nav clearfix" id="j-main-nav">
      <ul class="clearfix fl">
        <li><a class="action" href="/">最 新</a></li>
              <li><a href="/hot">8小时热门</a></li>
              <li><a href="/hot/week">7天热门</a></li>
              <li><a href="/hot/month">30天热门</a></li>
      </ul>
      <p class="notice"><a href="/about/jifen.html"><b>公告：</b>搞笑笔记最新积分规则</a></p>
    </div>
    <div class="side-nav" id="j-side-nav">
      <ul class="clearfix">
        <li class="cur"><a href="/">首页</a></li>
        <li><a href="/text">段子</a></li>
        <li><a href="/pic">趣图</a></li>
        <li><a href="/gif">动图</a></li>
        <li><a href="/video">视频</a></li>
      </ul>
    </div>
    <script type="text/javascript" src="http://7xjfim.com2.z0.glb.qiniucdn.com/Iva.js"></script>
<!-- 笑话列表-开始 -->

		<?php if($user_joke == NULL): ?><dl class="main-list" style="height:100%;text-align:center;">
				<p style="font-size:20px;text-align:center;margin-top:16px;padding-bottom:20px;">小伙伴新来的，啥也木有。</p>
			</dl><?php endif; ?>

		<?php if(is_array($user_joke)): $i = 0; $__LIST__ = $user_joke;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><dl class="main-list">
			<dt>
				<a href="/user/<?php echo ($val["user_info"]["id"]); ?>" target="_blank">
					<img src="<?php echo ($val["user_info"]["avatar"]); ?>">
				</a>
				<p class="user">
					<a href="/user/<?php echo ($val["user_info"]["id"]); ?>"><?php echo ($val["user_info"]["username"]); ?></a>
					<a href="/about/shengji.html" class="level_icon icon_lv<?php echo (level($val["user_info"]["username"])); ?>" title="<?php echo (levelname($val["user_info"]["username"])); ?>" target="_blank"></a>

					<span class="fr">
					<?php if($user != NULL): if($user['id'] != $val['user_info']['id']): ?><a href="javascript:void(0);" title="私信" data-username="<?php echo ($val["user_info"]["username"]); ?>" data-userid="<?php echo ($val["user_info"]["id"]); ?>" class="user-dm">私信</a>
					<?php
 if(check_follow($user['id'],$val['user_info']['id']) == 0){ ?>
	        <a href="javascript:void(0);" data-ajax="follow" data-userid="<?php echo ($val["user_info"]["id"]); ?>" class="user-follow"><i class="icon icon10 icon-add-h"></i>关注</a>
	        <?php
 }else{ ?>
	        <a href="javascript:void(0);" data-ajax="follow" data-userid="<?php echo ($val["user_info"]["id"]); ?>" class="user-follow user-cancelfollow"><i class="icon icon10 icon-cut"></i>已关注</a>
	        <?php } endif; endif; ?>
					&nbsp;
					</span>
				</p>
				<span class="title"><a target="_blank" href="/xiaohua/<?php echo ($val["id"]); ?>.html"><?php echo ($val["title"]); ?></a></span>
			</dt>
			<dd class="content<?php if($val['type'] == 3 || $val['type'] == 2){echo ' content-pic'; }?>">
				<?php
 if($val['type'] == 3) { $content = htmlspecialchars_decode(stripcslashes($val['content'])); $image = str_replace('m_','',$val['image']); $image = str_replace('/w5','',$image); $content = str_replace('src="'.$image.'"','class="gifimg" gifimg="'.$image.'" src="'.$val['image'].'"',$content); $content = str_replace('alt=""','alt="'.$val['title'].'"',$content); echo $content; echo '<span class="gif-play-btn" style="display:none">播放GIF</span>'; }else if($val['type'] == 2){ $image = $val['image']; $content = htmlspecialchars_decode(stripcslashes($val['content'])); $content = str_replace('alt=""','alt="'.$val['title'].'"',$content); $pattern="/<img\s[^<>]*?src=[\'\"]([^\'\"<>]+?)[\'\"][^<>]*?>/i"; preg_match_all($pattern,$content,$match); $piccount = count($match[0]); if($piccount > 1){ echo '<div class="article-content">' . "\r\n"; echo '	<div class="multiple-article-wrapper">' . "\r\n"; echo '	  <div class="multiple-article-zone clearfix">' . "\r\n"; echo '	    <div class="multiple-article-arrow prev"> <a href="javascript:;" class="deactive"> <i class="icon-left-open-big"></i> </a> </div>' . "\r\n"; echo '	    <div class="multiple-pics-wrapper">' . "\r\n"; echo '	      <div class="multiple-pics-zone">' . "\r\n"; echo '	        <ul class="multiple-pics-list">' . "\r\n"; for($i=0;$i<$piccount;$i++){ $img = $match[0][$i]; preg_match_all('/src="(.*?)"/i',$img,$array); if(count($array) > 1) { foreach($array[1] as $k => $v) { $src = $v; $img = str_replace($v,$src,$img); } } if($i == 0){ echo '<li class="active">'.$img.'</li>' . "\r\n"; }else{ echo '<li>'.$img.'</li>' . "\r\n"; } } echo '</ul>' . "\r\n"; echo '	      </div>' . "\r\n"; echo '	    </div>' . "\r\n"; echo '	    <div class="multiple-article-arrow next"> <a href="javascript:;"> <i class="icon-right-open-big"></i> </a> </div>' . "\r\n"; echo '	  </div>' . "\r\n"; echo '	  <div class="multiple-thumbnail-zone clearfix">' . "\r\n"; echo '	    <div class="multiple-thumbnail-arrow thumbprev"> <a href="javascript:;" class="deactive"> <i class="icon-left-open-big"></i> </a> </div>' . "\r\n"; echo '	    <div class="multiple-thumbnail-area">' . "\r\n"; echo '	      <ul class="multiple-thumbnail-list">' . "\r\n"; echo '</ul>' . "\r\n"; echo '	    </div>' . "\r\n"; echo '	    <div class="multiple-thumbnail-arrow thumbnext"> <a href="javascript:;"> <i class="icon-right-open-big"></i> </a> </div>' . "\r\n"; echo '	  </div>' . "\r\n"; echo '	</div>' . "\r\n"; echo '</div>' . "\r\n"; }else{ $content = htmlspecialchars_decode(stripcslashes($val['content'])); $content = str_ireplace("alt=\"\"" ,"alt=\"".$val['title']."\" ",$content); $img = $content; preg_match_all('/src="(.*?)"/i',$img,$array); if(count($array) > 1) { foreach($array[1] as $k => $v) { $src = $v; $img = str_replace($v,$src,$img); } } echo '<div class="j-funny">'.$img.'</div>'; } }else if($val['type'] == 4){ $cover = $val['image'] ? $val['image'] : "/Public/images/fengmian.png"; echo '<div id="video-'.$val['id'].'" class="videoContainer" data-id="'.$val['id'].'" data-path="'.$val['content'].'" data-title="'.$val['title'].'" data-cover="'.$cover.'" style="width:600px;height:340px; margin-left:auto; margin-right:auto"><div class="control_bar"><table><tr><td align="center" valign="middle"><img src="'.$cover.'" style="vertical-align:middle;"><i class="play"></i></td></tr></table></div></div>'; }else{ if(strlen(htmlspecialchars_decode(stripcslashes($val['content']))) > 400) { echo mb_substr(strip_tags(htmlspecialchars_decode(stripcslashes($val['content']))),0,400,'utf-8').'……'; echo '<br/>'; echo '<div><a href="/xiaohua/'.$val['id'].'.html" style="text-decoration:underline;"> >>查看更多</a></div>'; }else { echo htmlspecialchars_decode(stripcslashes($val['content'])); } }?>
			</dd>
			<dd class="operation clearfix">
				<div class="operation-btn">
					<a href="javascript:void(0);" data-id="<?php echo ($val["id"]); ?>" class="ding <?php if(($val["record"] != NULL) AND ($val['record']['type'] == 'good')): ?>ding-hover<?php endif; ?>" title="顶">
						<div class="dingcai">
							<span></span>
							<i><?php echo ($val["good_num"]); ?></i>
						</div>
					</a>
					<div class="operation-line"></div>
				</div>
				<div class="operation-btn">
					<a href="javascript:void(0);" data-id="<?php echo ($val["id"]); ?>" class="cai <?php if(($val["record"] != NULL) AND ($val['record']['type'] == 'bad')): ?>cai-hover<?php endif; ?>" title="踩">
						<div class="dingcai">
							<span></span>
							<i><?php echo ($val["bad_num"]); ?></i>
						</div>
					</a>
					<div class="operation-line"></div>
				</div>
				<div class="operation-btn">
					<a href="javascript:void(0);" data-id="<?php echo ($val["id"]); ?>" class="index-comment comment" title="评论">
						<div class="dingcai"><span></span><i><?php echo (review($val["id"])); ?></i></div>
					</a>
					<div class="operation-line"></div>
				</div>
				<div class="share-box clearfix">
					<span class="action-btn sharebtn" data-id="<?php echo ($val["id"]); ?>"><img src="/Public/images/fen.png" h_src="/Public/images/fen-h.png" alt="分享" style="height: 18px;">
						<div style="display:none" id="sharedata-<?php echo ($val["id"]); ?>"><?php echo ($val["title"]); ?>（来自:<?php echo ($setting["site_name"]); ?>）|#|<?php echo ($setting["site_domain"]); ?>/xiaohua/<?php echo ($val["id"]); ?>.html|#|<?php echo ($setting["site_domain"]); echo ($val['image']); ?>|#|<?php echo ($setting["site_domain"]); ?>/xiaohua/<?php echo ($val["id"]); ?>.html</div>
						<span class="bdsharebuttonbox bdsharebtn" style="display:none">
							<a href="javascript:void(0);" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
							<a href="javascript:void(0);" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
							<a href="javascript:void(0);" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
							<a href="javascript:void(0);" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
						</span>
					</span>
				</div>

				<?php if($user['id'] != $val['user_info']['id']): if(($val["record"] == NULL) OR ($val['record']['award'] == 0)): ?><a class="reward" href="javascript:void(0)" data-award="<?php echo ($val["award_num"]); ?>" data-id="<?php echo ($val["id"]); ?>">打赏</a><?php endif; ?>
					<?php if(($val["record"] != NULL) AND ($val['record']['award'] > 0)): ?><a class="rewarded" href="javascript:void(0)">已打赏</a><?php endif; ?>
					<?php if(($val["is_package"] == 1) AND ($val["package_user_id"] == 0)): ?><a class="buy" href="javascript:void(0)" data-id="<?php echo ($val["id"]); ?>" data-fee="<?php echo ($val["package_fee"]); ?>">包养</a><?php endif; ?>
					<?php if(($val["is_package"] == 1) AND ($val["package_user_id"] > 0)): ?><div class="kepted">
							<a href="/user/<?php echo ($val['record']['package_info']['id']); ?>"><?php echo ($val['record']['package_info']['username']); ?></a>
							<span>包养了Ta</span>
						</div><?php endif; endif; ?>
			</dd>
		</dl><?php endforeach; endif; else: echo "" ;endif; ?>

		<div id="reward" class="joke-buy-box" style="display: none; top: 0; left: 0;"></div>
		<img src="/Public/index/xxhh/images/loading.gif" style="width:0;height:0;display:none;">
		<!-- 笑话列表-结束 -->
		<script type="text/javascript">seajs.use(['user','share'], function(user,share) {$(window).load(function(){user.jokeList(test);});window._bd_share_config={"common":{"bdSnsKey":{"tsina":"","tqq":""},"bdMini":"2","bdMiniList":false,"bdStyle":"1","bdSize":"16","onBeforeClick":function(cmd){if(cmd == 'weixin'){return {bdUrl:shareweixin};}return {bdUrl:shareurl,bdPic:sharepic,bdText:sharecon}},"bdCustomStyle":'/Public/images/bdshare.css'},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];$('.sharebtn').on({mouseover:function(){$(this).children('span').stop().fadeIn();$(this).children('img').attr('src','/Public/images/fen-h.png');shareid = $(this).attr('data-id');var data = $('#sharedata-'+shareid).text().split('|#|');sharecon = data[0];shareurl = data[1];sharepic = data[2];shareweixin = data[3];},mouseout:function(){$(this).children('img').attr('src','/Public/images/fen.png');$(this).children('span').stop().fadeOut();}});$(document).on('click','.videoContainer',function(){if($(this).find('.control_bar').length>0){var _this=$(this),data=_this.data(),id=data.id,path=data.path,title=data.title,cover=data.cover;_this.find('.control_bar').remove();var ivaInstance=new Iva('video-'+id,{appkey:'<?php echo ($setting["site_appkey"]); ?>',live:false,video:path,title:title,cover:cover,autoplay:true})}});});</script>

    <div class="comment">
      <div class="page"> <?php echo ($page); ?> </div>
    </div>
  </div>
  <div class="main-right fr">
		<ul class="user-operation">
	<li class="user-show">
		<?php if($user == NULL): ?><!--未登录-->
		<a href="javascript:void(0)" class="right-login-web">点击登录</a>
		<span class="user-link"><em>或</em></span>
		<a href="/account/qqlogin" target="_blank" class="right-login-qq"><i class="tr"></i><span>QQ登录</span></a>
		<a href="/account/wblogin" target="_blank" class="right-login-weibo"><i class="tr"></i><span>微博登录</span></a>
		<?php else: ?>
		 <!--已登录-->
		<div class="right-top-avatar-a">
			<a href="/user/<?php echo ($user["id"]); ?>" target="_blank">
				<img alt="<?php echo ($user["username"]); ?>" src="<?php echo ($user["avatar"]); ?>">
			</a>
		</div>
		<dl class="right-top-avatar">
			<dt><a href="/user" target="_blank"><?php echo ($user["username"]); ?></a><p></p>
			</dt><dd class="noborder">笑豆：<em><?php echo ($user["money"]); ?></em></dd>
			<dd>等级：<?php echo ($user["level"]); ?>级</dd>
			<dd class="noborder">投稿：<em><?php echo ($user["send_num"]); ?></em></dd>
			<dd>审稿：<?php echo ($user["audit_suc_num"]); ?></dd>
		</dl><?php endif; ?>
	</li>

	<li class="user-btn">
		<a href="/joke/publish" class="publish" target="_blank"><i class="tr"></i><span>投稿</span></a>
		<a href="/joke/audit" class="audit" target="_blank"><i class="tr"></i><span>审稿</span></a>
	</li>
</ul>
<script type="text/javascript">
	seajs.use(['user'], function(user){
		var login = $('.right-login-web');
		login.click(function(){
			user.loginDialog();
		});
	});
</script>
		<!--已签到-->
		<div class="calendar calendar-out clearfix" id="ysign-box" <?php if($is_sign != 1): ?>style="display:none"<?php endif; ?>>
			<a href="javascript:void(0);" class="calendar-left">
				<i class="icon icon24 icon-diary"></i>签到
			</a>
			<div class="calendar-info">
				<p class="calendar-info-itme flca5">本次获得30笑豆</p>
				<p class="flca5">恭喜你离赢娶白富美又近了一步</p>
			</div>
		</div>

		<!--未签到-->
		<div class="calendar calendar-in" id="nosign-box" <?php if($is_sign == 1): ?>style="display:none"<?php else: ?>style="display:block"<?php endif; ?>>
			<a href="javascript:void(0);" id="user-sign" class="calendar-left">
				<i class="icon icon24 icon-diary-s"></i>签到
			</a>
			<div class="calendar-info">
				<p class="calendar-info-itme">
					<span class="flcf66"><i class="icon icon10 icon-arr"></i>点击签到赚积分</span>
				</p>
				<p class="flca5">点签到赚积分，赢娶白富美</p>
			</div>
		</div>

		<!-- 用户发帖、审帖排行 -->
		<ul class="tab tab-rank" id="phnav">
        	<li class="cur" dataid="ph1">投稿周排行榜<i></i></li>
            <li dataid="ph2">审稿周排行榜<i></i></li>
        </ul>
        <div class="box-rank">
          <ul class="list-rank" id="ulpaihang">
            <div class="lbox" id="ph1" style="display:block">
              <?php if(is_array($send_week_user)): $k = 0; $__LIST__ = $send_week_user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k;?><li>
                <div class="user-avatar40"><a href="/user/<?php echo ($val["id"]); ?>" title="<?php echo ($val["username"]); ?>" target="_blank"><i class="icon user-shadow40"></i><img src="<?php echo ($val["avatar"]); ?>" height="40" width="40" alt=""></a></div>
                <div class="list-rank-info">
                  <p><a href="/user/<?php echo ($val["id"]); ?>" title="<?php echo ($val["username"]); ?>" target="_blank"><?php echo ($val["username"]); ?></a></p>
                  <p><i class="icon icon18 icon-top<?php if($k <=3){echo $k;} ?>"><?php echo ($k); ?></i>发布<?php echo ($val["send_num"]); ?>个帖子
                  <?php if((check_follow($user['id'],$val['id']) == 1)): ?><a href="javascript:void(0);" data-ajax="follow" data-userid="<?php echo ($val["id"]); ?>" class="user-follow user-cancelfollow"><i class="icon icon10 icon-cut"></i>已关注</a>
                    <?php else: ?>
                    <a href="javascript:void(0);" data-ajax="follow" data-userid="<?php echo ($val["id"]); ?>" class="user-follow"><i class="icon icon10 icon-add-h"></i>关注</a><?php endif; ?>
                    </p>
                </div>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="lbox" id="ph2">
            <?php if(is_array($audit_week_user)): $k = 0; $__LIST__ = $audit_week_user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k;?><li>
                <div class="user-avatar40"><a href="/user/<?php echo ($val["id"]); ?>" title="<?php echo ($val["username"]); ?>" target="_blank"><i class="icon user-shadow40"></i><img src="<?php echo ($val["avatar"]); ?>" height="40" width="40" alt=""></a></div>
                <div class="list-rank-info">
                  <p><a href="/user/<?php echo ($val["id"]); ?>" title="<?php echo ($val["username"]); ?>" target="_blank"><?php echo ($val["username"]); ?></a></p>
                  <p><i class="icon icon18 icon-top<?php if($k <=3){echo $k;} ?>"><?php echo ($k); ?></i>审核<?php echo ($val["audit_num"]); ?>个帖子
                  <?php if((check_follow($user['id'],$val['id']) == 1)): ?><a href="javascript:void(0);" data-ajax="follow" data-userid="<?php echo ($val["id"]); ?>" class="user-follow user-cancelfollow"><i class="icon icon10 icon-cut"></i>已关注</a>
                    <?php else: ?>
                    <a href="javascript:void(0);" data-ajax="follow" data-userid="<?php echo ($val["id"]); ?>" class="user-follow"><i class="icon icon10 icon-add-h"></i>关注</a><?php endif; ?>
                    </p>
                </div>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
          </ul>
        </div>


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
		<div class="platform">
	<ul class="platform-other">
		<li class="app-mobilePhone"><a href="<?php echo ($setting['site_murl']); ?>" rel="nofollow" target="_blank">手机看笑话m.gaoxiaobiji.com</a></li>
	</ul>
</div>
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
		<!-- <div class="advertising" id="j-advertising">
			<div class="advertising-box">
				<a href="" target="_blank"><img src="/Public/index/xxhh/images/ab_right_4.jpg?v=20150602" width="300" height="250"></a>
			</div>
		</div> -->
	</div>
<script type="text/javascript">seajs.use(['user'], function(user){user.sign();var trial = $('#j-trial');type = trial.find('.date-type');type.mouseover(function(){var self = $(this),type = self.data('body');self.addClass('hover').siblings('a').removeClass('hover');trial.find('.' + type + '-body').show().siblings('ul').hide();});});</script> </div>

<!-- 主体内容-结束 --> 



<!-- 底部-开始 -->
<div class="footer">
	<div class="links-block clearfix">
		<div class="links-list-block clearfix">
			<div class="likes-title">友情链接：</div>
			<div class="links" id="links_list">
				<div class="likes-list">
					<?php if(is_array($flink)): $i = 0; $__LIST__ = $flink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a target="_blank" href="<?php echo ($val["url"]); ?>"><?php echo ($val["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-content">
		<div class="about">
			<dl>
				<dt>关于我们</dt>
				<dd><a href="/about/jianjie.html" target="_blank"><?php echo ($setting["site_name"]); ?>简介</a><a href="/about/gonggao.html" target="_blank"><?php echo ($setting["site_name"]); ?>公告</a></dd>
				<dd><a href="/about/shengming.html" target="_blank">免责声明</a><a href="/about/feedback.html" target="_blank" class="a-color-red">反馈意见</a></dd>
			</dl>
			<dl>
				<dt>互动规则</dt>
				<dd><a href="/about/tougao.html" target="_blank">投稿规则</a><a href="/about/shengao.html" target="_blank" class="a-color-red">审稿规则</a></dd>
				<dd><a href="/about/shengji.html" target="_blank">升级规则</a><a href="/about/jifen.html" target="_blank">积分规则</a></dd>
			</dl>
			<dl>
				<dt>关注我们</dt>
				<dd><a href="http://weibo.com/gxbjxh" target="_blank" class="footer-weibo" rel="nofollow">新浪微博</a><a href="http://user.qzone.qq.com/303760181/" target="_blank" class="footer-qzone">QQ空间</a></dd>
				<dd><a href="http://t.qq.com/jokephb" target="_blank" class="footer-QQweibo" rel="nofollow">腾讯微博</a><a href="" target="_blank" class="footer-weixin">微信订阅</a></dd>
			</dl>
			<dl>
				<dt>商务合作</dt>
				<dd>笔记粉丝Q群:<i></i>398485094</dd>
				<dd>合作：<?php echo ($setting["site_name"]); ?></dd>
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
<script type="text/javascript">
	seajs.use(['user'], function(user) {
		user.returnTop();
		user.sideNav();
	});
</script>