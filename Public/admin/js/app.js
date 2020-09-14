define(function(require, exports, module) {
	var layer = require('layer');
	var App = {
		is_last:false,
		last_page:'',
		load_page:function(url) {
			if(url.indexOf('a=index') > -1) {
				App.is_last = true;
				App.last_page = url;
			}
			$.ajax({
				url:url,
				async:false,
				success:function(data) {
					$('#content-main').html(data);
				}
			});
		},
		exe_page:function(url) {
			layer.open({
		        content: '您确认要执行此操作吗',
		        btn: ['确认', '取消'],
		        shadeClose: false,
		        yes: function(){
	          		$.ajax({
						url:url,
						async:false,
						success:function(data) {
							layer.msg(data.msg, {icon: data.status,skin:"layui-layer-hui"});
							//App.load_page(App.last_page);
							App.load_page(data.url);
						}
					});
		        }, no: function(){
		            return false;
		        }
		    });
		},
		submit_form:function(that) {
			var form = that.closest('form');
			var url = form.attr('submit-url');
			var params = form.serializeObject();
			form.validate({
				submitHandler:function(form) {
					$.post(url,params,function(data) {
						layer.msg(data.msg, {icon:data.status,skin:"layui-layer-hui"});
						App.load_page(data.url);
						//App.load_page(App.last_page);
					},'json');
        		}
			});
		},
		search_form:function(that) {
			var form = that.closest('form');
			var url = form.attr('submit-url');
			var params = form.serializeObject();
			$.post(url,params,function(data) {
				$('#content-main').html(data);
			});
		},
		/*
		*单一删除
		*/
		del:function(that) {
			var url = that.data().url;
			var id = that.data().id;
			layer.open({
		        content: '您确认要删除吗',
		        btn: ['确认', '取消'],
		        shadeClose: false,
		        yes: function(){
		          $.post(url,{id:id},function(data) {
								layer.msg(data.msg, {icon: 1,skin:"layui-layer-hui"});
								App.load_page(data.url);
								//App.load_page(App.last_page);
								return true;
							},'json');
		        }, no: function(){
		            return false;
		        }
		    });
		},
		/*
		*全选审核通过
		*/
		del_select:function(that) {
			var form = that.closest('form');
			var url = form.attr('submit-url');
			var id = $(form).find('input[name="id[]"]:checked');

			if(id.length <= 0) {
				layer.msg('请选择数据！',{skin:"layui-layer-hui"});
			}else {
				var ids = [];
				for(var i= 0; i < id.length; i++) {
					ids[i] = $(id[i]).val();
				}
				$.post(url,{id:ids},function(data) {
					layer.msg(data.msg,{skin:"layui-layer-hui"});
					App.load_page(data.url);
					//App.load_page(App.last_page);
				},'json');
			}
		},

		/*
		*全选删除
		*/
		adopt_select:function(that) {
			var form = that.closest('form');			
			var id = $(form).find('input[name="id[]"]:checked');

			if(id.length <= 0) {
				layer.msg('请选择数据！',{skin:"layui-layer-hui"});
			}else {
				var ids = [];
				for(var i= 0; i < id.length; i++) {
					ids[i] = $(id[i]).val();
				}
				$.post('/index.php?m=admin&c=xiaohua&a=audit_joke',{id:ids},function(data) {
					layer.msg(data.msg,{skin:"layui-layer-hui"});
					App.load_page(data.url);
					//App.load_page(App.last_page);
				},'json');
			}
		},
		comments_select:function(that) {
			var form = that.closest('form');			
			var id = $(form).find('input[name="id[]"]:checked');

			if(id.length <= 0) {
				layer.msg('请选择数据！',{skin:"layui-layer-hui"});
			}else {
				var ids = [];
				for(var i= 0; i < id.length; i++) {
					ids[i] = $(id[i]).val();
				}
				$.post('/index.php?m=admin&c=comments&a=multi_status',{id:ids},function(data) {
					layer.msg(data.msg,{skin:"layui-layer-hui"});
					App.load_page(data.url);
					//App.load_page(App.last_page);
				},'json');
			}
		},
		/*
		*状态
		*/
		status:function(that) {
			var url = that.data().url;
			var id = that.data().id;
			var status = that.data().status;
			$.post(url,{id:id,status:status},function(data) {
				layer.msg(data.msg,{skin:"layui-layer-hui"});
				App.load_page(data.url);
				//App.load_page(App.last_page);
				return true;
			},'json');
		},
		/*
		*排序
		*/
		sort:function(that) {
			var url = that.data().url;
			var id = that.data().id;
			var sort = that.val();
			$.post(url,{id:id,sort:sort},function(data) {
				layer.msg(data.msg, {icon: data.status,skin:"layui-layer-hui"});
				App.load_page(data.url);
				//App.load_page(App.last_page);
				return true;
			},'json');
		},
		/*
		*是否首页显示
		*/
		is_index:function(that) {
			var url = that.data().url;
			var id = that.data().id;
			var is_index = that.data().isindex;
			$.post(url,{id:id,is_index:is_index},function(data) {
				//App.tip(data.is_index,data.msg);
				layer.msg(data.msg, {skin:"layui-layer-hui"});
				return true;
			},'json');
		},
		/*
		*是否常见疾病
		*/
		is_common:function(that) {
			var url = that.data().url;
			var id = that.data().id;
			var iscommon = that.data().iscommon;
			$.post(url,{id:id,is_common:iscommon},function(data) {
				//App.tip(data.is_index,data.msg);
				layer.msg(data.msg, {skin:"layui-layer-hui"});
				return true;
			},'json');
		},
		/*
		*是否热门搜索
		*/
		is_hot:function(that) {
			var url = that.data().url;
			var id = that.data().id;
			var ishot = that.data().ishot;
			$.post(url,{id:id,is_common:ishot},function(data) {
				//App.tip(data.is_index,data.msg);
				layer.msg(data.msg, {skin:"layui-layer-hui"});
				return true;
			},'json');
		},
		create_url:function(that) {
			var url = that.data().url;
			$.post(url,{},function(data) {
				layer.msg(data.msg, {icon: data.status,skin:"layui-layer-hui"});
				App.load_page(data.url);
			},'json');
		},
		/*
		*提示信息
		*/
		tip:function(status,msg,url) {
			var c = status == 1 ? 'alert-success' : 'alert-danger';
			var tpl = $('<div class="Pop_tips_shade"></div><div class="Pop_tips '+ c +'"><div class="info">' + msg + '</div></div>');
			tpl.appendTo('#content-main');
			setTimeout(function() {
				if(url) {
					App.load_page(url);
				}else {
				 	tpl.remove();
				}
			},1000);
		},
		cache_clear:function(that) {
			var url = that.data().url;
			layer.open({
		        content: '您确认要清除缓存吗?',
		        btn: ['确认', '取消'],
		        shadeClose: false,
		        yes: function(){
	          		$.ajax({
						url:url,
						async:false,
						success:function(data) {
							layer.msg(data.msg, {icon: data.status,skin:"layui-layer-hui"});
						}
					});
		        }, no: function(){
		            return false;
		        }
		    });
		}
	};

	// jq
	$.fn.serializeObject = function() {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function() {
			if (o[this.name]) {
				if (!o[this.name].push) {
					o[this.name] = [ o[this.name] ];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
	};

	//按钮操作事件
	$(document).on('click','a[data-action]',function() {
		var fun = $(this).attr('data-action');
		var f = eval(fun);
		f($(this));
	});

	//表单操作事件
	$(document).on('click','button[data-form-action]',function() {
		var fun = $(this).attr('data-form-action');
		var f = eval(fun);
		f($(this));
	});

	//文本框onblur操作事件
	$(document).on('blur','input[blur-action]',function() {
		var fun = $(this).attr('blur-action');
		var f = eval(fun);
		f($(this));
	});

	return App;
});