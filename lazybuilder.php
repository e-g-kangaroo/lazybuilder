<?php
/*
Plugin Name: lazy builder
Description: Wordpress database builder like migrations.
Author: clustium Inc.
Author URI: http://www.clustium.com
*/

/**
 * 
 * 
 * 
 * 
 */
function builder_view() {
	if ( ! current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}

	$build_files = array();
	$current = get_option('lazy_current_builder');

	include_once dirname(__FILE__) . '/builder_view.php';
}

/**
 * 
 * 
 * 
 * 
 */ 
function builder_option() {
	add_options_page('Lazy builder.', 'Lazy builder', 'manage_options', 'lazy-builder', 'builder_view');
}
add_action('admin_menu', 'builder_option');

/**
 * 
 * 
 * 
 * 
 */ 
function builder_init() {
	if (get_option('current_lazy_builder') == false) {
		update_option('current_lazy_builder', '1');
	}
}
add_action('init', 'builder_init');

/**
 * 
 * 
 * 
 * 
 */ 
function builder_head() {
  echo '<link rel="stylesheet" type="text/css" media="all" href="'. plugin_dir_url( __FILE__ ). '/builder.css" />';
  echo '<script type="text/javascript" src="'. plugin_dir_url( __FILE__ ). '/builder.js"></script>';
}
add_action('admin_head', 'builder_head', 11);

/**
 * 
 * 
 * 
 */
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
add_action('wp_ajax_lazy_builder_up', 'lazy_builder_up');

/**
 * 
 * 
 * 
 */
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
add_action('wp_ajax_lazy_builder_down', 'lazy_builder_down');
