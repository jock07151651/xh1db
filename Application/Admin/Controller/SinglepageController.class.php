<?php
namespace Admin\Controller;
class SinglepageController extends BaseController {
	private $singlepage_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> singlepage_mod = M('singlepage');
		$this -> page_url = U('singlepage/index');
	} 
	public function index() {
		$count = $this -> singlepage_mod -> count();
		$page = new \Think\Page($count, $this -> singlepagesize);
		$singlepage = $this -> singlepage_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('singlepage', $singlepage);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> singlepage_mod -> create();
			if ($this -> singlepage_mod -> add($data)) {
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
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的页面！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> singlepage_mod -> create();
			if ($this -> singlepage_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$singlepage = $this -> singlepage_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('singlepage', $singlepage);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的页面！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> singlepage_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function status() {
		$id = I('post.id');
		$status = I('post.status');
		if (empty($id) && empty($status)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的页面！', 'url' => $this -> page_url));
		} 
		$this -> singlepage_mod -> where('id=' . (int)$id) -> save(array('status' => $status));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
