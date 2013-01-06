<?php

class LazyBuilder_Building {

	protected $num;

	protected $num_str;

	protected $name;

	protected $filepath;

	protected $classname;

	public function __construct($param = array()) {

		foreach ($param as $name => $value) {
			if ( $this->enable_param($name) ) {
				$this->$name = $value;
			}
		}
	}

	public static function make($factory, $opt = array()) {

		$class_prefix = LazyBuilder::config('class_prefix');

		switch ($factory) {
			case 'filename':
				$filepath = self::make_by_filename($opt['file']);
				break;
			case 'num':
				$filepath = self::make_by_num($opt['num']);
				break;
			default:
				throw new Exception('Unknown factory name');
		}

		$file = basename($filepath);
		$num = substr($file, 0, strpos($file, '-'));

		$instance = new self(array(
			'num' => (int) $num,
			'num_str' => $num,
			'name' => $name = ucfirst(substr($file, strpos($file, '-') + 1, strrpos($file, '.') - strpos($file, '-') - 1)),
			'filepath' => $filepath,
			'classname' => ($class_prefix).str_replace('-', '_', $name),
		));
		return $instance;
	}

	protected static function make_by_filename($file) {

		return rtrim(LazyBuilder::config('buildings_dir'), '/') . '/' . $file;
	}

	protected static function make_by_num($num) {

		$dir = LazyBuilder::config('buildings_dir');

		if ( is_dir($dir) and $dh = opendir($dir) ) {
			while (($file = readdir($dh)) !== false) {
				$_ext = substr($file, strrpos($file, '.') + 1);
				$_num = substr($file, 0, strpos($file, '-'));
				if ( $_ext == 'php' and $_num == (string) $num ) {
					return rtrim($dir, '/') . '/' . $file;
				} 
			}
		}
	}

	protected function enable_param($name) {

		return in_array($name, array('num', 'num_str', 'name', 'filepath', 'classname'));
	}

	public function include_building() {

		include_once($this->filepath);

		if ( ! class_exists($this->classname)) {
			throw new Exception(sprintf('Include building file, but does not exist %s class.', $this->classname));
		}

		return $this;
	}

	public function instance() {

		$classname = $this->classname;
		return new $classname();
	}

	public function __get($name) {

		if ($this->enable_param($name)) {
			return $this->$name;
		}
	}
}