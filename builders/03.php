<?php

/**
 * 
 * @return array( array($change_type, $category_name, $category_nicename, $category_parent, $category_description), ... )
 *     $change_type          : add or modufy or remove.
 *     $category_name        : category name.
 *     $category_nicename    : caetgory nicename(slug).
 *     $category_parent      : category parent nicename(slug).
 *     $category_description : category description.
 */
function builder_03() {
	return array(
		'info' => array(
			'title'        => 'カテゴリの整理',
			'description'  => '新しいカテゴリの追加。及び、不要なカテゴリの削除。',
			'date_created' => '2012-11-15',
		),

		'category' => array(
			array(
				'change_type' =>'add',
				'name'        => '当たる！',
				'nicename'    => 'ataru',
				'parent'      => '',
				'description' => ''
			),
			array(
				'change_type' =>'add',
				'name'        => 'お出かけ・習い事',
				'nicename'    => 'outing',
				'parent'      => '',
				'description' => ''
			),

			array(
				'change_type' =>'modufy',
				'name'        => 'カフェ・スイーツ・パン',
				'nicename'    => 'cafe',
				'parent'      => '',
				'description' => ''
			),

			array(
				'change_type' =>'remove',
				'name'        => '主婦力アップ！',
				'nicename'    => 'shufu',
				'parent'      => '',
				'description' => ''
			),
		),

		'tag' => array(),

		'region' => array(),

		'page' => array(),
	);
}