<?php

class LazyBuilder_Taxonomy {

	public static function add($taxonomy, array $terms) {

		if ( ! taxonomy_exists($taxonomy)) {
			throw new Exception(__('Taxonomy doesn\'t exist.'));
		}

		$term_default = array(
			'description' => '',
			'parent' => 0,
			'slug' => ''
		);

		foreach ( $terms as $slug => $term_params ) {

			$term = array_merge($term_default, $term_params, array('slug' => $slug));

			if ( empty($term['name']) ) {
				throw new Exception(__('\'name\' is required.'));
			}

			$name = $term['name'];
			unset($term['name']);

			$result = wp_insert_term($name, $taxonomy, $term);

			if ( is_wp_error($result) ) {
				throw new Exception($result->get_error_message());
			}
		}
	}

	public static function remove($taxonomy, array $terms) {

		if ( ! taxonomy_exists($taxonomy)) {
			throw new Exception(__('Taxonomy doesn\'t exist.'));
		}

		foreach ( $terms as $term_identify ) {

			if ( is_string($term_identify) ) {
				$term_id = get_term_by('slug', $term_identify, $taxonomy)->term_id;
			} elseif ( is_int($term_identify) ) {
				$term_id = $term_identify;
			} else {
				throw new Exception('Invalid term identify.');
			}

			$result = wp_delete_term($term_id, $taxonomy);

			if ( is_wp_error($result) ) {
				throw new Exception($result->get_error_message());
			}
		}
	}
}