<?php

class LazyBuilder_Listener {

	private static $instance;
	
	private $notifications = array();
	
	private $dry_run = false;

	private function __construct() {}

	public static function instance() {
		if (empty(self::$instance)) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}

	public function notify($type, $lazybuilder, $args) {
		if ( ! isset($type) ) {
			throw new Exception(__('\'type\' is required.'));
		}

		if ( ! isset($lazybuilder) ) {
			throw new Exception(__('\'lazybuilder\' is required.'));
		}

		$this->notifications[] = array_merge($args, array('type' => $type, 'lazybuilder' => $lazybuilder));
	}
	
	public function parse_html() {
		$html = '';
		
		foreach ($this->notifications as $n) {
			if ( ! isset($n['type'])) continue;
			
			$method = 'parse_html_'. strtolower($n['lazybuilder']);
			
			if ( ! method_exists(__CLASS__ , $method)) {
				throw new Exception(__('Not define '. $method. '()'));
			}

			if ( ! in_array($n['type'], array('add', 'remove', 'modify'))) {
				throw new Exception(__('Invalid type. This type is : '. $n['type']));
			}

			$html .= '<li>';
			$html .= '<span class="'. $n['type']. '">'. $n['type']. '</span>';
			$html .= $this->$method($n);
			$html .= '</li>';
		}
		
		return $html;
	}
	
	public function parse_html_taxonomy($args) {
		$html = '';
		unset($args['lazybuilder'], $args['type']);

		foreach ($args as $key => $val) {
			if (empty($val)) continue;
			
			$html .= ucwords($key). ' : '. $val. ' , ';
		}

		return $html;
	}

	public function set_dry_run($flag) {
		if ( ! is_bool($flag)) {
			throw new InvalidArgumentException('set_dry_run function only accepts boolean. Input was: '. $flag);
		}

		$this->dry_run = $flag;
	}
	
	public function dry_run() {
		return $this->dry_run;
	}
}