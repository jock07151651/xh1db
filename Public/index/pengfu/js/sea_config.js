seajs.config({
	alias: {
		'jquery':'js/jquery-1.11.1.min',
		'ueditor_config': 'js/ueditor/ueditor.config',
		'ueditor': 'js/ueditor/ueditor.all.min',
		'uploadfile' : 'js/jquery.uploadfile.min',
		'template':'js/template',
		'validform':'js/validform.min',
		'slide':'js/plugins/slide/js/slide.min',
		'city':'js/city-choose',
		'md5':'js/jquery.md5',
		'validform_css':'index/css/validform.css',
		'page':'js/jquery.pagination',
		'app':'index/xxhh/js/app',
		'user':'index/xxhh/js/user',
		'shop':'index/xxhh/js/shop',
		'share' : 'index/xxhh/js/share'
	},
	debug: true,
	base: '/Public/',
	charset: 'utf-8',
	preload:['jquery']
});