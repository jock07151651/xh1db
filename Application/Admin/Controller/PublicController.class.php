<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
	public function verify() {
		$verify = new \Think\Verify(array('useCurve' => false, 'useNoise' => false, 'fontSize' => 25, 'imageH' => 50, 'imageW' => 180, 'length' => 4));
		$verify -> entry();
	} 
	public function login() {
		if (!$_SESSION['AdminLogin']) {
			header("Content-Type:text/html; charset=utf-8");
			echo('请从后台管理入口登录。');
			exit();
		} 
		if (isset($_SESSION['admin_info'])) {
			redirect(U('index/index'));
			exit;
		} 
		if (IS_POST) {
			$username = I('post.username');
			$password = I('post.password');
			if (!$username || !$password) {
				redirect(U('public/login'));
				exit;
			} 
			$code = I('post.code');
			$verify = new \Think\Verify();
			if (!$verify -> check($code)) {
				$this -> error("验证码错误");
				exit;
			} 
			$admin_mod = M('admin');
			if (!$admin_mod -> autoCheckToken($_POST)) {
				$this -> error("令牌验证错误");
				exit;
			} 
			$admin_info = $admin_mod -> where("username='$username' and status=1") -> find();
			if (false === $admin_info) {
				$this -> error('帐号不存在或已禁用！');
			} else {
				if ($admin_info['password'] != md5($password)) {
					$this -> error('密码错误！');
					exit;
				} 
				$admin_mod -> where('id=' . (int)$admin_info['id']) -> save(array('last_time' => time()));
				$_SESSION['admin_info'] = $admin_info;
				$this -> success('登录成功！', U('index/index'));
				exit;
			} 
		} 
		$this -> display();
	} 
	public function logout() {
		if (isset($_SESSION['admin_info'])) {
			session(null);
			$this -> success('退出登录成功！', U('public/login'));
		} else {
			$this -> error('已经退出登录！', U('public/login'));
		} 
	} 
	public function upload() {
		$savePath = I('post.savePath');
		if (!empty($_FILES)) {
			$upload = $this -> _upload($_FILES, $savePath);
			$this -> ajaxReturn($upload);
		} 
	} 
	private function _upload($file, $savePath) {
		$config = array('maxSize' => 5120 * 5120, 'exts' => explode(',', 'jpg,gif,png,jpeg'), 'savePath' => $savePath . '/', 'rootPath' => UPLOAD_PATH, 'subName' => array('date', 'Ymd'), 'saveName' => array('uniqid', ''));
		$upload = new \Think\Upload($config);
		if (!$info = $upload -> upload($file)) {
			return array('status' => 0, 'msg' => $upload -> getError());
		} 
		return array('status' => 1, 'msg' => UPLOAD_PATH . $info['Filedata']['savepath'] . $info['Filedata']['savename']);
	} 
} 
