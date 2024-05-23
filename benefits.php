<?php 
/* Plugin name: Преимущества компании */

if (!defined('WPINC')) {
    die;
}

function my_plugin_menu() {
    add_menu_page(
        'Преимущества компании',
        'Преимущества',
        'manage_options',
        'my-plugin',
        'my_plugin_callback'
    );
}


function my_plugin_callback() {
    ?>
    <div class="wrap">
        <h1>Преимущества компании</h1>

        <h2>Добавить новый блок</h2>
        <form method="post" action="">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="block_title">Заголовок:</label></th>
                        <td><input type="text" id="block_title" name="block_title" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="block_text">Текст:</label></th>
                        <td><textarea id="block_text" name="block_text" class="large-text"></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="block_image">Изображение:</label></th>
                        <td>
                            <input type="file" id="block_image" name="block_image" accept="image/*">
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php wp_nonce_field('my_plugin_add_block', 'my_plugin_nonce'); ?>
            <input type="submit" name="submit" class="button button-primary" value="Добавить">
        </form>

        <h2>Список блоков</h2>
        <?php
        $blocks = get_option('my_plugin_blocks', array());
        if (!empty($blocks)) {
            echo '<ul>';
            foreach ($blocks as $block) {
                echo '<li>';
                echo '<strong>' . esc_html($block['title']) . '</strong>';
                echo '<p>' . esc_html($block['text']) . '</p>';
                if (!empty($block['image'])) {
                    echo '<img src="' . esc_url($block['image']) . '" alt="' . esc_attr($block['title']) . '">';
                }
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Список блоков пуст.</p>';
        }
        
}

add_action('admin_post_my_plugin_add_block', 'my_plugin_add_block');
function my_plugin_add_block() {
    if (!wp_verify_nonce($_POST['my_plugin_nonce'], 'my_plugin_add_block')) {
        wp_die('Ошибка безопасности.');
    }

    $blocks = get_option('my_plugin_blocks', array());
    $block = array(
        'title' => sanitize_text_field($_POST['block_title']),
        'text' => wp_kses_post($_POST['block_text']),
        'image' => '',
    );


    if (!empty($_FILES['block_image']['name'])) {
        $upload = wp_upload_bits($_FILES['block_image']['name'], null, file_get_contents($_FILES['block_image']['tmp_name']));
        if (!isset($upload['error'])) {
            $block['image'] = $upload['url'];
        }
    }

    $blocks[] = $block;
    update_option('my_plugin_blocks', $blocks);

    wp_redirect(admin_url('admin.php?page=my-plugin'));
    exit;
}

add_action('admin_menu', 'my_plugin_menu');

function my_plugin_display_block($block) {
    $output = "<div class='my-plugin-block'>
        <h2>{$block['title']}</h2>
        <p>{$block['text']}</p>";
    if (!empty($block['image'])) {
        $output .= "<img src='" . esc_url($block['image']) . "' alt='" . esc_attr($block['title']) . "'>";
    }
    $output .= "</div>";
    return $output;
}


$blocks = get_option('my_plugin_blocks', array());
if (!empty($blocks)) {
    foreach ($blocks as $block) {
        my_plugin_display_block($block);
    }
}

?>