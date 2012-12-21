<?php
/*
Plugin Name: lazy builder
Description: マイグレータライクに動作する、データベースのビルダーです。
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
	$current = get_option('current_builder');
	$builders_dir = dirname(__FILE__) . '/builders';
	
	if ($dir = opendir($builders_dir)) {
		while ($file = readdir($dir)) {
			$name = substr($file, 0, strpos($file, '.php'));
			$class = $current == $name ? 'current selected' : '';
			$build_files[] = (object) compact('name', 'class');
		}
		
		closedir($dir);
	}
	
	include_once $builders_dir. '/'. $current. '.php';
	$func = 'builder_'. $current;
	$info = array('id' => $current);
	$builders = array();

	if (function_exists($func)) {
		$builder_info = $func();
		
		if (isset($builder_info['info'])) {
			$info = $builder_info['info'];
			unset($builder_info['info']);
		}
		
		$builders = $builder_info;
	}
	
	include_once dirname(__FILE__) . '/builder_view.php';
}

/**
 * 
 * 
 * 
 * 
 */ 
function builder_option() {
	add_options_page('DB builders.', 'DB builders', 'manage_options', 'db-builder', 'builder_view');
}
add_action('admin_menu', 'builder_option');

/**
 * 
 * 
 * 
 * 
 */ 
function builder_init() {
	update_option('current_builder', '02');
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
 * 
 */ 
function builder_file_read() {
	include_once dirname(__FILE__) . '/builders/'. $_POST['file']. '.php';
	
	echo json_encode(array(
		'categories' => 'builder_categories_'. $_POST['file'](),
		'tags'       => 'builder_tags'. $_POST['file'](),
		'regions'    => 'builder_regions'. $_POST['file'](),
		'pages'      => 'builder_pages'. $_POST['file']()
	));
	die();
}
add_action('wp_ajax_builder_file_read', 'builder_file_read');
