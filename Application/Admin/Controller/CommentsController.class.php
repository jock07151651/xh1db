<?php
namespace Admin\Controller;
class CommentsController extends BaseController {
	private $comments_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> comments_mod = M('user_review');
		$this -> page_url = U('comments/index');
	} 
	public function index() {
		$count = $this -> comments_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$comments = $this -> comments_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		foreach ($comments as $key => $value) {
			$user = D('user') -> where('id=' . $value['user_id']) -> find();
			$comments[$key]['user_info'] = $user;
		} 
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('comments', $comments);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的评论！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> comments_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function multi_status() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要操作的评论！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> comments_mod -> where('id in (' . $id . ')') -> save(array('status' => 2));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function status() {
		$id = I('post.id');
		$status = I('post.status');
		if (empty($id) && empty($status)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的评论！', 'url' => $this -> page_url));
		} 
		$this -> comments_mod -> where('id=' . (int)$id) -> save(array('status' => $status));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
} 
