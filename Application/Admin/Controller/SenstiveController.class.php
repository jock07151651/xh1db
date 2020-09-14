<?php
namespace Admin\Controller;
class SenstiveController extends BaseController {
	private $senstive_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> senstive_mod = M('senstive');
		$this -> page_url = U('senstive/index');
	} 
	public function index() {
		$count = $this -> senstive_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$senstive = $this -> senstive_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('senstive', $senstive);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> senstive_mod -> create();
			if ($this -> senstive_mod -> add($data)) {
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
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的敏感词！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> senstive_mod -> create();
			if ($this -> senstive_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$senstive = $this -> senstive_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('senstive', $senstive);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的敏感词！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> senstive_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
