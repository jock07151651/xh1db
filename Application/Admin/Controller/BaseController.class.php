<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
	protected $pagesize = 10;
	protected $setting_mod;
	protected $setting;
	protected function _initialize() {
		$this -> setting_mod = M('setting');
		$this -> get_setting();
		$this -> check_login();
		$this -> get_node_ids();
		/*
		$domain = $this -> getTopDomainhuo();
		$real_domain = 'baidu.com';
		$check_host = 'http://auth.yicms.com/update.php?a=client_check&u=' . $domain;
		$check_info = file_get_contents($check_host);
		if ($check_info == '1') {
			echo '域名未授权,需授权请联系 电话：400-888-5302  官方网站：www.yicms.com';
			die;
		} elseif ($check_info == '2') {
			echo '授权已经到期,续费请联系 电话：400-888-5302  官方网站：www.yicms.com';
			die;
		} 
		if ($check_info !== '0') {
			if ($domain !== $real_domain) {
				echo '域名未授权,需授权请联系 电话：400-888-5302  官方网站：www.yicms.com';
				die;
			} 
		} 
		unset($domain);
		*/
	} 
	public function getTopDomainhuo() {
		$host = $_SERVER['HTTP_HOST'];
		$host = strtolower($host);
		if (strpos($host, '/') !== false) {
			$parse = @parse_url($host);
			$host = $parse['host'];
		} 
		$topleveldomaindb = array('com', 'edu', 'gov', 'int', 'mil', 'net', 'org', 'biz', 'info', 'pro', 'name', 'museum', 'coop', 'aero', 'xxx', 'idv', 'mobi', 'cc', 'me');
		$str = '';
		foreach($topleveldomaindb as $v) {
			$str .= ($str ? '|' : '') . $v;
		} 
		$matchstr = "[^\.]+\.(?:(" . $str . ")|\w{2}|((" . $str . ")\.\w{2}))$";
		if (preg_match("/" . $matchstr . "/ies", $host, $matchs)) {
			$domain = $matchs['0'];
		} else {
			$domain = $host;
		} 
		return $domain;
	} 
	protected function get_setting() {
		$setting = $this -> setting_mod -> select();
		foreach ($setting as $key => $value) {
			$this -> setting[$value['name']] = $value['data'];
		} 
		$this -> assign('setting', $this -> setting);
	} 
	protected function get_node_ids() {
		if (isset($_SESSION['admin_info'])) {
			$admin = M('admin') -> find($_SESSION['admin_info']['id']);
			$role = M('role') -> find($admin['role_id']);
			$this -> assign('node_ids', $role['node_ids']);
		} 
	} 
	protected function check_login() {
		if (!isset($_SESSION['admin_info'])) {
			echo "<script>location='" . U('public/login') . "';</script>";
			return;
		} 
		$this -> assign('admin_info', $_SESSION['admin_info']);
	} 
	protected function _empty() {
		header("HTTP/1.0 404 Not Found");
		$this -> display("Common:empty");
	} 
	protected function read_file($l1) {
		return file_get_contents($l1);
	} 
	protected function write_file($filename, $content) {
		$re = true;
		if (!@$fp = fopen ($filename, "w+")) {
			$re = false;
			echo 'Failed to open target file.';
		} 
		if (!@fwrite ($fp, $content)) {
			$re = false;
			echo 'Failed to write file.';
		} 
		if (!@fclose ($fp)) {
			$re = false;
			echo 'Failed to close target file.';
		} 
		return $re;
	} 
	protected function delete_dir($dir) {
		$dh = opendir($dir);
		while ($file = readdir($dh)) {
			if ($file != "." && $file != "..") {
				$fullpath = $dir . "/" . $file;
				if (!is_dir($fullpath)) {
					unlink($fullpath);
				} else {
					$this -> delete_dir($fullpath);
					rmdir($fullpath);
				} 
			} 
		} 
		closedir($dh);
	} 
	protected function process_cate(&$cate, $pid = 0, $level = 0, $html = '--') {
		static $tree = array();
		foreach($cate as $v) {
			if ($v['pid'] == $pid) {
				$v['sort'] = $level;
				$v['html'] = str_repeat($html, $level);
				$tree[] = $v;
				$this -> process_cate($cate, $v['id'], $level + 1);
			} 
		} 
		return $tree;
	} 
	protected function substr_pwd($pwd) {
		$pwd = md5($pwd);
		if (strlen($pwd) == 32) {
			return substr($pwd, 8, 16);
		} 
		return $pwd;
	} 
} 
