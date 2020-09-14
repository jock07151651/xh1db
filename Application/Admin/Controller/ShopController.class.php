<?php
namespace Admin\Controller;
class ShopController extends BaseController {
	private $shop_mod;
	private $shopcate_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> shop_mod = M('shop_gift');
		$this -> page_url = U('shop/index');
	} 
	public function cate() {
		$list = M('shop_cate') -> order('id desc') -> select();
		$this -> assign('list', $list);
		$this -> display();
	} 
	public function order() {
		$list = M('user_gift') -> order('id desc') -> select();
		foreach ($list as $key => $value) {
			$list[$key]['gift_info'] = json_decode($value['gift_info'], true);
			$user = D('user') -> where('id=' . $value['user_id']) -> find();
			$list[$key]['user_info'] = $user;
		} 
		$this -> assign('list', $list);
		$this -> display();
	} 
	public function index() {
		$gift_mod = D('shop_gift');
		$count = $gift_mod -> count();
		$p = new \Think\Page($count, 20);
		$gift_list = $gift_mod -> limit($p -> firstRow . ',' . $p -> listRows) -> order('id desc') -> select();
		$gift_cate_mod = D('shop_cate');
		foreach ($gift_list as $key => $value) {
			$gift_cate = $gift_cate_mod -> where('id=' . $value['cate_id']) -> find();
			$gift_list[$key]['cate_name'] = $gift_cate['name'];
		} 
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=gift&a=add\', title:\'' . '添加礼品' . '\', width:\'700\', height:\'700\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', '添加礼品');
		$page = $p -> show();
		$this -> assign('page', $page);
		$this -> assign('big_menu', $big_menu);
		$this -> assign('gift_list', $gift_list);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$gift_mod = D('shop_gift');
			$data = array();
			$title = isset($_POST['title']) && trim($_POST['title'])? trim($_POST['title']): $this -> error('名称不能为空');
			$description = isset($_POST['description']) && trim($_POST['description'])? trim($_POST['description']): $this -> error('描述不能为空');
			$data = $gift_mod -> create();
			if ($gift_mod -> add($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
		} else {
			$this -> assign('cate', $this -> get_cate());
			$this -> assign('show_header', false);
			$this -> display();
		} 
	} 
	public function cateadd() {
		if (IS_POST) {
			$data = M('shop_cate') -> create();
			if (M('shop_cate') -> add($data)) {
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
			$gift_mod = D('shop_gift');
			$data = $gift_mod -> create();
			$result = $gift_mod -> where("id=" . $data['id']) -> save($data);
			if (false !== $result) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
		} else {
			$gift_mod = D('shop_gift');
			if (isset($_GET['id'])) {
				$id = isset($_GET['id']) && intval($_GET['id'])? intval($_GET['id']): $this -> error('请选择要编辑的礼品');
			} 
			$this -> assign('cate', $this -> get_cate());
			$gift_info = $gift_mod -> where('id=' . $id) -> find();
			$this -> assign('gift_info', $gift_info);
			$this -> assign('show_header', false);
			$this -> display();
		} 
	} 
	public function cateedit() {
		$id = $_REQUEST['id'];
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的内容！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = M('shop_cate') -> create();
			if (M('shop_cate') -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$list = M('shop_cate') -> where('id=' . (int)$id) -> find();
		$this -> assign('list', $list);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的内容！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> shop_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function catedelete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的内容！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		D('shop_cate') -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function processorder() {
		if (D('user_gift') -> where('id=' . (int)$_GET['id'] . ' and status=0') -> save(array('status' => 1))) {
			$this -> ajaxReturn(array('err' => 1, 'msg' => '操作成功!'));
		} 
	} 
	private function get_cate() {
		$gift_cate = D('shop_cate') -> order('sort asc') -> select();
		return $gift_cate;
	} 
} 
