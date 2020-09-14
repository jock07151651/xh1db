<?php
namespace Admin\Controller;
class UeditorController extends BaseController {
	private $stateMap = array("SUCCESS", "文件大小超出 upload_max_filesize 限制", "文件大小超出 MAX_FILE_SIZE 限制", "文件未被完整上传", "没有文件被上传", "上传文件为空", "ERROR_TMP_FILE" => "临时文件错误", "ERROR_TMP_FILE_NOT_FOUND" => "找不到临时文件", "ERROR_SIZE_EXCEED" => "文件大小超出网站限制", "ERROR_TYPE_NOT_ALLOWED" => "文件类型不允许", "ERROR_CREATE_DIR" => "目录创建失败", "ERROR_DIR_NOT_WRITEABLE" => "目录没有写权限", "ERROR_FILE_MOVE" => "文件保存时出错", "ERROR_FILE_NOT_FOUND" => "找不到上传文件", "ERROR_WRITE_CONTENT" => "写入文件内容错误", "ERROR_UNKNOWN" => "未知错误", "ERROR_DEAD_LINK" => "链接不可用", "ERROR_HTTP_LINK" => "链接不是http链接", "ERROR_HTTP_CONTENTTYPE" => "链接contentType不正确");
	protected function _initialize() {
		parent :: _initialize();
	} 
	public function uploadimg() {
		$config = array('rootPath' => UPLOAD_PATH, 'savePath' => "ueditor/", 'maxSize' => 11048576, 'saveName' => array('uniqid', ''), 'exts' => array('jpg', 'gif', 'png', 'jpeg'), 'autoSub' => false,);
		$upload = new \Think\Upload($config);
		$file = $title = $oriName = $state = '0';
		$info = $upload -> upload();
		if ($info) {
			$title = $oriName = $info['upfile']['name'];
			$state = 'SUCCESS';
			$file = UPLOAD_PATH . "ueditor/" . $info['upfile']['savename'];
			if (strpos($file, "https") === 0 || strpos($file, "http") === 0) {
			} else {
				$host = (is_ssl()? 'https' : 'http') . "://" . $_SERVER['HTTP_HOST'];
				$file = $host . substr($file, 1);
			} 
		} else {
			$state = $upload -> getError();
		} 
		$response = "{'url':'" . $file . "','title':'" . $title . "','original':'" . $oriName . "','state':'" . $state . "'}";
		exit($response);
	} 
	public function imageManager() {
		error_reporting(E_ERROR | E_WARNING);
		$path = 'upload';
		$action = htmlspecialchars($_POST["action"]);
		if ($action == "get") {
			$files = $this -> getfiles($path);
			if (!$files)return;
			$str = "";
			foreach ($files as $file) {
				$str .= $file . "ue_separate_ue";
			} 
			echo $str;
		} 
	} 
	private function getfiles() {
		if (!is_dir($path))return;
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				$path2 = $path . '/' . $file;
				if (is_dir($path2)) {
					getfiles($path2, $files);
				} else {
					if (preg_match('/\\.(gif|jpeg|jpg|png|bmp)$/i', $file)) {
						$files[] = $path2;
					} 
				} 
			} 
		} 
		return $files;
	} 
	public function get_remote_image() {
		$uri = htmlspecialchars($_POST[ 'upfile' ]);
		$uri = str_replace("&amp;" , "&" , $uri);
		$config = array("savePath" => UPLOAD_PATH . "ueditor/", "allowFiles" => array(".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp"), "maxSize" => 3000);
		set_time_limit(0);
		$imgUrls = explode("ue_separate_ue" , $uri);
		$tmpNames = array();
		foreach ($imgUrls as $imgUrl) {
			if (strpos($imgUrl, "http") !== 0) {
				array_push($tmpNames , "error");
				continue;
			} 
			$heads = get_headers($imgUrl);
			if (!(stristr($heads[ 0 ] , "200") && stristr($heads[ 0 ] , "OK"))) {
				array_push($tmpNames , "error");
				continue;
			} 
			$fileType = strtolower(strrchr($imgUrl , '.'));
			if (!in_array($fileType , $config[ 'allowFiles' ]) || stristr($heads[ 'Content-Type' ] , "image")) {
				array_push($tmpNames , "error");
				continue;
			} 
			ob_start();
			$context = stream_context_create(array ('http' => array ('follow_location' => false)));
			readfile($imgUrl, false, $context);
			$img = ob_get_contents();
			ob_end_clean();
			$uriSize = strlen($img);
			$allowSize = 1024 * $config[ 'maxSize' ];
			if ($uriSize > $allowSize) {
				array_push($tmpNames , "error");
				continue;
			} 
			$savePath = $config[ 'savePath' ];
			if (!file_exists($savePath)) {
				mkdir("$savePath" , 0777);
			} 
			$file = date("Ymdhis") . uniqid() . strrchr($imgUrl , '.');
			$tmpName = $savePath . $file ;
			$file = UPLOAD_PATH . "ueditor/" . $file;
			if (strpos($file, "https") === 0 || strpos($file, "http") === 0) {
			} else {
				$host = (is_ssl()? 'https' : 'http') . "://" . $_SERVER['HTTP_HOST'];
				$file = $host . substr($file, 1);
			} 
			if (sp_file_write($tmpName, $img)) {
				array_push($tmpNames , $file);
			} else {
				array_push($tmpNames , "error");
			} 
		} 
		$response = "{'url':'" . implode("ue_separate_ue" , $tmpNames) . "','tip':'远程图片抓取成功！','srcUrl':'" . $uri . "'}";
		exit($response);
	} 
	public function upload() {
		date_default_timezone_set("Asia/chongqing");
		error_reporting(E_ERROR);
		header('Content-Type: text/html; charset=utf-8');
		$config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("./Public/js/ueditor/config.json")), true);
		$action = $_GET['action'];
		switch ($action) {
			case 'config': $result = json_encode($config);
				break;
			case 'uploadimage': case 'uploadscrawl': $result = $this -> _ueditor_upload();
				break;
			case 'uploadvideo': $result = $this -> _ueditor_upload(array('maxSize' => 1073741824, 'exts' => array('mp4', 'avi', 'wmv', 'rm', 'rmvb', 'mkv')));
				break;
			case 'uploadfile': $result = $this -> _ueditor_upload(array('exts' => array('jpg', 'gif', 'png', 'jpeg', 'txt', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar', 'ppt', 'pptx',)));
				break;
			case 'listimage': $result = "";
				break;
			case 'listfile': $result = "";
				break;
			case 'catchimage': $result = $this -> _get_remote_image();
				break;
			default: $result = json_encode(array('state' => '请求地址出错'));
				break;
		} 
		if (isset($_GET["callback"]) && false) {
			if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
				echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
			} else {
				echo json_encode(array('state' => 'callback参数不合法'));
			} 
		} else {
			exit($result);
		} 
	} 
	private function _get_remote_image() {
		$source = array();
		if (isset($_POST['source'])) {
			$source = $_POST['source'];
		} else {
			$source = $_GET['source'];
		} 
		$item = array("state" => "", "url" => "", "size" => "", "title" => "", "original" => "", "source" => "");
		$date = date("Ymd");
		$config = array("savePath" => UPLOAD_PATH . "ueditor/$date/", "allowFiles" => array(".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp"), "maxSize" => 3000);
		$list = array();
		foreach ($source as $imgUrl) {
			$return_img = $item;
			$return_img['source'] = $imgUrl;
			$imgUrl = htmlspecialchars($imgUrl);
			$imgUrl = str_replace("&amp;", "&", $imgUrl);
			if (strpos($imgUrl, "http") !== 0) {
				$return_img['state'] = $this -> stateMap['ERROR_HTTP_LINK'];
				array_push($list , $return_img);
				continue;
			} 
			$heads = get_headers($imgUrl);
			if (!(stristr($heads[ 0 ] , "200") && stristr($heads[ 0 ] , "OK"))) {
				$return_img['state'] = $this -> stateMap['ERROR_DEAD_LINK'];
				array_push($list , $return_img);
				continue;
			} 
			$fileType = strtolower(strrchr($imgUrl , '.'));
			if (!in_array($fileType , $config[ 'allowFiles' ]) || stristr($heads[ 'Content-Type' ] , "image")) {
				$return_img['state'] = $this -> stateMap['ERROR_HTTP_CONTENTTYPE'];
				array_push($list , $return_img);
				continue;
			} 
			ob_start();
			$context = stream_context_create(array ('http' => array ('follow_location' => false)));
			readfile($imgUrl, false, $context);
			$img = ob_get_contents();
			ob_end_clean();
			$uriSize = strlen($img);
			$allowSize = 1024 * $config[ 'maxSize' ];
			if ($uriSize > $allowSize) {
				$return_img['state'] = $this -> stateMap['ERROR_SIZE_EXCEED'];
				array_push($list , $return_img);
				continue;
			} 
			$savePath = $config[ 'savePath' ];
			if (!file_exists($savePath)) {
				mkdir("$savePath" , 0777);
			} 
			$file = uniqid() . strrchr($imgUrl , '.');
			$tmpName = $savePath . $file ;
			$file = UPLOAD_PATH . "ueditor/$date/" . $file;
			if (strpos($file, "https") === 0 || strpos($file, "http") === 0) {
			} else {
				$host = '';
				$file = $host . substr($file, 1);
			} 
			if ($this -> write_file($tmpName, $img)) {
				$return_img['state'] = 'SUCCESS';
				$return_img['url'] = $file;
				array_push($list , $return_img);
			} else {
				$return_img['state'] = $this -> stateMap['ERROR_WRITE_CONTENT'];
				array_push($list , $return_img);
			} 
		} 
		return json_encode(array('state' => count($list)? 'SUCCESS':'ERROR', 'list' => $list));
	} 
	private function _ueditor_upload($config = array()) {
		$date = date("Ymd");
		$mconfig = array('rootPath' => UPLOAD_PATH, 'savePath' => "ueditor/$date/", 'maxSize' => 10485760, 'saveName' => array('uniqid', ''), 'exts' => array('jpg', 'gif', 'png', 'jpeg'), 'autoSub' => false,);
		if (is_array($config)) {
			$config = array_merge($mconfig, $config);
		} else {
			$config = $mconfig;
		} 
		$upload = new \Think\Upload($config);
		$file = $title = $oriName = $state = '0';
		$info = $upload -> upload();
		if ($info) {
			$title = $oriName = $_FILES['upfile']['name'];
			$size = $info['upfile']['size'];
			$state = 'SUCCESS';
			if (!empty($info['upfile']['url'])) {
				$url = $info['upfile']['url'];
			} else {
				$url = UPLOAD_PATH . "ueditor/$date/" . $info['upfile']['savename'];
			} 
			if (strpos($url, "https") === 0 || strpos($url, "http") === 0) {
			} else {
				$host = '';
				$url = $host . substr($url, 1);
			} 
		} else {
			$state = $upload -> getError();
		} 
		$response = array("state" => $state, "url" => $url, "title" => $title, "original" => $oriName,);
		return json_encode($response);
	} 
} 
