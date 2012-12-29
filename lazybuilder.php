<?php
/*
Plugin Name: lazy builder
Description: Wordpress database builder like migrations.
Author: clustium Inc.
Author URI: http://www.clustium.com
*/

$lazy_builder = new LazyBuilder;

include_once dirname(__FILE__). '/lazybuilder/listener.php';
include_once dirname(__FILE__). '/lazybuilder/taxonomy.php';
include_once dirname(__FILE__). '/lazybuilder/building.php';
include_once dirname(__FILE__). '/lazybuilder/collection/building.php';

class LazyBuilder {
	const OPT_CURRENT = 'lazy_builder_count';

	function __construct() {
		add_action('init', array($this, 'init'));
		add_action('admin_head', array($this, 'head'), 11);
		add_action('admin_menu', array($this, 'option'));
		add_action('wp_ajax_lazy_builder_up', array($this, 'call_up'));
		add_action('wp_ajax_lazy_builder_down', array($this, 'call_down'));
		add_action('wp_ajax_lazy_builder_dry_run', array($this, 'dry_run'));
	}
	
	function init() {
		if (get_option(self::OPT_CURRENT) == false) {
			update_option(self::OPT_CURRENT, 0);
		}
	}
	
	function head() {
		echo '<link rel="stylesheet" type="text/css" media="all" href="'. plugin_dir_url( __FILE__ ). '/builder.css" />';
		echo '<script type="text/javascript" src="'. plugin_dir_url( __FILE__ ). '/builder.js"></script>';
	}

	function option() {
		add_options_page('Lazy builder.', 'Lazy builder', 'manage_options', 'lazy-builder', array($this, 'view'));
	}
	
	function view() {
		if ( ! current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}
	
		$build_files = array();
		$current = get_option(self::OPT_CURRENT);
		
		include_once dirname(__FILE__) . '/builder_view.php';
	}
	
	function call_up() {
		$current = get_option(self::OPT_CURRENT);
		$next = $current + 1;

		if ( ! file_exists(dirname(__FILE__) . '/builders/'. $next. '.php')) {
			echo json_encode('Not exists builder file.');
			die();
		}

		include_once dirname(__FILE__) . '/builders/'. $next. '.php';

		$class = 'LazyBuilder_'. $next;
		$builder = new $class();
		
		try {
			$builder->up();
		} catch (Exception $e) {
			echo json_encode($e->getMessage());
			die();
		}

		update_option(self::OPT_CURRENT, $next);
	
		echo json_encode('Builder up to '. get_option(self::OPT_CURRENT));
		die();
	}
	
	
	function call_down() {
		$current = get_option(self::OPT_CURRENT);
		
		if ( ! file_exists(dirname(__FILE__) . '/builders/'. $current. '.php')) {
			echo json_encode('Not exists builder file.');
			die();
		}

		include_once dirname(__FILE__) . '/builders/'. $current. '.php';
		$class = 'LazyBuilder_'. $current;

		$builder = new $class();

		try {
			$builder->down();
		} catch (Exception $e) {
			echo json_encode($e->getMessage());
			die();
		}

		if (0 >= $current) {
			$json = 'Oldest builder.';
		} else {
			update_option(self::OPT_CURRENT, (int) $current - 1);
			$json = 'Builder down to '. get_option(self::OPT_CURRENT);
		}
		
		echo json_encode($json);
		die();
	}

	public static function path() {
		return plugin_dir_path(__FILE__);
	}

	public function dry_run() {
		if ( ! isset($_POST['builder']) || ! isset($_POST['type'])) {
			echo json_encode('error : ');
			die();
		}
		
		$builder = $_POST['builder'];
		$type = $_POST['type'];

		if ( ! file_exists(dirname(__FILE__) . '/builders/'. $builder. '.php')) {
			echo json_encode('Not exists builder file.');
			die();
		}

		echo json_encode($_POST['type']);
		die();
	}
}
