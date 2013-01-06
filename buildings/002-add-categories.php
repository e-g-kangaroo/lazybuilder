<?php
class Building_Add_Categories {

	public function up() {

		LazyBuilder_Taxonomy::add('category', array(
			'cat_b' => array(
				'name' => 'カテゴリ追加のテスト',
			),
			'cat_c' => array(
				'name' => 'category add',
			),
			'cat_d' => array(
				'name' => 'かてごり',
			),
		));
	}
	
	public function down() {

		LazyBuilder_Taxonomy::remove('category', array(
			'cat_b', 'cat_c', 'cat_d',
		));
	}
}