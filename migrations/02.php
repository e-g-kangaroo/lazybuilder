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
function migration_02() {
	return array(
		'info' => array(
			'title'        => 'カテゴリの整理',
			'description'  => '新しいカテゴリの追加。及び、不要なカテゴリの削除。',
			'date_created' => '2012-11-15',
		),

		'categories' => array(
			array(
				'change_type'          =>'add',
				'category_name'        => '当たる！',
				'category_nicename'    => 'ataru',
				'category_parent'      => '',
				'category_description' => ''
			),
			array(
				'change_type'          =>'add',
				'category_name'        => 'お出かけ・習い事',
				'category_nicename'    => 'outing',
				'category_parent'      => '',
				'category_description' => ''
			),

			array(
				'change_type'          =>'modufy',
				'category_name'        => 'カフェ・スイーツ・パン',
				'category_nicename'    => 'cafe',
				'category_parent'      => '',
				'category_description' => ''
			),

			array(
				'change_type'          =>'remove',
				'category_name'        => '主婦力アップ！',
				'category_nicename'    => 'shufu',
				'category_parent'      => '',
				'category_description' => ''
			),
		),

		'tags' => array(),

		'regions' => array(),

		'pages' => array(),
	);
}