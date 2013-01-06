<?php
class Building_Modify_Categories {

	public function up() {

		LazyBuilder_Taxonomy::modify('category', array(
			'cat_b' => array(
				'name' => '変更テスト',
			),
		));
	}
	
	public function down() {

		LazyBuilder_Taxonomy::modify('category', array(
			'cat_b' => array(
				'name' => 'てすと',
			)
		));
	}
}