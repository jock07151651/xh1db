
define(function(require, exports, module) {
	
	var Upload = {
		uploadify:function(obj,savePath,type){
			var multi = false;
			var exts = '*.jpg;*.gif;*.png;*.jpeg';
			var desc = '图片类型(*.jpg;*.jpeg;*.gif;*.png)';
			if(type == 'video') {
				exts = '*.mp4;*.rmvb;';
				desc = '视频类型(*.mp4;*.rmvb;)';
			}
			if(type == 'soft') {
				exts = '*.rar;*.exe;';
				desc = '软件类型(*.rar;*.exe;)';
			}
			if(type == 'imglist') {
				multi = true;
			}
			require.async(['/Public/js/jquery.uploadify.min','/Public/js/uploadify/uploadify.css'], function() {
				$(obj).uploadify({
			      'formData'     : {
			        'savePath' : savePath
			      },
			      'buttonText': '本地上传',
		          'buttonClass': 'browser',
		          'dataType':'html',
		          'removeCompleted': false,
			      'swf'      : '/Public/js/uploadify/uploadify.swf',
			      'uploader' : '/index.php?m=Admin&c=public&a=upload',
			      'multi' : multi,
			      'debug': false,
			      'height': 30,
			      'width':75,
			      'auto': true,
			      'fileTypeExts': exts,
			      'fileTypeDesc': desc,
			      'fileSizeLimit': '1024',
			      'progressData':'speed',
			      'removeCompleted':true,
			      'removeTimeout':0,
			      'requestErrors':true,
			      'onInit':function() 
			      {
			      		var parent = $(obj).parent();
			      		//单张图片处理
			      		if(type == 'image') {
				            var children = parent.children();
				            if($(children[1]).attr('src') != '') {
					            $(children[1]).show();
					        }
					    }
			      },
			      'onFallback':function()
			        {
			            alert("您的浏览器没有安装Flash");
			        },
			      'onUploadSuccess' : function (file, data, response) {
			          var result = $.parseJSON(data);
			          if(result.status == 0) {
			             alert(result.msg);
			          }else {
			            var parent = $(obj).parent();
			            //单张图片地址
			            if(type == 'image') {
				            var children = parent.children();
				            var path = result.msg.substr(1,result.msg.length);
				            $(children[1]).attr('src',path).show();
				            $(children[0]).val(path);
				        }
				        //视频和软件地址
				        if(type == 'video' || type == 'soft') {
				        	var input = parent.prev();
				            var path = result.msg.substr(1,result.msg.length);
				            $(input).val(path);
				        }
				        //图片列表
				        if(type == 'imglist') {
				        	var path = result.msg.substr(1,result.msg.length);
				        	var top = parent.parent();
				        	var img = '<div class="input-group img_list">\
									  		<img src="'+path+'" width="400">\
									  		<i class="close">X</i>\
									  	</div>';
							$(top).append(img);
							var input = parent.prev();
							var val = $(input).val();
							if(val == '') {
								$(input).val(path);
							}else {
								$(input).val(val + ';' + path);
							}
				        }
			          }
			      	}
			    });
			});
		},
		remove_img:function(obj) {
			var parent = $(obj).parent();
			var top = parent.parent();

			$(parent).remove();
			var img = $(top).find('img');
			var img_list = '';
			if(img) {
				if(img.length > 1) {
					for(var i in img) {
						img_list += $(img[i]).attr('src')+';';
					}
					img_list = img_list.substr(0,img_list.length - 1);
				}else {
					img_list = $(img).attr('src');
				}
			}
			//console.log(img_list);
			var input = top.find('input');
			$(input).val(img_list);
		}
	};

	return Upload;
});