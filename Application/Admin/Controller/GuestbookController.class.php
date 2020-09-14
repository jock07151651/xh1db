<?php
namespace Admin\Controller;
class GuestbookController extends BaseController {
	private $guestbook_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> guestbook_mod = M('guestbook');
		$this -> page_url = U('guestbook/index');
	} 
	public function index() {
		$count = $this -> guestbook_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$guestbook = $this -> guestbook_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('guestbook', $guestbook);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> error('');
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的留言！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> guestbook_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function status() {
		$id = I('post.id');
		$status = I('post.status');
		if (empty($id) && empty($status)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的留言！', 'url' => $this -> page_url));
		} 
		$this -> guestbook_mod -> where('id=' . (int)$id) -> save(array('status' => $status));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
