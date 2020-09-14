<?php
namespace Admin\Controller;
class CacheController extends BaseController {
	private $page_url;
	public function index() {
		$this -> display();
	} 
	public function clear() {
		$this -> delete_dir(CACHE_PATH);
		$this -> delete_dir('./Wap/Runtime/Cache/');
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!'));
	} 
} 
