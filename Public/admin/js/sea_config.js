seajs.config({
	alias: {
		'jquery':'js/jquery.min',
		'bootstrap':'js/bootstrap.min.js',
		'template':'js/template',
		'app':'admin/js/app',
		/*********************后台配置**********************/
		'menu':'admin/js/menu',
		'layer':'js/plugins/layer/layer.min',//弹层
		// 'beautifyhtml':'admin/js/plugins/beautifyhtml/beautifyhtml',//在线的格式化JavaScript
		// 'blueimp':'admin/js/plugins/blueimp/jquery.blueimp-gallery.min',//Bootstrap主题的jQuery相册插件
		// 'bootstrap-table':'admin/js/plugins/bootstrap-table/bootstrap-table.min',//bootstrap table简洁扁平的表格
		// 'chartJs':'admin/js/plugins/chartJs/Chart.min',//绘图,折线图、柱状图
		// 'chosen':'admin/js/plugins/chosen/chosen.jquery',//select下拉选择框美化
		// 'clockpicker':'admin/js/plugins/clockpicker/clockpicker',//时钟风格的时间选择器
		// 'codemirror':'admin/js/plugins/codemirror/codemirror',//在线代码编辑器
		'minicolors':'js/plugins/minicolors/jquery.minicolors',//颜色选择控件
		// 'cropper':'admin/js/plugins/cropper/cropper.min',//图片剪裁
		// 'datapicker':'admin/js/plugins/datapicker/bootstrap-datepicker',//日期选择器
		// 'dataTables':'admin/js/plugins/dataTables/codemirror',//
		'manage':'admin/js/manage',//后台管理
		'metisMenu':'js/plugins/metisMenu/jquery.metisMenu.js',//左侧菜单
		'slimscroll':'js/plugins/slimscroll/jquery.slimscroll.min.js',//虚拟滚动条
		'contabs':'admin/js/contabs.min.js',//TAB标签页
		'pace':'js/plugins/pace/pace.min.js',//加载进度条
		'validate':'js/plugins/validate/jquery.validate.min',//表单验证
		'messages_zh':'js/plugins/validate/messages_zh.min',//表单验证
		'content':'admin/js/content.min',
		'tableCheckbox':'js/plugins/tableCheckbox/jquery.tableCheckbox',//复选框选择
		'district':'js/plugins/district/district',//省市区三级联动
		'treeTable':'js/plugins/treeTable/jquery.treeTable',//树表组件
		'ueditor_config':'js/ueditor/ueditor.config',
		'ueditor_all':'js/ueditor/ueditor.all.min',
		'upload': 'admin/js/upload',

		'login':'admin/js/manage'//后台登录
	},
	debug: true,
	base: '/Public/',
	charset: 'utf-8',
	preload:['template','jquery']
});