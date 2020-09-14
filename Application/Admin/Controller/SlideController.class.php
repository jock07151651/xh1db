<?php
namespace Admin\Controller;
class SlideController extends BaseController {
	private $slidecate_mod;
	private $slide_mod;
	private $slidecate;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> slidecate_mod = M('slidecate');
		$this -> slide_mod = M('slide');
		$this -> slidecate = $this -> get_slide_cate();
		$this -> page_url = U('slide/index');
	} 
	public function index() {
		$count = $this -> slide_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$slide = $this -> slide_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('slide', $slide);
		$this -> assign('slidecate', $this -> slidecate);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> slide_mod -> create();
			if ($this -> slide_mod -> add($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$this -> assign('slidecate', $this -> slidecate);
		$this -> display();
	} 
	public function edit() {
		$id = $_REQUEST['id'];
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的幻灯片！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> slide_mod -> create();
			if ($this -> slide_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$this -> assign('slidecate', $this -> slidecate);
		$slide = $this -> slide_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('slide', $slide);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的幻灯片！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> slide_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function status() {
		$id = I('post.id');
		$status = I('post.status');
		if (empty($id) && empty($status)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的幻灯片！', 'url' => $this -> page_url));
		} 
		$this -> slide_mod -> where('id=' . (int)$id) -> save(array('status' => $status));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	private function get_slide_cate() {
		$slidecate = $this -> slidecate_mod -> order('id desc') -> select();
		return $slidecate;
	} 
} 
