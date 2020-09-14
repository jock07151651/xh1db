<?php
namespace Admin\Controller;
class SlidecateController extends BaseController {
	private $slidecate_mod;
	private $slide_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> slidecate_mod = M('slidecate');
		$this -> slide_mod = M('slide');
		$this -> page_url = U('slidecate/index');
	} 
	public function index() {
		$count = $this -> slidecate_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$slidecate = $this -> slidecate_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('slidecate', $slidecate);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> slidecate_mod -> create();
			if ($this -> slidecate_mod -> add($data)) {
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
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的分类！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> slidecate_mod -> create();
			if ($this -> slidecate_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$slidecate = $this -> slidecate_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('slidecate', $slidecate);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的分类！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> slidecate_mod -> delete($id);
		$this -> slide_mod -> where('cid in (' . $id . ')') -> delete();
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
