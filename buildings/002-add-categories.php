<?php
class Builder_Add_Categories {

	public function up() {
		LazyBuilder_Taxonomy::add('category', array(
			'cat_b' => array(
				'name' => 'てすと',
			),
			'cat_c' => array(
				'name' => 'kategor-',
			),
			'cat_d' => array(
				'name' => 'かてごり',
			),
			'cat_e' => array(
				'name' => 'かてごりー',
			),
			'cat_f' => array(
				'name' => 'とうろく',
			),
		));
	}
	
	public function down() {
		LazyBuilder_Taxonomy::remove('category', array(
			'cat_b', 'cat_c', 'cat_d', 'cat_e', 'cat_f',
		));
	}
}