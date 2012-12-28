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
	
		switch ($factory) {
			case 'filename':
				$file = $opt['file'];
				$config = $opt['config'];

				$ext = substr($file, strrpos($file, '.') + 1);
				$num = substr($file, 0, strpos($file, '-'));
				$name = ucfirst(substr($file, strpos($file, '-') + 1, strrpos($file, '.') - strpos($file, '-') - 1));

				$instance = new self(array(
					'num' => (int) $num,
					'num_str' => $num,
					'name' => $name,
					'filepath' => $dir.'/'.$file,
					'classname' => ((string) $config['class_prefix']).str_replace('-', '_', $name),
				));
				return $instance;
				break;
			default:
				throw new Exception('Unknown factory name');
		}
	}

	protected function enable_param($name) {

		return in_array($name, array('num', 'num_str', 'name', 'filepath', 'classname'));
	}

	public function include_building()
	{
		include_once($this->filepath);

		if ( ! class_exists($this->classname)) {
			throw new Exception(sprintf('Include building file, but does not exist %s class.', $this->classname));
		}
	}

	public function __get($name) {

		if ($this->enable_param($name)) {
			return $this->$name;
		}
	}
}