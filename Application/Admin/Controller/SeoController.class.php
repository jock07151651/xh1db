<?php
namespace Admin\Controller;
class SeoController extends BaseController {
	private $seo_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> seo_mod = M('seo');
		$this -> page_url = U('mailtpl/index');
	} 
	public function index() {
		$count = $this -> seo_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$list = $this -> seo_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('list', $list);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> seo_mod -> create();
			if ($this -> seo_mod -> add($data)) {
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
			$data = $this -> seo_mod -> create();
			if ($this -> seo_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$seo_info = $this -> seo_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('seo_info', $seo_info);
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
		$this -> seo_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
