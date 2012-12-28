<?php

class LazyBuilder_Collection_Building implements Iterator {

	protected $config = array();
	protected $builders = array();
	private $_pos = 0;

	public function __construct($config = array()) {

		$default = array(
			'builders_dir' => LazyBuilder::path().'buildings'
		);

		$this->config = array_merge($default, $config);

		$this->load_builders();
	}

	protected function load_builders() {

		$dir = $this->config['builders_dir'];
		$this->builders = array();

		if ( is_dir($dir) and $dh = opendir($dir) ) {
			while (($file = readdir($dh)) !== false) {
				$ext = substr($file, strrpos($file, '.') + 1);
				$num = substr($file, 0, strpos($file, '-'));

				if ( $ext == 'php' and preg_match('/[0-9]{3}/', $num) ) {
					$name = ucfirst(substr($file, strpos($file, '-') + 1, strrpos($file, '.') - strpos($file, '-') - 1));
					$this->builders[] = (object) array(
						'num' => (int) $num,
						'num_str' => $num,
						'name' => $name,
						'filepath' => $dir.'/'.$file
					);
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
		return isset($this->builders[$this->_pos]);
	}

	public function next()
	{
		$this->_pos++;
	}

	public function current()
	{
		return $this->builders[$this->_pos];
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