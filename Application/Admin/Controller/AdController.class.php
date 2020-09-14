<?php
namespace Admin\Controller;
class AdController extends BaseController {
	private $ad_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> ad_mod = M('adv');
		$this -> page_url = U('ad/index');
	} 
	public function index() {
		$count = $this -> ad_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$ad = $this -> ad_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('ad', $ad);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> ad_mod -> create();
			if ($this -> ad_mod -> add($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$this -> display();
	} 
	public function edit() {
		$id = $_REQUEST['id'];
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的广告！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> ad_mod -> create();
			if ($this -> ad_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$ad = $this -> ad_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('ad', $ad);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的广告！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> ad_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
