<?php
namespace Admin\Controller;
class TagsController extends BaseController {
	private $tags_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> tags_mod = M('tags');
		$this -> page_url = U('mailtpl/index');
	} 
	public function index() {
		$count = $this -> tags_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$list = $this -> tags_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('list', $list);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> tags_mod -> create();
			$data['type'] = $this -> type;
			$data['created_time'] = time();
			$data['content'] = htmlspecialchars($data['content']);
			if ($this -> tags_mod -> add($data)) {
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
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的内容！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> tags_mod -> create();
			if ($this -> tags_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$list = $this -> tags_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('list', $list);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的模板！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> tags_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function status() {
		$id = I('post.id');
		$status = I('post.status');
		if (empty($id) && empty($status)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的模板！', 'url' => $this -> page_url));
		} 
		$this -> tags_mod -> where('id=' . (int)$id) -> save(array('status' => $status));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 