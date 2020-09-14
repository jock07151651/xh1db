<?php
namespace Admin\Controller;
class XiaohuaController extends BaseController {
	private $page_url;
	protected function _initialize() {
		parent :: _initialize();
		$this -> page_url = U('xiaohua/unaudit');
	} 
	public function unaudit() {
		$where = 'status=1';
		if (isset($_GET['time_start']) && trim($_GET['time_start'])) {
			$time_start = strtotime($_GET['time_start']);
			$where .= " AND created_time>='" . $time_start . "'";
			$this -> assign('time_start', $_GET['time_start']);
		} 
		if (isset($_GET['time_end']) && trim($_GET['time_end'])) {
			$time_end = strtotime($_GET['time_end']);
			$where .= " AND created_time<='" . $time_end . "'";
			$this -> assign('time_end', $_GET['time_end']);
		} 
		$joke_mod = D('user_joke');
		$count = $joke_mod -> where($where) -> count();
		$p = new \Think\Page($count, 20);
		$joke_list = $joke_mod -> where($where) -> limit($p -> firstRow . ',' . $p -> listRows) -> order('id desc') -> select();
		foreach ($joke_list as $key => $value) {
			$user = D('user') -> where('id=' . $value['user_id']) -> find();
			$joke_list[$key]['user_info'] = $user;
		} 
		$page = $p -> show();
		$this -> assign('page', $page);
		$this -> assign('joke_list', $joke_list);
		$this -> display();
	} 
	public function audit() {
		$where = 'status=2';
		if (isset($_GET['title']) && trim($_GET['title'])) {
			$where .= " AND title like '%" . $_GET['title'] . "%'";
			$this -> assign('title', $_GET['title']);
		} 
		$this -> assign('commend', 'all');
		if (isset($_GET['commend']) && $_GET['commend'] != 'all') {
			$where .= " AND commend = '" . $_GET['commend'] . "'" ;
			$this -> assign('commend', $_GET['commend']);
		} 
		$this -> assign('type', 'all');
		if (isset($_GET['type']) && $_GET['type'] != 'all') {
			$where .= " AND type = '" . $_GET['type'] . "'" ;
			$this -> assign('type', $_GET['type']);
		} 
		$joke_mod = D('user_joke');
		$count = $joke_mod -> where($where) -> count();
		$p = new \Think\Page($count, 20);
		$joke_list = $joke_mod -> where($where) -> limit($p -> firstRow . ',' . $p -> listRows) -> order('audit_time desc') -> select();
		foreach ($joke_list as $key => $value) {
			$user = D('user') -> where('id=' . $value['user_id']) -> find();
			$joke_list[$key]['user_info'] = $user;
			$tags_id = str_replace('|', ',', $value['tags_id']);
			$tags_id = substr($tags_id, 1, strlen($tags_id) - 2);
			if ($tags_id) {
				$tags = D('tags') -> where('id in(' . $tags_id . ')') -> select();
			} 
			$joke_list[$key]['tags'] = $tags;
		} 
		$page = $p -> show();
		$this -> assign('page', $page);
		$this -> assign('joke_list', $joke_list);
		$this -> display();
	} 
	public function auditing() {
		$where = 'status=1 and audit_num < 10';
		if (isset($_GET['time_start']) && trim($_GET['time_start'])) {
			$time_start = strtotime($_GET['time_start']);
			$where .= " AND created_time>='" . $time_start . "'";
			$this -> assign('time_start', $_GET['time_start']);
		} 
		if (isset($_GET['time_end']) && trim($_GET['time_end'])) {
			$time_end = strtotime($_GET['time_end']);
			$where .= " AND created_time<='" . $time_end . "'";
			$this -> assign('time_end', $_GET['time_end']);
		} 
		$joke_mod = D('user_joke');
		$count = $joke_mod -> where($where) -> count();
		$p = new \Think\Page($count, 20);
		$joke_list = $joke_mod -> where($where) -> limit($p -> firstRow . ',' . $p -> listRows) -> order('id desc') -> select();
		foreach ($joke_list as $key => $value) {
			$user = D('user') -> where('id=' . $value['user_id']) -> find();
			$joke_list[$key]['user_info'] = $user;
		} 
		$page = $p -> show();
		$this -> assign('page', $page);
		$this -> assign('joke_list', $joke_list);
		$this -> display();
	} 
	public function failed() {
		$where = 'status=3';
		if (isset($_GET['time_start']) && trim($_GET['time_start'])) {
			$time_start = strtotime($_GET['time_start']);
			$where .= " AND created_time>='" . $time_start . "'";
			$this -> assign('time_start', $_GET['time_start']);
		} 
		if (isset($_GET['time_end']) && trim($_GET['time_end'])) {
			$time_end = strtotime($_GET['time_end']);
			$where .= " AND created_time<='" . $time_end . "'";
			$this -> assign('time_end', $_GET['time_end']);
		} 
		$joke_mod = D('user_joke');
		$count = $joke_mod -> where($where) -> count();
		$p = new \Think\Page($count, 20);
		$joke_list = $joke_mod -> where($where) -> limit($p -> firstRow . ',' . $p -> listRows) -> order('id desc') -> select();
		foreach ($joke_list as $key => $value) {
			$user = D('user') -> where('id=' . $value['user_id']) -> find();
			$joke_list[$key]['user_info'] = $user;
		} 
		$page = $p -> show();
		$this -> assign('page', $page);
		$this -> assign('joke_list', $joke_list);
		$this -> display();
	} 
	public function show() {
		if (isset($_GET['id'])) {
			$id = isset($_GET['id']) && intval($_GET['id'])? intval($_GET['id']): $this -> error('参数错误');
		} 
		$user_joke = D('user_joke') -> where('id=' . $id) -> find();
		$user = D('user') -> where('id=' . $user_joke['user_id']) -> find();
		$user_joke['user_info'] = $user;
		if ($user_joke['is_package'] == 1 && $user_joke['package_user_id'] > 0) {
			$user = D('user') -> where('id=' . $user_joke['package_user_id']) -> find();
			$user_joke['package_user_info'] = $user;
		} 
		$this -> assign('user_joke', $user_joke);
		$this -> display();
	} 
	public function audit_joke() {
		$joke_mod = D('user_joke');
		if (IS_POST) {
			$ids = $_POST['id'];
			foreach ($ids as $key => $value) {
				$result = $joke_mod -> where("id=" . $value) -> save(array('status' => 2, 'audit_time' => time()));
				if (false !== $result) {
					$user_joke = $joke_mod -> where('id=' . $value) -> find();
					$params = array('user_id' => $user_joke['user_id'], 'value' => 200, 'type' => 1, 'content' => $user_joke['title'] . ' 通过审核，获得 200 囧币', 'created_time' => time());
					D('user_trace') -> add($params);
					D('user') -> where('id=' . $user_joke['user_id']) -> setField(array('money' => array('exp', "(money + 200)"), 'send_num' => array('exp', "(send_num + 1)")));
					$user_audit = D('user_audit') -> where('joke_id=' . $value . ' and type < 4') -> select();
					foreach ($user_audit as $sk => $sv) {
						$user = D('user') -> where('id=' . $sv['user_id']) -> find();
						$audit_num = $user['audit_num'];
						$audit_suc_num = $user['audit_suc_num'] + 1;
						$audit_pro = intval(($audit_suc_num / $audit_num) * 100);
						D('user') -> where('id=' . $user['id']) -> save(array('audit_suc_num' => $audit_suc_num, 'audit_pro' => $audit_pro));
					} 
				} else {
					$this -> ajaxReturn(array('err' => 0, 'msg' => '操作失败!', 'url' => $this -> page_url));
				} 
			} 
			$this -> ajaxReturn(array('err' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
		} 
	} 
	public function add() {
		$tags = D('tags') -> order('sort asc') -> select();
		$this -> assign('tags', $tags);
		$this -> display();
	} 
	public function edit() {
		$joke_mod = D('user_joke');
		if (IS_POST) {
			$data = $joke_mod -> create();
			if (count($data['tags_id']) > 0) {
				$tags_id = '|' . implode('|', $data['tags_id']) . '|';
			} else {
				$tags_id = '';
			} 
			$data['tags_id'] = $tags_id;
			$data['audit_time'] = time();
			$user_joke = $joke_mod -> where('id=' . $data['id']) -> find();
			$result = $joke_mod -> where("id=" . $data['id']) -> save($data);
			if (false !== $result) {
				if ($data['status'] == 2) {
					$params = array('user_id' => $user_joke['user_id'], 'value' => 200, 'type' => 1, 'content' => $user_joke['title'] . ' 通过审核，获得 200 囧币', 'created_time' => time());
					D('user_trace') -> add($params);
					D('user') -> where('id=' . $user_joke['user_id']) -> setField(array('money' => array('exp', "(money + 200)"), 'send_num' => array('exp', "(send_num + 1)")));
					$user_audit = D('user_audit') -> where('joke_id=' . $data['id'] . ' and type < 4') -> select();
					foreach ($user_audit as $key => $value) {
						$user = D('user') -> where('id=' . $value['user_id']) -> find();
						$audit_num = $user['audit_num'];
						$audit_suc_num = $user['audit_suc_num'] + 1;
						$audit_pro = intval(($audit_suc_num / $audit_num) * 100);
						D('user') -> where('id=' . $user['id']) -> save(array('audit_suc_num' => $audit_suc_num, 'audit_pro' => $audit_pro));
					} 
				} 
				$this -> ajaxReturn(array('err' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
			} else {
				$this -> ajaxReturn(array('err' => 0, 'msg' => '操作错误!', 'url' => $this -> page_url));
			} 
		} else {
			if ((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
				$this -> error('请选择要编辑的笑话！');
			} 
			$tags = D('tags') -> order('sort asc') -> select();
			$user_joke = D('user_joke') -> where('id=' . $_GET['id']) -> find();
			$user = D('user') -> where('id=' . $user_joke['user_id']) -> find();
			$user_joke['user_info'] = $user;
			$tags_id = substr($user_joke['tags_id'], 1, strlen($user_joke['tags_id']) - 2);
			$user_joke['tags_id'] = explode('|', $tags_id);
			$this -> assign('user_joke', $user_joke);
			$this -> assign('tags', $tags);
			$this -> display();
		} 
	} 
	public function delete() {
		$id = I('post.id');
		if (empty($id)) {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择要删除的内容！', 'url' => $this -> page_url));
		} 
		if ($id && is_array($id)) {
			$id = implode(',', $id);
		} 
		D('user_joke') -> delete($id);
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
	} 
	public function commend() {
		if (isset($_GET['id']) && trim($_GET['id']) != '') {
			$joke_mod = D('user_joke');
			$joke_mod -> where('id=' . $_GET['id']) -> save(array('commend' => $_GET['commend']));
			$this -> ajaxReturn(array('err' => 1, 'msg' => '操作成功!', 'url' => $this -> page_url));
		} 
	} 
} 
