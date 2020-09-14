<?php
namespace Admin\Controller;
class TagController extends BaseController {
	private $tag_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> tag_mod = M('tag');
		$this -> page_url = U('tag/index');
	} 
	public function index() {
		$count = $this -> tag_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$tag = $this -> tag_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('list_sort asc,id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('tag', $tag);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> tag_mod -> create();
			if ($this -> tag_mod -> add($data)) {
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
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的标签！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> tag_mod -> create();
			if ($this -> tag_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$tag = $this -> tag_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('tag', $tag);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的标签！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> tag_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function status() {
		$id = I('post.id');
		$status = I('post.status');
		if (empty($id) && empty($status)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的标签！', 'url' => $this -> page_url));
		} 
		$this -> tag_mod -> where('id=' . (int)$id) -> save(array('status' => $status));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function sort() {
		$id = I('post.id');
		$list_sort = I('post.sort');
		if (empty($id) && empty($list_sort)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的标签！', 'url' => $this -> page_url));
		} 
		$this -> tag_mod -> where('id=' . (int)$id) -> save(array('list_sort' => $list_sort));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
