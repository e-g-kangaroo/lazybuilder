<?php
class Builder_Test {

	public function up($dry_run = false) {
		LazyBuilder_Taxonomy::add('category', array(
			'cat_a' => array(
				'name' => 'なまえ',
			)
		), $dry_run);
	}
	
	public function down($dry_run = false) {
		LazyBuilder_Taxonomy::remove('category', array(
			'cat_a'
		), $dry_run);
	}
}