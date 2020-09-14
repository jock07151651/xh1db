<?php
namespace Admin\Controller;
class NavController extends BaseController {
	private $nav_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> nav_mod = M('nav');
		$this -> page_url = U('nav/index');
	} 
	public function index() {
		$count = $this -> nav_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$nav = $this -> nav_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('list_sort asc,pid asc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('nav', $nav);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> nav_mod -> create();
			if ($this -> nav_mod -> add($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$pid = isset($_GET['pid'])? (int)$_GET['pid'] : 0;
		$this -> assign('pid', $pid);
		$nav_list = $this -> nav_mod -> order('list_sort asc,pid asc') -> select();
		$nav_list = $this -> process_cate($nav_list);
		$this -> assign('nav_list', $nav_list);
		$this -> display();
	} 
	public function edit() {
		$id = $_REQUEST['id'];
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的导航！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> nav_mod -> create();
			if ($this -> nav_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$nav = $this -> nav_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('nav', $nav);
		$nav_list = $this -> nav_mod -> order('list_sort asc,pid asc') -> select();
		$nav_list = $this -> process_cate($nav_list);
		$this -> assign('nav_list', $nav_list);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的导航！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> delete_nav($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function status() {
		$id = I('post.id');
		$status = I('post.status');
		if (empty($id) && empty($status)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的导航！', 'url' => $this -> page_url));
		} 
		$this -> nav_mod -> where('id=' . (int)$id) -> save(array('status' => $status));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function sort() {
		$id = I('post.id');
		$list_sort = I('post.sort');
		if (empty($id) && empty($list_sort)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的导航！', 'url' => $this -> page_url));
		} 
		$this -> nav_mod -> where('id=' . (int)$id) -> save(array('list_sort' => $list_sort));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	private function delete_nav($id) {
		$sub = $this -> nav_mod -> where('pid in (' . $id . ')') -> order('id asc') -> select();
		foreach ($sub as $key => $value) {
			$this -> delete_nav($value['id']);
		} 
		$this -> nav_mod -> where('id in (' . $id . ') or pid in(' . $id . ')') -> delete();
	} 
} 
