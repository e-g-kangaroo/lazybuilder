<?php

class LazyBuilder_Collection_Building implements Iterator {

	protected $config = array();
	protected $buildings = array();
	private $_pos = 0;

	public function __construct($config = array()) {

		$default = array(
			'buildings_dir' => LazyBuilder::path().'buildings',
			'class_prefix' => 'Building_'
		);

		$this->config = array_merge($default, $config);

		$this->load_buildings();
	}

	protected function load_buildings() {

		$dir = $this->config['buildings_dir'];
		$this->buildings = array();

		if ( is_dir($dir) and $dh = opendir($dir) ) {
			while (($file = readdir($dh)) !== false) {
				$ext = substr($file, strrpos($file, '.') + 1);
				$num = substr($file, 0, strpos($file, '-'));

				if ( $ext == 'php' and preg_match('/[0-9]{3}/', $num) ) {
					$this->buildings[] = LazyBuilder_Building::make('filename', array('file' => $file, 'config' => $this->config));
				} 
			}
		} else {
			throw new Exception("{$dir} is not a directory or cannot access");
		}
	}

	public function & get_building($num)
	{
		$num = (int) $num;

		foreach ($this as $builder) {
			if ( $builder->num == $num ) return $builder;
		}

		throw new Exception('Unknown builder');
	}

	public function valid()
	{
		return isset($this->buildings[$this->_pos]);
	}

	public function next()
	{
		$this->_pos++;
	}

	public function current()
	{
		return $this->buildings[$this->_pos];
	}

	public function rewind()
	{
		$this->_pos = 0;
	}

	public function key()
	{
		return $this->_pos;
	}
}