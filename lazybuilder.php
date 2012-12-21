<?php
/*
Plugin Name: lazy builder
Description: Wordpress database builder like migrations.
Author: clustium Inc.
Author URI: http://www.clustium.com
*/

$lazy_builder = new Lazy_Builder_Core;

class Lazy_Builder_Core {
	function __construct() {
		add_action('init', array($this, 'init'));
		add_action('admin_head', array($this, 'head'), 11);
		add_action('admin_menu', array($this, 'option'));
		add_action('wp_ajax_lazy_builder_up', array($this, 'lazy_builder_up'));
		add_action('wp_ajax_lazy_builder_down', array($this, 'lazy_builder_down'));
	}
	
	function init() {
		if (get_option('current_lazy_builder') == false) {
			update_option('current_lazy_builder', '1');
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
		$current = get_option('lazy_current_builder');
	
		include_once dirname(__FILE__) . '/builder_view.php';
	}
	
	function lazy_builder_up() {
		$current = get_option('current_lazy_builder');
		
		$latest = 10;
	
		if ($latest <= $current) {
			$json = 'Latest builder.';
		} else {
			update_option('current_lazy_builder', (int) $current + 1);
			$json = 'Builder up to '. get_option('current_lazy_builder');
		}
		
		echo json_encode($json);
		die();
	}
	
	
	function lazy_builder_down() {
		$current = get_option('current_lazy_builder');
		
		if (1 >= $current) {
			$json = 'Oldest builder.';
		} else {
			update_option('current_lazy_builder', (int) $current - 1);
			$json = 'Builder down to '. get_option('current_lazy_builder');
		}
		
		echo json_encode($json);
		die();
	}
}
