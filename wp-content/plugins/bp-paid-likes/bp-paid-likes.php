<?php
/*
Plugin Name: Платная кнопка Нравится для BuddyPress
Description: Добавляет платную функциональность кнопки "Нравится" в BuddyPress, используя баланс myCRED.
Version: 1.0
Author: boqiy.uz
*/

// Подключение стилей и скриптов
function bp_paid_likes_scripts() {
    wp_enqueue_style('bp-paid-likes-css', plugin_dir_url(__FILE__) . 'css/bp-paid-likes.css');
    wp_enqueue_script('bp-paid-likes-js', plugin_dir_url(__FILE__) . 'js/bp-paid-likes.js', array('jquery'), '1.0', true);
    wp_localize_script('bp-paid-likes-js', 'bpPaidLikes', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('bp-paid-likes-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'bp_paid_likes_scripts');

// AJAX обработчик для кнопки "Нравится"
add_action('wp_ajax_bp_paid_likes', 'bp_paid_likes_handler');
add_action('wp_ajax_nopriv_bp_paid_likes', 'bp_paid_likes_handler');

function bp_paid_likes_handler() {
    // Проверка безопасности и получение данных
    check_ajax_referer('bp-paid-likes-nonce', 'security');
    $user_id = get_current_user_id();
    $post_id = intval($_POST['post_id']);
    $product_id = intval($_POST['product_id']);

    if (!is_user_logged_in() || !$user_id) {
        wp_send_json_error(array('message' => 'Вы должны войти в систему, чтобы ставить лайки.'));
        wp_die();
    }

    $user_likes_balance = mycred_get_users_balance($user_id, 'like_points');
    
    if ($user_likes_balance <= 0) {
        wp_send_json_error(array('message' => 'Пожалуйста, купите лайки для продолжения.'));
        wp_die();
    }

    // Уменьшаем количество доступных лайков
    mycred_subtract('like_points_deduction', $user_id, 1, 'Потрачен лайк', $post_id, array(), 'like_points');

    // Обновление лайков поста
    $likes = (int) get_post_meta($post_id, 'bp_likes', true) + 1;
    update_post_meta($post_id, 'bp_likes', $likes);

    wp_send_json_success(array('message' => 'Лайк добавлен! Всего лайков: ' . $likes));
    wp_die();
}

// Добавление кнопки "Нравится" в шаблоны BuddyPress
function bp_add_like_button() {
    $post_id = bp_get_activity_id();

    // Получаем ID товара WooCommerce, связанного с текущим постом
    $product_id = get_post_meta($post_id, 'like_product_id', true);

    // Вывод кнопки "Нравится"
    echo '<div class="like-container">';
    echo '<button class="bp-like-button" data-post-id="' . esc_attr($post_id) . '" data-product-id="' . esc_attr($product_id) . '">👍 Нравится</button>';

    // Вывод списка лайков как товаров WooCommerce
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,  // Получить все товары
        'product_cat' => 'likes',  // Категория товаров "Лайки"
    );

    $loop = new WP_Query($args);

    if ($loop->have_posts()) { 
        echo '<div class="like-options" >';
        while ($loop->have_posts()) {
            $loop->the_post();
            $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];

            echo '<div class="like-item" data-post-id="' . esc_attr($post_id) . '" data-product-id="' . esc_attr($product_id) . '">';
            echo '<img src="' . esc_url($image_url) . '" alt="' . get_the_title() . '" style="width: 50px; height: 50px;">';
            echo '</div>';
        }
        echo '</div>'; // Закрытие .like-options
    }
    wp_reset_postdata(); 

    echo '</div>'; // Закрытие .like-container
}
add_action('bp_activity_entry_meta', 'bp_add_like_button');

function update_user_likes_on_purchase($order_id) {
    $order = wc_get_order($order_id);
    foreach ($order->get_items() as $item) {
        $product_id = $item->get_product_id();
        // Проверяем, является ли товар лайком
        if (has_term('likes', 'product_cat', $product_id)) {
            $user_id = $order->get_user_id();
            $current_likes = (int) get_user_meta($user_id, 'bp_paid_likes_count', true);
            $quantity = $item->get_quantity();
            mycred_add('like_points_purchase', $user_id, $quantity, 'Покупка лайков', $product_id, array(), 'like_points');
        }
    }
}
add_action('woocommerce_order_status_completed', 'update_user_likes_on_purchase');

