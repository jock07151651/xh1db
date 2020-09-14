/**
 * Created by huo_yg on 2015/4/22.
 */

var page_1 = 0;
var page_2 = 0;
var page_3 = 0;
var page_4 = 0;
var page_5 = 0;
 
$(function(){
	if(page_1 == 0) page_effect_1()
	$(window).scroll(function(){
		var top = $(window).scrollTop()+$(window).height();
		if(top > 1400 && page_2 == 0){
			page_effect_2();
		}else if(top > 2200 && page_3 == 0){
			page_effect_3();
		}else if(top > 3000 && page_5 == 0){
			page_effect_4();
		}
	});
	var l = ($(window).width()-321)/2;
	var lt = ($(window).width()-631)/2;
	$('.page4').find('.phone_img').css('left',l+'px');
	$('.page4').find('.p4_icon_1').css('left',lt+'px');
	
	//更多下载按钮
	var ah = $('.address-more').css('height','auto').css('display','none').css('height');
	$('.address-more').css('display','block').css('height','0')
	$('.app-android').hover(function(){
		$('.address-more').stop().animate({
			height:ah
		},100)
	},function(){
		$('.address-more').stop().animate({
			height:'0'
		},100)
	})
	$('.address-more').hover(function(){
		$('.address-more').css('display','block');
		$('.address-more').stop().animate({
			height:ah
		},100)
	},function(){
		$('.address-more').stop().animate({
			height:'0'
		},100)
	})
	
});

function page_effect_1(){
	page_1 = 1;
	//p1_phone();
	function p1_phone(){
		$('.p1_phone').animate({
			marginTop:0
		},800)
		
		setTimeout(function(){
			$('.p1_phone').animate({
				marginTop:'40px'
			},800)
		},900)
		
		setTimeout(function(){
			p1_phone()
		},180)
	}
}
function page_effect_2(){
	page_2 = 1;
	
	$('.p2_content').find('.phone_img').animate({
		'filter':'alpha(opacity=100)',
		'opacity':1,
		'-moz-opacity':1
	},500)
	
	setTimeout(function(){
		a = $('.p2_icon');
		TweenMax.staggerTo(a, 0.3, {
			bezier: [{
				scale: 0,
				opacity: 0
			},
			{
				scale: 1.05,
				opacity: 1
			}],
			ease: new Ease(BezierEasing(0.17, 0.67, 0.75, 1.46))
		},0.5)
	},800)
	
	setTimeout(function(){
		$('.page2 .p2_content').css('overflow','hidden');
		$('.p2_content').find('.p2_audit_bg').animate({
			bottom:'-30px',
			'filter':'alpha(opacity=100)',
			'opacity':1,
			'-moz-opacity':1
		},200)
	},3500)
}
function page_effect_3(){
	page_3 = 1;
	
	$('.p3_content').find('.phone_img').animate({
		'filter':'alpha(opacity=100)',
		'opacity':1,
		'-moz-opacity':1
	},500)
	
	setTimeout(function(){
		$('.p3_content').find('.p3_icon_1').css('display','block');
		$('.p3_content').find('.p3_icon_1').animate({
			left:'0'
		},600)
	},500)
	
	setTimeout(function(){
		a = $('.p3_icon_6');
		TweenMax.staggerTo(a, 0.2, {
			bezier: [{
				scale: 0,
				opacity: 0
			},
			{
				scale: 1.05,
				opacity: 1
			}],
			ease: new Ease(BezierEasing(0.17, 0.67, 0.75, 1.46))
		},0.5)
	},1200)
	
	setTimeout(function(){
		$('.p3_content').find('.p3_icon_2').css('display','block');
		$('.p3_content').find('.p3_icon_2').animate({
			left:'490px'
		},100)
	},2000)
	
	setTimeout(function(){
		$('.p3_content').find('.p3_icon_3').css('display','block');
		$('.p3_content').find('.p3_icon_3').animate({
			left:'20px'
		},100)
	},2300)
	
	setTimeout(function(){
		$('.p3_content').find('.p3_icon_4').css('display','block');
		$('.p3_content').find('.p3_icon_4').animate({
			left:'450px'
		},100)
	},2600)
	
	setTimeout(function(){
		$('.p3_content').find('.p3_icon_5').css('display','block');
		$('.p3_content').find('.p3_icon_5').animate({
			left:'-190px'
		},100)
	},2900)
	
	
	
	
}
function page_effect_4(){
	page_4 = 1;
	
	$('.page4').find('.phone_img').animate({
		bottom:0
	},500)
	
	
	setTimeout(function(){
		$('.page4_bg').animate({
			'filter':'alpha(opacity=100)',
			'opacity':1,
			'-moz-opacity':1
		},400)
	},1400)
	
}

function page_effect_5(){
	page_5 = 1;

	$('.page5').find('.phone_img').animate({
		'filter':'alpha(opacity=100)',
		'opacity':1,
		'-moz-opacity':1,
		'marginTop':0
	},500)


	setTimeout(function(){
		$('.p_info').animate({
			'filter':'alpha(opacity=100)',
			'opacity':1,
			'-moz-opacity':1
		},500)
	},800)

	setTimeout(function(){
		a = $('.page5').find('ul').find('img');
		TweenMax.staggerTo(a, 0.2, {
			bezier: [{
				scale: 0,
				opacity: 0
			},
				{
					scale: 1.05,
					opacity: 1
				}],
			ease: new Ease(BezierEasing(0.17, 0.67, 0.70, 1.46))
		},0.5)
	},1400)
}
