<?php
namespace Admin\Controller;
class DatabaseController extends BaseController {
	protected function _initialize() {
		parent :: _initialize();
	} 
	public function backup() {
		if (IS_POST) {
			$tables = I('post.tables');;
			if (empty($tables)) {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '请选择需要备份的数据库表！', 'url' => U('database/backup')));
			} 
			$filesize = intval(I('post.filesize'));
			if ($filesize < 512) {
				$this -> ajaxReturn(array('status' => 0, 'msg' => '出错了,请为分卷大小设置一个大于512的整数值！', 'url' => U('database/backup')));
			} 
			$file = DATA_PATH . 'backup/';
			$random = mt_rand(1000, 9999);
			$sql = '';
			$p = 1;
			foreach($tables as $table) {
				$rs = M(str_replace(C('DB_PREFIX'), '', $table));
				$array = $rs -> select();
				$sql .= "TRUNCATE TABLE `$table`;\n";
				foreach($array as $value) {
					$sql .= $this -> insertsql($table, $value);
					if (strlen($sql) >= $filesize * 1000) {
						$filename = $file . date('Ymd') . '_' . $random . '_' . $p . '.sql';
						$this -> write_file($filename, $sql);
						$p++;
						$sql = '';
					} 
				} 
			} 
			if (!empty($sql)) {
				$filename = $file . date('Ymd') . '_' . $random . '_' . $p . '.sql';
				$this -> write_file($filename, $sql);
			} 
			$this -> ajaxReturn(array('status' => 1, 'msg' => '数据库分卷备份已完成,共分成' . $p . '个sql文件存放！', 'url' => U('database/backup')));
			exit;
		} 
		$tables = $this -> get_tables();
		$this -> assign('tables', $tables);
		$this -> display();
	} 
	private function insertsql($table, $row) {
		$sql = "INSERT INTO `{$table}` VALUES (";
		$values = array();
		foreach ($row as $value) {
			$values[] = "'" . mysql_escape_string($value) . "'";
		} 
		$sql .= implode(', ', $values) . ");\n";
		return $sql;
	} 
	public function restore() {
		$restore = array();
		$filepath = DATA_PATH . 'backup/*.sql';
		$filearr = glob($filepath);
		if (!empty($filearr)) {
			foreach($filearr as $k => $sqlfile) {
				preg_match("/([0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.sql/i", basename($sqlfile), $num);
				$restore[$k]['filename'] = basename($sqlfile);
				$restore[$k]['filesize'] = round(filesize($sqlfile) / (1024 * 1024), 2);
				$restore[$k]['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
				$restore[$k]['pre'] = $num[1];
				$restore[$k]['number'] = $num[2];
				$restore[$k]['path'] = DATA_PATH . 'backup/';
			} 
		} 
		$this -> assign('restore', $restore);
		$this -> display();
	} 
	public function recover() {
		$rs = new \Think\Model();
		$pre = I('post.pre');
		$number = I('post.number')? intval(I('post.number')): 1;
		$filename = $pre . $number . '.sql';
		$filepath = DATA_PATH . 'backup/' . $filename;
		if (file_exists($filepath)) {
			$sql = read_file($filepath);
			$sql = str_replace("\r\n", "\n", $sql);
			foreach(explode(';
', trim($sql))as $query) {
				$rs -> query(trim($query));
			} 
			$url = U('database/recover', array('pre' => $pre, 'number' => $number + 1));
			$this -> ajaxReturn(array('status' => 1, 'msg' => '第' . $number . '个备份文件恢复成功,准备恢复下一个,请稍等！', 'url' => $url));
		} else {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '无此文件！', 'url' => U('database/restore')));
		} 
	} 
	public function down() {
		$filepath = DATA_PATH . 'backup/' . I('post.filename');
		if (file_exists($filepath)) {
			$filename = basename($filepath);
			$filetype = trim(substr(strrchr($filename, '.'), 1));
			$filesize = filesize($filepath);
			header('Cache-control: max-age=31536000');
			header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
			header('Content-Encoding: none');
			header('Content-Length: ' . $filesize);
			header('Content-Disposition: attachment; filename=' . $filename);
			header('Content-Type: ' . $filetype);
			readfile($filepath);
			exit;
		} else {
			$this -> ajaxReturn(array('status' => 0, 'msg' => '出错了,没有找到分卷文件！', 'url' => U('database/restore')));
		} 
	} 
	public function delete_backup() {
		$filename = trim(I('post.filename'));
		@unlink(DATA_PATH . 'backup/' . $filename);
		$this -> ajaxReturn(array('status' => 1, 'msg' => $filename . '已经删除！', 'url' => U('database/restore')));
	} 
	private function get_tables() {
		$tables = \Think\Db :: getInstance() -> getTables();
		return $tables;
	} 
} 
