<?php 
/* Plugin name: Преимущества компании */

if (!defined('WPINC')) {
    die;
}

add_action( 'init', 'true_register_post_type_init' );
 
function true_register_post_type_init() {
 
	$labels = array(
		'name' => 'Приемущества компании',
		'singular_name' => 'Лид',
		'add_new' => 'Добавить приемущество',
		'add_new_item' => 'Добавить приемущество',
		'edit_item' => 'Редактировать преимущество',
		'new_item' => 'Новое приемущество',
		'all_items' => 'Все блоки',
		'search_items' => 'Искать приемущество',
		'not_found' =>  'Блоков нет',
		'not_found_in_trash' => 'В корзине нет блоков.',
		'menu_name' => 'Приемущества'
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => false,
		'has_archive' => false,
		'menu_icon' => 'dashicons-email-alt2',
		'menu_position' => 2,
		'supports' => array( 'title', 'editor' )
	);
 
	register_post_type( 'lead', $args );
}
?>