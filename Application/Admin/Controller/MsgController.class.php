<?php
namespace Admin\Controller;
class MsgController extends BaseController {
	private $msg_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> msg_mod = M('msg');
		$this -> page_url = U('msg/index');
	} 
	public function index() {
		$where = '1=1';
		if (isset($_POST['keywords'])) {
			$keywords = trim($_POST["keywords"]);
			$where .= ' and (phone like "%' . $keywords . '%" or content like "%' . $keywords . '%")';
		} 
		$count = $this -> msg_mod -> where($where) -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$msg = $this -> msg_mod -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('msg', $msg);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的短信记录！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> msg_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
