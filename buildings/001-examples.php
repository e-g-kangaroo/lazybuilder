<?php
class Building_Examples {

	public function up() {

		LazyBuilder_Taxonomy::add('category', array(
			'slug_a' => array(
				'name' => 'category a',
			),
			'slug_b' => array(
				'name' => 'category b',
				'description' => 'this category is lazybuilder test.',
			),
			'slug_c' => array(
				'name' => 'category c',
			),
		));

		LazyBuilder_Taxonomy::modify('category', array(
			'slug_a' => array(
				'name' => 'modify',
			),
		));

		LazyBuilder_Taxonomy::remove('category', array(
			'slug_d', 'slug_e',
		));

	}
	
	public function down() {

		LazyBuilder_Taxonomy::add('category', array(
			'slug_d' => array(
				'name' => 'category d',
			),
			'slug_e' => array(
				'name' => 'category e',
			),
		));

		LazyBuilder_Taxonomy::modify('category', array(
			'slug_a' => array(
				'name' => 'category a',
			),
		));

		LazyBuilder_Taxonomy::remove('category', array(
			'slub_a', 'slug_b', 'slug_c'
		));
	}
}