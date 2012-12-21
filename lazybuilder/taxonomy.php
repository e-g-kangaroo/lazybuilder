<?php

class LazyBuilder_Taxonomy
{
	public function add($taxonomy, array $terms)
	{
		$term_default = array(
			'description' => '',
			'parent' => 0,
			'slug'
		);

		foreach ( $terms as $slug => $term_params )
		{
			$term = array_merge($term_default, $term_params, array('slug' => $slug));
			$name = $term['name'];
			unset($term['name']);

			wp_insert_term($name, $taxonomy, $term);
		}
	}

	public function remove($taxonomy, array $terms)
	{
		foreach ( $terms as $term_identify )
		{
			if ( is_string($term_identify) ) {
				$term_id = get_term_by('slug', $term_identify, $taxonomy)->term_id;
			}

			if ( is_int($term_identify) ) {
				$term_id = $term_identify;
			}

			wp_delete_term($term_id, $taxonomy);
		}
	}
}