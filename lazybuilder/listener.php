<?php

class LazyBuilder_Listener {

	private static $instane;
	
	private $notifications = array();
	
	private $dry_run = false;

	private function __construct() {}

	public static function instance() {
		if (empty(self::$instance)) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}

	public function notify($type, $args) {
		if ( ! isset($type) ) {
			throw new Exception(__('\'type\' is required.'));
		}

		$this->notifications[] = array_merge($args, array('type' => $type));
	}
	
	public function parse_html() {
		$html = '';
		
		foreach ($this->notificateions as $n) {
			if ( ! isset($n['type'])) continue;

			if (in_array($n['type'], array('add', 'remove', 'modify'))) {
				$html .= '<li>';
				$html .= '<span class="'. $n['type']. '">'. $n['change_type']. '</span>';
				$html .= '</li>';
			}
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
		return $this->dry_run();
	}
}