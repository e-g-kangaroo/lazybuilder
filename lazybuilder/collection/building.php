<?php

class LazyBuilder_Collection_Building implements Iterator {

	protected $config = array();

	protected $buildings = array();

	private $_pos = 0;

	public function __construct($config = array()) {

		$this->load_buildings();
	}

	protected function load_buildings() {

		$dir = LazyBuilder::config('buildings_dir');
		$this->buildings = array();

		if ( is_dir($dir) and $dh = opendir($dir) ) {
			while (($file = readdir($dh)) !== false) {
				$ext = substr($file, strrpos($file, '.') + 1);
				$num = substr($file, 0, strpos($file, '-'));

				if ( $ext == 'php' and preg_match('/[0-9]{3}/', $num) ) {
					$this->buildings[(int) $num - 1] = LazyBuilder_Building::make('filename', array('file' => $file));
				} 
			}
		} else {
			throw new Exception("{$dir} is not a directory or cannot access");
		}
	}

	public function & get_building($num) {

		$num = (int) $num;

		foreach ($this as $building) {
			if ( $building->num == $num ) return $building;
		}

		throw new Exception('Unknown builder');
	}

	public function is_exists($num) {

		try {
			$this->get_building($num);
		} catch (Exception $e) {
			return false;
		}
		
		return true;
	}

	public function sort_desc()
	{
		$new_buildings = array();

		foreach ($this as $num => $building)
		{
			$new_buildings[$num] = $building;
		}

		$this->buildings = array_reverse($new_buildings);

		return $this;
	}

	public function valid() {

		return isset($this->buildings[$this->_pos]);
	}

	public function next() {

		$this->_pos++;
	}

	public function current() {

		return $this->buildings[$this->_pos];
	}

	public function rewind() {

		$this->_pos = 0;
	}

	public function key() {

		return $this->_pos;
	}
}