<?php
/*
Plugin Name: lazy builder
Description: Wordpress database builder like migrations.
Author: clustium Inc.
Author URI: http://www.clustium.com
*/

$lazy_builder = new LazyBuilder;
include_once dirname(__FILE__). '/lazybuilder/taxonomy.php';

class LazyBuilder {
	function __construct() {
		add_action('init', array($this, 'init'));
		add_action('admin_head', array($this, 'head'), 11);
		add_action('admin_menu', array($this, 'option'));
		add_action('wp_ajax_lazy_builder_up', array($this, 'call_up'));
		add_action('wp_ajax_lazy_builder_down', array($this, 'call_down'));
	}
	
	function init() {
		if (get_option('current_lazy_builder') == false) {
			update_option('current_lazy_builder', 0);
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
		$current = get_option('current_lazy_builder');
	
		include_once dirname(__FILE__) . '/builder_view.php';
	}
	
	function call_up() {
		$current = get_option('current_lazy_builder');
		$next = $current + 1;
		
		$latest = 10;
		include_once dirname(__FILE__) . '/builders/'. $next. '.php';
		$class = 'LazyBuilder_'. $next;
		
		$builder = new $class();
		$builder->up();
	
		if ($latest <= $current) {
			$json = 'Latest builder.';
		} else {
			update_option('current_lazy_builder', $next);
			$json = 'Builder up to '. get_option('current_lazy_builder');
		}
		
		echo json_encode($json);
		die();
	}
	
	
	function call_down() {
		$current = get_option('current_lazy_builder');
		
		include_once dirname(__FILE__) . '/builders/'. $current. '.php';
		$class = 'LazyBuilder_'. $current;
		
		$builder = new $class();
		$builder->down();
	
		if (0 >= $current) {
			$json = 'Oldest builder.';
		} else {
			update_option('current_lazy_builder', (int) $current - 1);
			$json = 'Builder down to '. get_option('current_lazy_builder');
		}
		
		echo json_encode($json);
		die();
	}
}
