<?php

class LazyBuilder_Listener {
	private static $instane;
	private function __construct() {}
	
	private $notifications = array();
	
	public static function instance() {
		if (empty(self::$instance)) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
	public function notify($type, $method, $args) {
		if ( ! isset($type) ) {
			throw new Exception(__('\'type\' is required'));
		}

		if ( ! isset($args['method'])) {
			throw new Exception(__('\'method\' is requierd'));
		}

		$this->notifications[] = array_merge($args, array('type' => $type, 'method' => $method));
	}
	
	public function parse_html() {
		$html = '';
		
		foreach ($this->notifications as $notification) {
			$type   = $notification['type'];
			$method = $notification['method'];
			$template = file_get_contents(__FILE__. 'templates/'. $type. '_'. $method. '.tpl');
			
			foreach ($notification as $search => $replace) {
				$template = str_replace('##'. $search. '##', $replace, $template);
			}
			
			$html .= $template. "\n";
		}
	}
}