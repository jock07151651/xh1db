define(function(require, exports, module) {

	var App = require('app'),
		ISLOGIN = null;
		require('template'),
		slide = require('slide');

	var reply = '<dd class="joke-list-comment" style="display: block;"><% if(islogin){%><div class="comment-input"><form><input name="content" class="comment-input-text" placeholder="吐槽一下吧，您的神回复将名垂青史" value="" /><span class="text-length" style="display:none;color: rgb(150, 150, 150);">0/140字</span><input type="button" class="comment-submit" value="评论" /><input type="hidden" name="at_user_id" class="at_user_id"/></form></div><% } else {%><div class="comment-login" id="comment-num-data"><div class="comment-login-text"><a href="javascript:void(0)" rel="nofollow" class="loginClickHref">登录 </a>后才能发表评论，您也可以使用以下帐号进行登录：</div><div class="comment-login-pic"><a href="/account/qqlogin" target="_blank" class="comment-login-qq" title="QQ登录"></a><a href="/account/wblogin" target="_blank" class="comment-login-weibo" title="新浪微博登录"></a></div></div><% } %><ul class="comment-list"><% if(list[0]){ %><% var index = list.length; for(var i in list) {%><li><div class="comment-content"><a class="user_id" href="/user/<%=list[i].user_info.id%>" data-id="<%=list[i].user_info.id%>"><img src="<%=list[i].user_info.avatar%>" alt="<%=list[i].user_info.username%>" /><i></i></a><p class="comment-username"><a href="/user/<%=list[i].user_info.id%>"><%=list[i].user_info.username%></a></p><p class="p-content"><%=list[i].content%></p><% if(list[i].id == godreplyID){ %><em></em><% } %></div><div class="comment-ding"><span><%=index--%>楼</span><a href="javascript:void(0);" class="comment-ding-icon" data-id="<%=list[i].id%>"><%=list[i].good_num%></a><a class="comment-reply" href="javascript:void(0);">回复</a></div></li><% } %><% } else {%><li class="nocomment">还没有人评论过，赶快抢沙发吧！</li><% } %></ul><% if(list[0]){ %><div class="list_comment_all"><a href="/xiaohua/<%=list[0].joke_id%>.html" target="_blank" class="comment_all">查看全部评论</a><a href="javascript:void(0);" rel="nofollow" class="comment_packUp">收起 ↑</a></div><% } %>';

	//搜索
	$('.search-submit').on('click',function(){search($(this));})
	$('#key').keyup(function(event){if(event.keyCode==13){search($(this));}});function search(_this){var key=_this.closest('.search').find('#key').val();if(key.length==''){App.alert('搜索关键字不能为空');return false;}window.location='/joke/search/key/'+key;}
	$('#phnav').find('li').click(function(){var id=$(this).attr('dataid');$('#'+id).show().siblings().hide();})

	//右侧排行滚动
	function phslide(){if($('#ulpaihang').length<1){return!1;}
	var i=1;setInterval(function(){var t=15+(-55*i);$('#ulpaihang').stop().animate({'margin-top':t+'px'},800);if(i>2){$('#ulpaihang').stop().animate({'margin-top':'15px'},800);i=1;}else{i++;}},2000);$('#phnav').on({click:function(){$(this).attr('class','cur').siblings('li').attr('class','');var id=$(this).attr('dataid');$('#'+id).removeClass('hidden').siblings('div').addClass('hidden');$('#ulpaihang').stop().animate({'margin-top':'15px'},0);i=1;}},'li');};phslide();

	if($('.username-nav').size() == 1){ISLOGIN = 1;}
	//关注 取关
	$('body').delegate('a[data-ajax]','click',function(){if(!user.isLogin()){user.loginDialog();return;};var _t=$(this);var userid=_t.data('userid');if(userid){if(!_t.hasClass('user-cancelfollow')){App.request({url:'/ajax/follow',data:{uid:userid},success:function(re){if(re.err){_t.addClass('user-cancelfollow').html('<i class="icon icon10 icon-cut"></i>已关注');}else{App.alert(re.msg);}}})}else{App.request({url:'/ajax/cancelfollow',data:{uid:userid},success:function(re){if(re.err){_t.removeClass('user-cancelfollow').html('<i class="icon icon10 icon-add-h"></i>关注');}else{App.alert(re.msg);}}})}}});

	//私信
	$('body').delegate('.user-dm','click',function(){if(!user.isLogin()){user.loginDialog();return;};var _t=$(this);var username=_t.data('username');var userid=_t.data('userid');var dmHtml=$('<div class="alert-shadow"></div><div id="user-dm"><a href="javascript:void(0);" class="alert-close"></a><div class="umsg-box"><h5>发送给：'+username+'</h5><span class="comment-num" id="maxlen">140</span><textarea name="" id="dmcontent" cols="30" rows="10" class="umsg-box-in"></textarea><div class="comment-fun"><input type="submit" id="submit_dm" class="comment-btn" value="发送"></div></div></div>');dmHtml.appendTo('body');dmHtml.find('#dmcontent').on('keyup keypress change',function(){var maxlen=140;var val=this.value;var len=val.length;if(maxlen-len<0){this.value=val.substr(0,maxlen);}else{len=maxlen-len;dmHtml.find('#maxlen').html(len);}});dmHtml.find('.alert-close').click(function(){dmHtml.remove();});dmHtml.find('#submit_dm').click(function(){var content=dmHtml.find('#dmcontent').val();if(content==''){App.alert('私信内容不能为空');return false;}App.request({url:'/ajax/send_msg',data:{uid:userid,content:content},loading:false,success:function(re){if(re.err){dmHtml.remove();App.alert('私信发送成功');}else{App.alert(re.msg);}}})})});

	var user = {
		loginDialog:function(){var loginBox=new Dialog(),_this=this;loginBox.init({w:800,h:355,content:'<div class="iframe-reg" style="padding:15px;margin:0;width:760px;"><dl class="login-left" style="width:500px;padding-left:10px;"><dt>笔记! 欢迎你回来！</dt><dd><form id="login-form" style="width:500px;"><ul><li><input type="text" name="username" class="email" placeholder="邮箱"><span class="error" style="width:198px;"></span></li><li><input type="password" name="password" class="pasw" placeholder="密码"><span class="error" style="width:198px;"></span></li><li class="user-action clearfix" style="text-align:left;width:299px;"><input type="checkbox" name="is_save" id="keep" value="30" checked=""> <label class="Remember-account" for="keep">下次自动登陆</label><a class="fr" href="/account/forgetpassword">忘记密码？</a></li><li class="button"><input type="button" class="btn" value="登录"></li></ul></form></dd></dl><div class="login-right" style="width:245px;"><div class="or"><span>或</span></div><dl class="loginp" style="margin:80px 0 0 50px;"><dt class="title">使用以下帐号直接登录</dt><dd class="qq"><a href="/account/qqlogin"><i class="login-qq tr"></i><span>QQ</span></a></dd><dd class="weibo"><a href="/account/wblogin"><i lass="login-weibo tr"></i><span>新浪微博</span></a></dd></dl></div></div>',cb:function(){_this.login();}});},
		isLogin : function(){return ISLOGIN == 1 && $('.username-nav').size() != 0;},
		returnTop:function(){var returnTop=$('#j-return-top');$(window).scroll(function(){if($(window).scrollTop()>=($(window).height()/2)){returnTop.fadeIn();}else{returnTop.fadeOut();};});returnTop.find('.return-btn').click(function(){$('body,html').animate({scrollTop:0});});},
		jokeList:function(){var _this=this;_this.returnTop();var mainList=$('#j-main-list'),listBox=mainList.find('.main-list'),reward=mainList.find('.reward'),buy=mainList.find('.buy');listBox.each(function(i,v){var self=$(v),share=self.find('.share-box'),ding=self.find('.ding'),cai=self.find('.cai'),comment=self.find('.index-comment'),detailComment=self.find('.detail-comment');var falg=true;share.hover(function(){$(this).find('.share-menu').show().stop().animate({opacity:1,right:'175px'});},function(){$(this).find('.share-menu').stop().animate({opacity:0,right:'135px'},function(){$(this).hide();});});if(!ding.hasClass('ding-hover')&&!cai.hasClass('cai-hover')){ding.find('.dingcai').click(function(){var self=$(this).parent(),_id=self.data('id');dingcai(_id,'good',self,'ding-hover');});cai.find('.dingcai').click(function(){var self=$(this).parent(),_id=self.data('id');dingcai(_id,'bad',self,'cai-hover');});function dingcai(id,type,self,class_type){App.request({url:'/xiaohua/record',data:{id:id,type:type},loading:false,success:function(result){var re=result||{};if(re.err){self.addClass(class_type);var i=self.find('i');i.text(parseInt(i.text())+1);ding.find('.dingcai').off('click');cai.find('.dingcai').off('click');}else{App.alert(re.msg);};}});};};var flag=-1;comment.find('.dingcai').click(function(){var self=$(this).parent(),id=self.data('id'),box=self.parents('.main-list').find('.joke-list-comment');if(flag==-1){App.request({url:'/xiaohua/getreview',data:{id:id,p:1},success:function(result){var re=result||{};if(re.err){var obj={list:re.msg||{}},html=null,mainList=self.parents('.main-list'),godreplyID=mainList.find('.godreply').data('id');obj.islogin=_this.isLogin();obj.godreplyID=godreplyID||0;html=template.compile(reply)(obj);mainList.append(html);mainList.find('.joke-list-comment .comment_packUp').on('click',function(){$(this).parents('.joke-list-comment').hide();flag=1;});mainList.find('.loginClickHref').on('click',function(){_this.loginDialog();});mainList.find('.comment-submit').on('click',function(){var form=$(this).parent(),data=form.serializeObject();data.id=id;if(!data.content||data.content.length>140){App.alert('回复内容不能为空！最大长度140个字符！');return;};App.request({url:'/ajax/review',data:data,success:function(result){var re=result||{};if(re.err){form.find('.comment-input-text').val('');App.alert('评论成功，请耐心等待审核！');return;var obj=re.msg[0],ul=mainList.find('.comment-list'),li=ul.find('li'),is_reply=li.eq(0).hasClass('nocomment'),index=is_reply?1:li.size()+1;var _html='<li><div class="comment-content"><a class="user_id" href="/user/'+obj.user_info.id+'" data-id="'+obj.user_info.id+'"> <img src="'+obj.user_info.avatar+'" alt="'+obj.user_info.username+'" /><i></i> </a><p class="comment-username"><a href="/user/'+obj.user_info.id+'">'+obj.user_info.username+'</a></p><p class="p-content">'+obj.content+'</p></div><div class="comment-ding"><span>'+index+'楼</span><a href="javascript:void(0);" class="comment-ding-icon" data-id="'+obj.id+'">0</a><a class="comment-reply" href="javascript:void(0);">回复</a></div></li>';if(is_reply){ul.html(_html);}else{if(li.size()==5){li.eq(-1).remove();ul.prepend(_html);var index=6;for(var i=1;i<=li.size();i++){ul.find('.comment-ding span').eq(i-1).text((index=index-1)+'楼');};return;};ul.prepend(_html);};}else{App.alert(re.msg);};}});});mainList.on('click','.comment-ding-icon',function(){var self=$(this),id=self.data('id');_this.commentDing(self,id);});mainList.on('click','.comment-reply',function(){if(!_this.isLogin()){_this.loginDialog();return;};_this.reply($(this));});}else{};flag=0;}});};if(flag==0){box.hide();flag=1;}else if(flag=1){box.show();flag=0;};});detailComment.find('.dingcai').on('click',function(){var top=$('#comment-num-data').offset().top;$('body,html').animate({scrollTop:top});});});_this.gifload();_this.funny();this.popover(reward,buy);},
		gifload:function(){var gifimg=$('.gifimg');$(window).scroll(function(){scroll()});scroll();function scroll(){$.each(gifimg,function(i,v){var v=$(v);if($(window).height()+$(window).scrollTop()>=v.offset().top){var gifPlayBtn=v.parents('.content').find('.gif-play-btn');gifPlayBtn.show();gifPlayBtn.click(function(){var src=v.attr('gifimg'),image=new Image();gifPlayBtn.css({'background-size':'contain','background-image':'url(/Public/index/qiushibaike/images/loading.gif)'}).html('');image.onload=function(){v.attr('src',src);gifPlayBtn.remove()};image.src=src})}})}},
		funny : function(){
			var funny = $('.j-funny');$.each(funny,function(i,v){var v = $(v),img = v.find('img'),h = img.height();if(h >= 500){v.css({'height' : '500px','overflow' : 'hidden'});v.append('<dd class="joke-content-area"><a href="javascript:void(0)" class="joke-height-h" data-height="'+h+'">展开</a></dd>');};});
			var joke_height = $('.joke-content-area').find('a');
			joke_height.click(function(){var self = $(this),height = self.data('height'),obj = self.closest('.j-funny');
				if(self.hasClass('joke-height-h')){obj.animate({height : height});self.text('收起');self.attr('class','joke-height-k');
				}else{obj.animate({height : 500});self.attr('class','joke-height-h');self.text('展开');};});
		},
		reply:function(obj){var box=obj.parents('.joke-list-comment'),input=box.find('form .comment-input-text'),at_user=box.find('form .at_user_id'),self=obj.parents('li'),id=self.find('.user_id').data('id'),p=self.find('.p-content').text(),username=self.find('.comment-username a').text();var str='//@'+username+' '+p+' ';at_user.val(id);input.val(str);},
		popover: function(reward, buy) {
	var _this = this;
	var rewardHtml = '<form id="form_reward" novalidate="novalidate"><dl><dt>大爷们赏了<span>0</span>笑豆</dt><dd class="input-radio"><div style="width:0;height:0;overflow:hidden"><input type="text" name="id" value="" /><input type="text" name="fee" value="5" /></div><span data-id="5" class="hover">5笑豆</span><span data-id="10">10笑豆</span><span data-id="20">20笑豆</span><span data-id="30">30笑豆</span><span data-id="40">40笑豆</span><span data-id="50">50笑豆</span></dd><dd class="message"></dd><dd class="input-btn"> <input type="button" class="reward-submit" value="打赏" /> <input type="button" class="reward-close" value="取消" /></dd> </dl></form>';
	var buyHtml = '<form id="form_buy_box" novalidate="novalidate"><div style="width:0;height:0;overflow:hidden"><input type="text" name="id" value="" /></div><p class="title">包养我吧！只需<span>200</span>笑豆哦！</p><p class="title">以后再赚钱就是你的了</p><p class="buy_error_message"></p> <p class="input-btn"><input type="button" class="reward-submit" value="确定" /><input type="button" class="reward-close" value="取消" /></p></form>';
	var popoverBox = $('#reward');
	reward.click(function() {
		if (!_this.isLogin()) {
			_this.loginDialog();
			return;
		};
		var self = $(this),
		id = self.data('id'),
		award = self.data('award'),
		sid = 0;
		popover($(this), 'joke-buy-box obtain-box', rewardHtml,
		function() {
			var input_radio = popoverBox.find('.input-radio span'),
			fee = popoverBox.find('input[name=fee]');
			input_radio.click(function() {
				var _self = $(this);
				sid = _self.data('id');
				_self.addClass('hover').siblings().removeClass('hover');
				fee.val(sid);
			});
			popoverBox.find('dt span').text(award);
			popoverBox.find('input[name=id]').val(id);
		},
		function() {
			var form = popoverBox.find('form'),
			data = form.serializeObject();
			App.request({url:'/ajax/award',data: data,loading: false,success: function(result) {var re = result;if (re.err) {self.attr('class', 'rewarded').html('已打赏');App.alert('打赏成功，花费' + data.fee + '笑豆！');} else {App.alert(re.msg);};
					popoverBox.hide().css({left: 0,top: 0});
				}
			});
		});
	});
	buy.click(function() {
		if (!_this.isLogin()) {
			_this.loginDialog();
			return;
		};
		var self = $(this),
		id = self.data('id'),
		fee = self.data('fee');
		popover($(this), 'joke-buy-box buy-box', buyHtml,
		function() {
			popoverBox.find('.title span').text(fee);
			popoverBox.find('input[name=id]').val(id);
		},
		function() {
			var form = popoverBox.find('form');
			App.request({
				url: '/ajax/package',
				data: form.serializeObject(),
				loading: false,
				success: function(result) {
					var re = result;
					if (re.err) {
						self.parent().append('<div class="kepted"><a href="/user/' + re.msg.id + '">' + re.msg.username + '</a><span>包养了Ta</span></div>');
						self.remove();
						App.alert('包养成功！');
					} else {
						App.alert(re.msg);
					};
					popoverBox.hide().css({
						left: 0,
						top: 0
					});
				}
			});
		});
	});
	function popover(dom, typeClass, html, setcb, okcb) {
		popoverBox.attr('class', typeClass).html(html);
		var self = dom,
		w = popoverBox.outerWidth(),
		h = popoverBox.outerHeight(),
		submit = popoverBox.find('.reward-submit'),
		cancel = popoverBox.find('.reward-close'),
		x = self.offset().left,
		y = self.offset().top;
		popoverBox.show().css({
			left: ((x - $('#j-main-list').offset().left) - w / 2) + 34,
			top: ((y - $('#j-main-list').offset().top) - h / 2) - 154
			//top: (y - h) - 70
		});
		setcb && typeof setcb == 'function' && setcb();
		submit.click(function() {
			okcb && typeof okcb == 'function' && okcb();
		});
		cancel.click(function() {
			popoverBox.hide().css({
				left: 0,
				top: 0
			});
		});
	};
},
commentDing: function(self, id) {
	App.request({
		url: '/xiaohua/reviewrecord',
		loading: false,
		data: {
			id: id
		},
		success: function(result) {
			var re = result || {};
			if (re.err) {
				var v = self.text();
				self.text(parseInt(v) + 1);
			} else {};
		}
	});
},

		register:function(){var form=$('.iframe-reg form'),email=form.find('input[name=email]'),pass=form.find('input[name=password]'),notpass=form.find('input[name=confirm_password]'),username=form.find('input[name=username]'),sex=form.find('.gender a'),is_email=true,is_username=true,submit=form.find('.btn');var form_flag={check_email:function(){return/^[\w\-\.]+@[\w\-]+(\.[a-zA-Z]{2,4}){1,2}$/.test($.trim(email.val()));},check_pass:function(){return/^[\w]{6,12}$/.test($.trim(pass.val()));},check_notpass:function(){return $.trim(notpass.val())==$.trim(pass.val());},check_user:function(){if(username.val().length<2||username.val().length>12){return false;}else{return true;};}};email.blur(function(){var self=$(this);if(form_flag.check_email()){App.request({url:'/account/checkemail',data:{email:email.val()},loading:false,success:function(result){var re=result;if(re.err){self.next('.error').addClass('valid').show().html('');is_email=true;}else{self.next('.error').removeClass('valid').show().html(re.msg);is_email=false;};}});}else{if(email.val()==''){self.next('.error').removeClass('valid').show().html('邮箱不能为空！');}else{self.next('.error').removeClass('valid').show().html('邮箱错误！');};};});pass.keyup(function(){var self=$(this);if(!form_flag.check_pass()){if(pass.val()==''){self.next('.error').removeClass('valid').show().html('密码不能为空！');}else{self.next('.error').removeClass('valid').show().html('密码错误，长度6~12个字符！');};}else{self.next('.error').addClass('valid').show().html('');};});notpass.keyup(function(){var self=$(this);if(!form_flag.check_notpass()){self.next('.error').removeClass('valid').show().html('两次输入的密码不一致！');}else{self.next('.error').addClass('valid').show().html('');}});username.blur(function(){var self=$(this);if(form_flag.check_user()){App.request({url:'/account/checkusername',data:{username:username.val()},loading:false,success:function(result){var re=result;if(re.err){self.next('.error').addClass('valid').show().html('');is_email=true;}else{self.next('.error').removeClass('valid').show().html(re.msg);is_email=false;};}});}else{if(username.val()==''){self.next('.error').removeClass('valid').show().html('昵称不能为空！');}else{self.next('.error').removeClass('valid').show().html('昵称错误，长度2~8个字符！');};};});sex.click(function(){var self=$(this),sex=self.data('sex'),self_type=self.attr('id'),ther_type=self.siblings('a').attr('id');self.addClass(self_type+'-hover').siblings('a').removeClass(ther_type+'-hover');form.find('input[name=sex]').val(sex);});submit.click(function(){var falg=true;if(!form_flag.check_email()){if(email.val()==''){email.next('.error').removeClass('valid').show().html('邮箱不能为空！');return;};email.next('.error').removeClass('valid').show().html('邮箱错误！');falg=false;};if(!form_flag.check_pass()){if(pass.val()==''){pass.next('.error').removeClass('valid').show().html('密码不能为空！');return;};pass.next('.error').removeClass('valid').show().html('密码错误，长度6~12个字符！');falg=false;};if(!form_flag.check_user()){if(username.val()==''){username.next('.error').removeClass('valid').show().html('昵称不能为空！');return;};username.next('.error').removeClass('valid').show().html('昵称错误，长度2~8个字符！');falg=false;};if(falg&&is_email&&is_username){App.request({url:'/account/register',data:form.serializeObject(),success:function(result){var re=result||{};if(re.err){location.href=re.msg;}else{App.alert(re.msg);};}});};});this.verify();},
		login:function(){var form=$('#login-form'),username=form.find('input[name=username]'),pass=form.find('input[name=password]'),submit=form.find('.btn');$(document).on('keydown',function(e){if(e.keyCode==13){submit.click();};});submit.click(function(){if(!username.val()){username.next('.error').show().html('不能为空');return;}else{username.next('.error').addClass('valid').show().html('');};if(!pass.val()){pass.next('.error').show().html('不能为空');return;}else{pass.next('.error').addClass('valid').show().html('');};App.request({url:'/account/login',data:form.serializeObject(),success:function(result){var re=result||{};if(re.err){location.href='/user';}else{App.alert(re.msg);};}});});},
		verify:function(){var vcodeli=$('.vcodeli img');vcodeli.click(function(){this.src='/Public/verify/tm/'+Math.random();});},
		forgetpassword:function(){var form=$('#form_back_password_email'),email=form.find('input[name=email]'),code=form.find('input[name=code]'),submit=form.find('.btn'),is_email=false;var check_flag={check_email:function(){return/^[\w\-\.]+@[\w\-]+(\.[a-zA-Z]{2,4}){1,2}$/.test($.trim(email.val()));},check_code:function(){if(code.val().length!=4){return false;}else{return true;};}};email.keyup(function(){if(check_flag.check_email()){App.request({url:'/account/checkemail',data:{email:email.val()},loading:false,success:function(result){var re=result;if(re.err){email.next('.error').removeClass('valid').show().html('邮箱不存在！');is_email=false;}else{email.next('.error').addClass('valid').show().html('');is_email=true;};}});}else{email.next('.error').removeClass('valid').show().html('邮箱格式错误！');return;};});code.keyup(function(){if(check_flag.check_code()){code.siblings('.error').addClass('valid').show().html('');}else{code.siblings('.error').removeClass('valid').show().html('验证码4位！');return;};});submit.click(function(){var flag=true;if(!check_flag.check_email()){email.next('.error').removeClass('valid').show().html('邮箱格式错误！');flag=false;};if(!check_flag.check_code()){code.siblings('.error').removeClass('valid').show().html('验证码4位！');flag=false;};if(flag&&is_email){App.request({url:'/account/forgetpassword',data:form.serializeObject(),success:function(result){var re=result;if(re.err){App.alert(re.msg);setTimeout(function() {location.href='/account/login';},2000);}else{App.alert(re.msg);};}});};});this.verify();},
		setInfo:function(){this.setQQ('#eidtQQNum','/user/setqq','QQ');this.setQQ('#eidtMobilePhone','/user/setphone','手机');this.resetPass();},
		setQQ:function(form,url,str){var eidtQQNum=$(form),spanBox=eidtQQNum.find('span'),inputBpx=eidtQQNum.find('.Input'),qq_submit=eidtQQNum.find('.submit'),qq_btn=eidtQQNum.find('.btn'),info=eidtQQNum.find('.error'),key=inputBpx.attr('name');qq_submit.on('click',function(){var v=inputBpx.val();if(!v){info.show().html('请输入'+str+'号！');}else{info.hide();App.request({url:url,data:eidtQQNum.serializeObject(),loading:false,success:function(result){var re=result||{};if(re.err){spanBox.show().html(v);inputBpx.hide();qq_submit.val('修改成功！');qq_submit.off('click');}else{info.show().html(re.msg);};}});};});qq_btn.on('click',function(){var val=spanBox.text();inputBpx.show().val(val);spanBox.hide();qq_btn.hide();qq_submit.show();});},
		resetPass:function(){var form=$('#editPassword'),oldPassword=form.find('.oldPassword'),password=form.find('.password'),passconf=form.find('.passconf'),submit=form.find('.editPassword-submit');var form_flag={check_pass:function(obj){return/^[\w]{6,12}$/.test($.trim(obj.val()));},check_notpass:function(){return $.trim(password.val())==$.trim(passconf.val());}};oldPassword.keyup(function(){var self=$(this);if(self.val()&&form_flag.check_pass(self)){self.next().hide();}else{self.next().show().html('密码6~12个字符！');};});password.keyup(function(){var self=$(this);if(self.val()&&form_flag.check_pass(self)){self.next().hide();}else{self.next().show().html('密码6~12个字符！');};});passconf.keyup(function(){var self=$(this);if(!form_flag.check_notpass()){self.next().show().html('两次输入的密码不一致！');}else{self.next().hide();}});submit.click(function(){var flag=true;if(!form_flag.check_pass(oldPassword)){oldPassword.next().show().html('密码6~12个字符！');flag=false;};if(!form_flag.check_pass(password)){password.next().show().html('密码6~12个字符！');flag=false;};if(!form_flag.check_notpass()){passconf.next().show().html('两次输入的密码不一致！');flag=false;};if(flag){App.request({url:'/user/setpassword',data:form.serializeObject(),success:function(result){var re=result||{};if(re.err){App.alert(re.msg);location.href='/user';}else{App.alert(re.msg);};}});};});},
		setPortrait:function(){var editImg=$('#editImg');editImg.click(function(){var imgDialog=new Dialog();imgDialog.init({w:800,h:400,content:'<div class="upload-content"><div class="upload-left"><span class="avatar-symbol">+</span><p style="text-align:center;">点击上传头像，仅支持JPG、GIF、PNG格式，文件小于5M。（高质量图片可生成高清头像）</p></div><div class="upload-right"><div class="preview-wrap" style="overflow:hidden;"><img class="preview preview_img" src="'+editImg.find('img').attr('src')+'"></div></div><form class="imgform"><div class="ajax-file-upload"><input type="file" id="file" name="file" /></div><input type="button" value="保存并关闭" class="imgsubmit"></form></div>',
		cb:function(){App.uploadify($('#file'),function(imageData){var url=imageData.url.slice(1);var image=$("<img src='"+url+"' id='image-uploaded' data-width='"+imageData.width+"' data-height='"+imageData.height+"' />");$('.upload-left').html(image);require.async(['/Public/js/imgareaselect/jquery.imgareaselect.min','/Public/js/imgareaselect/css/imgareaselect-default.css'],function(){var Images=new Image();Images.src=url;Images.onload=function(){successCb();};});});function successCb(){$('#image-uploaded').imgAreaSelect({ x1: 0, y1: 0, x2:200, y2:200 });var ratio=1.33,uploaded=$('#image-uploaded'),previewWrap=$('.preview-wrap'),preview=$('.preview');var realWidth=uploaded.data('width'),realHeight=uploaded.data('height'),uploadedWidth=uploaded.outerWidth(),uploadedHeight=uploaded.outerHeight(),uploadedRate=uploadedWidth/realWidth;var previewWrapWidth=previewWrap.outerWidth();previewWrapHeight=Math.round(previewWrapWidth);previewWrap.css({width:previewWrapWidth+'px',height:previewWrapHeight+'px'});preview.prop('src',uploaded.attr('src'));preview.removeClass('preview_img');var imgArea=uploaded.imgAreaSelect({instance:true,handles:true,fadeSpeed:300,aspectRatio:'4:4',onSelectChange:function(img,selection){var rate=previewWrapWidth/selection.width;preview.css({width:Math.round(uploadedWidth*rate)+'px',height:Math.round(uploadedHeight*rate)+'px',"margin-left":Math.round(selection.x1*rate*-1),"margin-top":Math.round(selection.y1*rate*-1)});var realSize={url:preview.attr('src'),width:Math.round(selection.width/uploadedRate),height:Math.round(selection.height/uploadedRate),x:Math.round(selection.x1/uploadedRate),y:Math.round(selection.y1/uploadedRate)};preview.data(realSize);}});$('.imgsubmit').click(function(){var data=preview.data(),self=$(this);if(typeof data['width']==='undefined'||data['width']==''||data['width']==0||data['height']==''||data['height']==0){App.alert('请先选择裁剪区域！');return;};self.val('上传中...');App.request({url:'/user/setavatar',data:data,loading:false,success:function(result){var re=result;$('#editImg img').attr('src',re.msg);if(!re.err){App.alert(re.msg);};imgDialog.close();}});});};},
		closeCb:function(){var outer=$('.imgareaselect-outer');var center=outer.eq(0).prev();center.remove();outer.remove();}});});},
		sideNav:function(){var sideNav=$('#j-side-nav'),sideNavBox=sideNav.find('ul'),sideNavList=sideNav.find('li');sideNavList.each(function(i,v){var self=$(v),left=self.data('left'),string=self.data('string');if(left&&string){var original=self.text();self.hover(function(){self.stop().animate({marginLeft:left+'px'},100).text(string);},function(){self.stop().animate({marginLeft:'0px'},100).text(original);});};});$(window).scroll(function(){if($(window).scrollTop()>=sideNav.offset().top){sideNavBox.css('position','fixed');}else{sideNavBox.css('position','static');};});},
		sign:function(){var _this=this;$(document).delegate('#user-sign','click',function(){if(!_this.isLogin()){_this.loginDialog();return;};App.request({url:'/ajax/sign',loading:false,success:function(re){if(re.err){$('#nosign-box').hide();$('#ysign-box').show();}else{App.alert(re.msg);}}});function signPop(){var signHtml=$('<div class="sign icon-sign" id="sign-box"><a href="javascript:void(0);" id="sign-close" class="icon-sign sign-close">关闭</a><p class="sign-get">本次获得<span class="signfont sign48">48</span>积分</p><p class="sign-num">您已经连续签到<span class="signfont sign36">1</span>天</p><ul class="sign-list"><li class="icon-sign sign-list-gray"><p class="sign-list-desc">连续签到<span class="signfont sign52">5</span>天</p><p class="sign-list-con">2倍积分</p></li><li class="icon-sign sign-list-gray"><p class="sign-list-desc">连续签到<span class="signfont sign52">10</span>天</p><p class="sign-list-con">2倍积分</p></li><li class="icon-sign sign-list-gray"><p class="sign-list-desc">连续签到<span class="signfont sign52">15</span>天</p><p class="sign-list-con">3倍积分</p></li><li class="icon-sign sign-list-gray"><p class="sign-list-desc">连续签到<span class="signfont sign52">20</span>天</p><p class="sign-list-con">3倍积分</p></li><li class="icon-sign sign-list-gray"><p class="sign-list-desc">连续签到<span class="signfont sign52">25</span>天</p><p class="sign-list-con">4倍积分</p></li><li class="icon-sign sign-list-gray"><p class="sign-list-desc">连续签到<span class="signfont sign52">30</span>天</p><p class="sign-list-con">300积分</p></li></ul></div>');signHtml.appendTo('body');signHtml.find('#sign-close').on('click',function(){signHtml.remove();})}})}};function Dialog(){this.oLogin=null;this.setTing={w:300,h:300,content:'',mark:true,cb:null,closeCb:null}};Dialog.prototype.init=function(opt){$.extend(this.setTing,opt);this.create();if(this.setTing.mark){this.createMark();};this.fnClose();};Dialog.prototype.create=function(){this.oLogin=document.createElement('div');this.oLogin.className='Dialog';this.oLogin.innerHTML='<div class="title"><span class="close"></span></div><div class="content">'+this.setTing.content+'</div>';document.body.appendChild(this.oLogin);this.setData();};Dialog.prototype.setData=function(){this.oLogin.style.width=this.setTing.w+'px';this.oLogin.style.height=this.setTing.h+'px';this.oLogin.style.left=($(window).width()-this.oLogin.offsetWidth)/2+'px';this.oLogin.style.top=(($(window).height()-this.oLogin.offsetHeight)/2)+$(window).scrollTop()+'px';this.setTing.cb&&typeof this.setTing.cb=='function'&&this.setTing.cb();};Dialog.prototype.createMark=function(){var oMark=document.createElement('div');this.oMark=oMark;this.oMark.id='mark';document.body.appendChild(oMark);this.oMark.style.width=$(document).width()+'px';this.oMark.style.height=$(document).height()+'px';};Dialog.prototype.fnClose=function(){var _this=this;var oClose=this.oLogin.getElementsByTagName('span')[0];this.oMark.onclick=function(){_this.close();};oClose.onclick=function(){_this.close();};};Dialog.prototype.close=function(){var _this=this;document.body.removeChild(_this.oLogin);if(_this.setTing.mark){document.body.removeChild(_this.oMark);};_this.setTing.closeCb&&typeof _this.setTing.closeCb=='function'&&_this.setTing.closeCb();};
	return user;
});