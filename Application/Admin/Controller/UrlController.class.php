<?php
namespace Admin\Controller;
class UrlController extends BaseController {
	private $url_mod;
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> url_mod = M('url');
		$this -> page_url = U('url/index');
	} 
	public function index() {
		$count = $this -> url_mod -> count();
		$page = new \Think\Page($count, $this -> pagesize);
		$url = $this -> url_mod -> limit($page -> firstRow . ',' . $page -> listRows) -> order('id desc') -> select();
		$page_str = $page -> show();
		$this -> assign('page', $page_str);
		$this -> assign('url', $url);
		$this -> display();
	} 
	public function add() {
		if (IS_POST) {
			$data = $this -> url_mod -> create();
			if ($this -> url_mod -> add($data)) {
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
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要编辑的url！', 'url' => $this -> page_url));
		} 
		if (IS_POST) {
			$data = $this -> url_mod -> create();
			if ($this -> url_mod -> save($data)) {
				$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
			} 
			exit;
		} 
		$url = $this -> url_mod -> where('id=' . (int)$id) -> find();
		$this -> assign('url', $url);
		$this -> display();
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的url！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		$this -> url_mod -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function status() {
		$id = I('post.id');
		$status = I('post.status');
		if (empty($id) && empty($status)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要设置的url！', 'url' => $this -> page_url));
		} 
		$this -> url_mod -> where('id=' . (int)$id) -> save(array('status' => $status));
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function create_url() {
		$url = $this -> url_mod -> where('status=1') -> order('id desc') -> select();
		$path = DATA_PATH . 'conf/route.php';
		$rule = "<?php ";
		$rule .= "		return array(";
		foreach ($url as $key => $value) {
			$rule .= "				'" . $value['source_url'] . "' => '" . $value['target_url'] . "',";
		} 
		$rule .= "				);";
		if ($this -> write_file($path, $rule)) {
			$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
		} 
		$this -> ajaxReturn(array('status' => 0, 'msg' => '操作失败！', 'url' => $this -> page_url));
	} 
} 
