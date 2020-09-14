<?php
namespace Admin\Controller;
class LevelController extends BaseController {
	private $tpl_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> level_mod = M('level');
		$this -> page_url = U('level/index');
	} 
	public function index() {
		$count = $this -> level_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$list = $this -> level_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('level desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('list', $list);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> level_mod -> create();
			$data['type'] = $this -> type;
			$data['created_time'] = time();
			$data['content'] = htmlspecialchars($data['content']);
			if ($this -> level_mod -> add($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$this -> display();
	} 
	public function edit() {
		if (IS_POST) {
			$level_mod = D('level');
			$data = $level_mod -> create();
			$result = $level_mod -> where("level=" . $data['level']) -> save($data);
			if (false !== $result) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
		} else {
			$level_mod = D('level');
			if (isset($_GET['level'])) {
				$level = isset($_GET['level']) && intval($_GET['level'])? intval($_GET['level']): $this -> error('请选择要编辑的链接');
			} 
			$level_info = $level_mod -> where('level=' . $level) -> find();
			$this -> assign('level_info', $level_info);
			$this -> assign('show_header', false);
			$this -> display();
		} 
	} 
	public function delete() {
		$id = I('get.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的内容！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> level_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
