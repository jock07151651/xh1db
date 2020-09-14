<?php
/**
 *项目公共配置
 **/
$db = require('./Data/conf/db.php');
$tp = require('./Data/conf/config.php');
$mail = require('./Data/conf/mail.php');

$config = array(
    //'配置项'=>'配置值'
	'LOAD_EXT_CONFIG' 		=> 'tags',
	/*路由设置*/
	'URL_MODEL' 			=> 0,				//URL访问模式
	'URL_ROUTER_ON'   		=> false, 			//开启路由
	'URL_HTML_SUFFIX'		=>'html',			//伪静态后缀

	'DEFAULT_CONTROLLER'   	=>  'Public', // 默认控制器名称
	'DEFAULT_ACTION'        	=>  'login', // 默认操作名称
	'HOME_PATH'			=>'./Application/Home/View/',

	'TMPL_ACTION_ERROR'     	=>  '/Common/dispatch_jump', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   	=>  '/Common/dispatch_jump', // 默认成功跳转对应的模板文件
	/*'TMPL_ACTION_ERROR'     	=>  APP_PATH.'Admin/View/Common/dispatch_jump', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   	=>  APP_PATH.'Admin/View/Common/dispatch_jump', // 默认成功跳转对应的模板文件*/
	//表单令牌
	'TOKEN_ON'      		=>    true,  // 是否开启令牌验证 默认关闭
	'TOKEN_NAME'    		=>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
	'TOKEN_TYPE'    		=>    'md5',  //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'   		=>    true,  //令牌验证出错后是否重置令牌 默认为true
);
return array_merge($db,$tp,$mail,$config);
