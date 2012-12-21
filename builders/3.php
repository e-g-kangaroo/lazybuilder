<?php
class LazyBuilder_3 {
	public function up() {
		LazyBuilder_Taxonomy::add('category', array(
			'cat_g' => array(
				'name'        => '新しいかてごり',
				'description' => '説明文！',
				'parent'      => 'cat_c'
			)
		));
	}
	
	public function down() {
		LazyBuilder_Taxonomy::remove('category', array(
			'cat_g'
		));
	}
}