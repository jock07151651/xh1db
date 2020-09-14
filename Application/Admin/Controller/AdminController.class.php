<?php
namespace Admin\Controller;
class AdminController extends BaseController {
	private $admin_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> admin_mod = M('admin');
		$this -> page_url = U('admin/index');
	} 
	public function index() {
		$count = $this -> admin_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$admin = $this -> admin_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('admin', $admin);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> admin_mod -> create();
			$username = $data['username'];
			if ($this -> checkname($username)) {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '管理员名称已存在！', 'url' => $this -> page_url));
			} 
			$data['password'] = md5($data['password']);
			$time = time();
			$data['add_time'] = $time;
			$data['last_time'] = $time;
			$data['status'] = 1;
			if ($this -> admin_mod -> add($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$this -> assign('role', $this -> get_role());
		$this -> display();
	} 
	public function edit() {
		$id = $_REQUEST['id'];
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的管理员！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> admin_mod -> create();
			$username = $data['username'];
			if ($this -> checkname($username, $data['id'])) {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '管理员名称已存在！', 'url' => $this -> page_url));
			} 
			if (trim($_POST['password']) == '') {
				unset($data['password']);
			} else {
				$data['password'] = md5($data['password']);
			} 
			if ($this -> admin_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$admin = $this -> admin_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('admin', $admin);
		$this -> assign('role', $this -> get_role());
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的管理员！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> admin_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	private function checkname($username, $id = 0) {
		$where = 'username="' . $username . '"';
		if ($id > 0) {
			$where .= ' and id <>' . $id;
		} 
		$admin = $this -> admin_mod -> where($where) -> find();
		if ($admin)return true;
		return false;
	} 
	private function get_role() {
		$role = M('role') -> order('id asc') -> select();
		return $role;
	} 
} 
