<?php
namespace Admin\Controller;
class LinksController extends BaseController {
	private $links_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> links_mod = M('flink');
		$this -> page_url = U('links/index');
	} 
	public function index() {
		$count = $this -> links_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$links = $this -> links_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('ordid asc,id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('links', $links);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> links_mod -> create();
			if ($this -> links_mod -> add($data)) {
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
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的链接！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> links_mod -> create();
			if ($this -> links_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$links = $this -> links_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('links', $links);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的链接！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> links_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function status() {
		$id = I('post.id');
		$status = I('post.status');
		if (empty($id) && empty($status)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的链接！', 'url' => $this -> page_url));
		} 
		$this -> links_mod -> where('id=' . (int)$id) -> save(array('status' => $status));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function sort() {
		$id = I('post.id');
		$list_sort = I('post.sort');
		if (empty($id) && empty($list_sort)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的链接！', 'url' => $this -> page_url));
		} 
		$this -> links_mod -> where('id=' . (int)$id) -> save(array('list_sort' => $list_sort));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
