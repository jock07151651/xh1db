define(function (require, exports, module) {
    var bootstrap = require('bootstrap'),
        layer = require('layer'),
        menu = require('menu'),
        metisMenu = require('metisMenu'),
        slimscroll = require('slimscroll'),
        contabs = require('contabs'),
        pace = require('pace'),
        content = require('content'),
        minicolors = require('minicolors'),
        tableCheckbox = require('tableCheckbox'),
        validate = require('validate'),
        messages_zh = require('messages_zh');
    	
    $('body').delegate('#selectAll','click',function(){
    	if(this.checked){    
	            $("#content-main #DatabaseBackup :checkbox").prop("checked", true);   
	        }else{    
	            $("#content-main :checkbox").prop("checked", false); 
	        }  
    });
    $(".btn-collapse-sidebar-left").click(function(){
		$(".top-navbar").toggleClass("toggle");
	})

    //水印设置相关
	$('body').delegate('#water_switch','change',function(){
		var t0 = $(this).val();
	    if(t0 == "0"){
	        $(".no").css("display","none");
	        $(".water_type").css("display","none");
	        $(".text").css("display","none");
	    }else if(t0 == "1"){
	        $(".water_type").css("display","block");
	        if($("#t1_1").attr("checked")){
	            $(".text").css("display","block");
	        }else{
	            $(".text").css("display","none");
	        }
	    }
	});

	$(document).delegate('body','hover',function(){
		if($('#water_switch').val() == "1"){
			$(".water_type").css("display","block");
			if($('#t1_1').attr("checked")){
				$(".no").css("display","none");$(".text").css("display","block");
			}
			if($('#t1_2').attr("checked")){
				$(".text").css("display","none");$(".no").css("display","block");
			}
		}
	});

    $('body').delegate('#t1_1','click',function(){
    	$(".no").css("display","none");$(".text").css("display","block");
    });
    $('body').delegate('#t1_2','click',function(){
    	$(".text").css("display","none");$(".no").css("display","block");
    });

    //复选框
    $('body').delegate('table','click',function(){
    	$(this).tableCheckbox({ /* options */ });
    });


	//表单验证
	$.validator.setDefaults({
		highlight: function(e) {
			$(e).closest(".form-group").removeClass("has-success").addClass("has-error")
		},
		success: function(e) {
			e.closest(".form-group").removeClass("has-error").addClass("has-success")
		},
		errorElement: "span",
		errorPlacement: function(e, r) {
			e.appendTo(r.is(":radio") || r.is(":checkbox") ? r.parent().parent().parent() : r.parent())
		},
		errorClass: "help-block m-b-none",
		validClass: "help-block m-b-none"
	})

	//区域添加
    $('body').delegate('.J_add_area','click',function(){
    	$('#addarea').fadeIn();
	})


	//编辑区域
	var i=1;
	$('body').delegate('.J_addstrictEdit','click',function(){
		i = i+1;
		var url = $(this).data('url');
		var id = $(this).data('id');
		var name = $(this).data('name');
		var type = $(this).data('type');
		var iid = id;
		var nname = name;
		if(type == 'add'){
			iid = '';
			nname = '';
		}
		var tpl = '<div class="addstrictEdit" style="z-index:'+i+'"><div class="arrow"></div><form submit-url="'+url+'" method="post">\
                    <input type="hidden" name="old_id" value="'+id+'">\
                    <input type="hidden" name="pid" value="'+id+'">\
                    <div class="form-group">\
                        <label class="sr-only">ID：</label>\
                        <input type="text" name="id" value="'+iid+'" class="form-control" placeholder="请输入区域ID，保证唯一性">\
                    </div>\
                    <div class="form-group">\
                        <label class="sr-only">名称：</label>\
                        <input type="text" name="name" value="'+nname+'" class="form-control" placeholder="请输入名称">\
                    </div>\
                    <div class="text-center">\
	                    <button class="btn btn-primary" type="submit" data-form-action="App.submit_form">保存</button>\
	                    <button class="btn btn-danger J_close" type="button">取消</button>\
                    </div>\
                    <div class="clearfix"></div>\
                </form></div>';
		$(this).after(tpl);
	})
	$('body').delegate('.districtList .card-box .J_close','click',function(){
		$(this).closest('.addstrictEdit').remove();
	})

	$('body').delegate('#addarea .J_close','click',function(){
		console.log($(this).parent().parent());
		$(this).closest('#addarea').fadeOut();
	})


    var manage = {
        main : function () {
        	
        },
        cate_menu:function(cate,pid) {
        	var menu = '';
	    	for (var i = 0; i < cate.length ; i++) {
				menu += '<li data-pid="'+pid+'" class="lightTreeview">';
				menu += '<a class="J_menuItem" href="/index.php?m=Admin&c=modelcommon&a=index&cate_id='+cate[i]['id']+'"><span class="flex-ico flex-close"></span><i class="fa fa-newspaper-o"></i> <span class="nav-label">'+cate[i]['name']+'</span>';
				if(cate[i]['sub'] && cate[i]['sub'].length > 0) {
					menu += manage.cate_sub_menu(cate[i]['sub'],pid);
				}else {
					menu += '</a>';
				}
				menu += '</li>';
	    	}
	    	return menu;
        },
        cate_sub_menu:function(cate,pid) {
        	var menu = '';
        	menu += '<span class="flex-ico flex-close"></span>';
			menu += '</a>';
			for(var i = 0; i < cate.length; i++) {
				menu += '<ul class="nav nav-second-level collapse">';
				menu += '<li data-pid="'+pid+'"><a class="J_menuItem" data-index="'+pid+'" href="/index.php?m=Admin&c=modelcommon&a=index&cate_id='+cate[i]['id']+'"><span class="nav-label">'+cate[i]['name']+'</span>';
				if(cate[i]['sub'] && cate[i]['sub'].length > 0) {
					var sub = cate[i]['sub'];
					menu += manage.cate_sub_menu(sub,pid);
				}else {
					menu += '</a>';
				}
				menu += '</ul>';
			}
			return menu;
        }
	};

    return manage;
});