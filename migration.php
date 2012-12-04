<?php
/*
Plugin Name: Living migrator
Description: Migrator for Living.
Author: Living.jp Development team.
*/

/**
 * 
 * 
 * 
 * 
 */
function migration_view() {
	if ( ! current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}

	$migrations = array();
	$current = get_option('current_migration');
	$migrations_dir = dirname(__FILE__) . '/migrations';
	
	if ($dir = opendir($migrations_dir)) {
		while ($file = readdir($dir)) {
			$name = substr($file, 0, strpos($file, '.php'));
			$class = $current == $name ? 'current selected' : '';
			$migrations[] = (object) compact('name', 'class');
		}
		
		closedir($dir);
	}
	
	include_once $migrations_dir. '/'. $current. '.php';
	$func = 'migration_'. $current;

	if ( ! function_exists($func)) {
		$categories = $tags = $regions = $pages = array();
	} else {
		extract($func());
	}
	
	include_once dirname(__FILE__) . '/migration_view.php';
}

/**
 * 
 * 
 * 
 * 
 */ 
function migrate_option() {
	add_options_page('Living migrations.', 'Living migrations', 'manage_options', 'living-migration', 'migration_view');
}
add_action('admin_menu', 'migrate_option');

/**
 * 
 * 
 * 
 * 
 */ 
function migration_init() {
	update_option('current_migration', '02');
}
add_action('init', 'migration_init');

/**
 * 
 * 
 * 
 * 
 */ 
function migration_head() {
  echo '<link rel="stylesheet" type="text/css" media="all" href="'. plugin_dir_url( __FILE__ ). '/migration.css" />';
  echo '<script type="text/javascript" src="'. plugin_dir_url( __FILE__ ). '/migration.js"></script>';
}
add_action('admin_head', 'migration_head', 11);

/**
 * 
 * 
 * 
 * 
 */ 
function migration_file_read() {
	include_once dirname(__FILE__) . '/migrations/'. $_POST['file']. '.php';
	
	echo json_encode(array(
		'categories' => 'migrate_categories_'. $_POST['file'](),
		'tags'       => 'migrate_tags'. $_POST['file'](),
		'regions'    => 'migrate_regions'. $_POST['file'](),
		'pages'      => 'migrate_pages'. $_POST['file']()
	));
	die();
}
add_action('wp_ajax_migration_file_read', 'migration_file_read');

/**
 * 
 * 
 * 
 * 
 */ 
function create_modification_list($modifications, $rm_prefix = '') {
	echo '<ul>';

	$empty = true;

	foreach ($modifications as $modification) {
		$empty = false;
		echo '<li>';
		echo '<span class="'. $modification['change_type']. '">'. $modification['change_type']. '</span>';

		foreach ($modification as $key => $value) {
			if ($key === 'change_type') continue;
			echo ' '. str_replace($rm_prefix, '', $key). ': '. $value. ', '; 
		}
		
		echo '</li>';
	}
	
	if ($empty) echo '<li>None</li>';
	echo '</ul>';
}