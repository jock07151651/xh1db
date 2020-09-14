<?php
namespace Admin\Controller;
class UserController extends BaseController {
	private $user_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> user_mod = M('user');
		$this -> page_url = U('user/index');
	} 
	public function index() {
		$count = $this -> user_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$user = $this -> user_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('user', $user);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> user_mod -> create();
			$time = time();
			$data['password'] = $this -> substr_pwd($data['password']);
			$data['created_time'] = $time;
			$data['last_login_time'] = $time;
			$data['register_ip'] = '127.0.0.1';
			$data['last_login_ip'] = '127.0.0.1';
			if ($this -> user_mod -> add($data)) {
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

			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的用户！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> user_mod -> create();
			if (trim($_POST['password']) != '') {
				$data['password'] = $this -> substr_pwd($_POST['password']);
			} 
			if ($this -> user_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$user = $this -> user_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('user', $user);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的用户！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> user_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function status() {
		$id = I('post.id');
		$status = I('post.status');
		if (empty($id) && empty($status)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的用户！', 'url' => $this -> page_url));
		} 
		$this -> user_mod -> where('id=' . (int)$id) -> save(array('status' => $status));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
