<?php
class Building_Delete_Categories {

	public function up() {

		LazyBuilder_Taxonomy::add('category', array(
			'cat_g' => array(
				'name'        => '新しいかてごり',
				'description' => '説明文！',
				'parent'      => 'cat_c'
			)
		));
		LazyBuilder_Taxonomy::remove('category', array(
			'cat_d'
		));
	}
	
	public function down() {

		LazyBuilder_Taxonomy::add('category', array(
			'cat_d' => array(
				'name' => 'かてごり',
			),
		));

		LazyBuilder_Taxonomy::remove('category', array(
			'cat_g'
		));
	}
}