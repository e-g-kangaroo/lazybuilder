<?php
/*
Plugin Name: lazy builder
Description: Wordpress database builder like migrations.
Author: clustium Inc.
Author URI: http://www.clustium.com
*/

$lazy_builder = new LazyBuilder;

class LazyBuilder {

	const OPT_CURRENT = 'lazy_builder_count';
	
	public $current_builder;
	
	private static $dry_run = false;

	function __construct() {
		get_option(self::OPT_CURRENT);
		add_action('init', array($this, 'init'));
		add_action('admin_head', array($this, 'head'), 11);
		add_action('admin_menu', array($this, 'option'));
		add_action('wp_ajax_lazy_builder_up', array($this, 'call_up'));
		add_action('wp_ajax_lazy_builder_down', array($this, 'call_down'));
		add_action('wp_ajax_lazy_builder_dry_run', array($this, 'dry_run'));

		spl_autoload_register(array($this, 'load'));
	}
	
	function init() {
		if (get_option(self::OPT_CURRENT) == false) {
			update_option(self::OPT_CURRENT, 0);
		}
	}
	
	function load($class)
	{
		static $classes = array(
			'LazyBuilder_Listener' => '/lazybuilder/listener.php',
			'LazyBuilder_Taxonomy' => '/lazybuilder/taxonomy.php',
			'LazyBuilder_Building' => '/lazybuilder/building.php',
			'LazyBuilder_Collection_Building' => '/lazybuilder/collection/building.php',
		);

		if ( isset($classes[$class]) ) {
			include_once(self::path() . $classes[$class]);
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
		$collection = new LazyBuilder_Collection_Building();
		$next = $collection->get_building(get_option(self::OPT_CURRENT) + 1);

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
		// validation [s]
		if ( ! isset($_POST['num']) || ! isset($_POST['type'])) {
			echo json_encode('error : ');
			die();
		}
		
		$num = (int) $_POST['num'];
		$type = $_POST['type'];

		if ( ! in_array($type, array('up', 'down'))) {
			echo json_encode('Invalid type.');
			die();
		}
		// validation [e]

		// get listener instance
		self::set_dry_run(true);
		$listener = LazyBuilder_Listener::instance();

		try {
			$buildings = new LazyBuilder_Collection_Building();
			$buildings->get_building($num)->include_building();
			$classname = $buildings->get_building($num)->classname;
			$building = new $classname();
		} catch (Exception $e) {
			echo json_encode($e->getMessage());
			die();
		}

		// building (dry run)
		try {
			$building->$type();
		} catch (Exception $e) {
			echo json_encode($e->getMessage());
			die();
		}

		echo json_encode($listener->parse_html());
		die();
	}
	
	public static function set_dry_run($dry_run) {
		self::$dry_run = (bool) $dry_run;
	}
	
	public static function is_dry_run() {
		return self::$dry_run;
	}
}
