<?php
class Building_Test {

	public function up() {

		LazyBuilder_Taxonomy::add('category', array(
			'cat_a' => array(
				'name' => 'なまえ',
			)
		));
	}
	
	public function down() {

		LazyBuilder_Taxonomy::remove('category', array(
			'cat_a'
		));
	}
}