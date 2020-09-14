<?php
namespace Admin\Controller;
class SettingController extends BaseController {
	protected function _initialize() {
		parent :: _initialize();
	} 
	public function index() {
		$tpl = 'index';
		if (isset($_GET['data'])) {
			$tpl = $_GET['data'];
		} 
		$indextpl = C("HOME_PATH") . "*";
		$list = glob($indextpl);
		foreach ($list as $i => $file) {
			$dir[$i]["filename"] = basename($file);
		} 
		require './Data/conf/tpl.php';
		$Setting_config = $array;
		$this -> Setting_config = $Setting_config;
		$this -> assign("dir", $dir);
		$this -> assign('data', $tpl);
		$this -> display($tpl);
	} 
	public function setting() {
		$setting = I('post.setting');
		$data = I('post.data');
		foreach($setting as $key => $val) {
			$this -> setting_mod -> where("name=" . $key) -> save(array('data' => $val));
		} 
		if (I('post.hometpl')) {
			require './Data/conf/tpl.php';
			$Setting_config = $array;
			$Setting_config["DEFAULT_THEME"] = $_POST["hometpl"];
			$config = "<?php\r\nif(!defined('THINK_PATH')) exit();\r\nreturn \$array = " . var_export($Setting_config, true) . ";\r\n?>";
			file_put_contents('./Data/conf/tpl.php', $config);
		} 
		$this -> ajaxReturn(array('status' => 1, 'msg' => '操作成功!', 'url' => U('setting/index', array('data' => $data))));
	} 
} 
