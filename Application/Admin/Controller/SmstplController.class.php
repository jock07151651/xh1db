<?php
namespace Admin\Controller;
class SmstplController extends BaseController {
	private $tpl_mod;
	private $type = 2;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> tpl_mod = M('tpl');
		$this -> page_url = U('smstpl/index');
	} 
	public function index() {
		$where = 'type=' . $this -> type;
		$count = $this -> tpl_mod -> where($where) -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$tpl = $this -> tpl_mod -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('tpl', $tpl);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> tpl_mod -> create();
			$data['type'] = $this -> type;
			$data['created_time'] = time();
			if ($this -> tpl_mod -> add($data)) {
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
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的模板！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> tpl_mod -> create();
			if ($this -> tpl_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$smstpl = $this -> tpl_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('smstpl', $smstpl);
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
		$this -> tpl_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function status() {
		$id = I('post.id');
		$status = I('post.status');
		if (empty($id) && empty($status)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的模板！', 'url' => $this -> page_url));
		} 
		$this -> tpl_mod -> where('id=' . (int)$id) -> save(array('status' => $status));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
