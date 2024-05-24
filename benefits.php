<?php 
/* Plugin name: Преимущества компании */

if (!defined('WPINC')) {
    die;
}

add_action( 'init', 'true_register_post_type_init' );
 
function true_register_post_type_init() {
 
  $labels = array(
    'name' => 'Преимущества компании',
    'singular_name' => 'Лид',
    'add_new' => 'Добавить преимущество',
    'add_new_item' => 'Добавить преимущество',
    'edit_item' => 'Редактировать преимущество',
    'new_item' => 'Новое преимущество',
    'all_items' => 'Все блоки',
    'search_items' => 'Искать преимущество',
    'not_found' =>  'Блоков нет',
    'not_found_in_trash' => 'В корзине нет блоков.',
    'menu_name' => 'Преимущества'
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

  // Добавляем шорткод для вывода записей на страницу
  add_shortcode( 'company_advantages', 'company_advantages_shortcode' );
}

function company_advantages_shortcode() {
    $args = array(
        'post_type' => 'lead',
        'posts_per_page' => -1, // Выводим все записи
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        $output = '<div class="company-advantages">';
        while ( $query->have_posts() ) {
            $query->the_post();

            $output .= '<div class="advantage-item">';
            $output .= '<h3>' . get_the_title() . '</h3>';
            $output .= '<p>' . get_the_content() . '</p>';
            $output .= '</div>';
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    } else {
        return 'Нет преимуществ';
    }
}
?>