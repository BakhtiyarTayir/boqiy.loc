<?php
/*
Plugin Name: Платная кнопка Нравится для BuddyPress
Description: Добавляет платную функциональность кнопки "Нравится" в BuddyPress, используя баланс myCRED.
Version: 1.0
Author: Ваше имя
*/

// Подключение стилей и скриптов
function bp_paid_likes_scripts() {
    wp_enqueue_script('bp-paid-likes-js', plugin_dir_url(__FILE__) . 'js/bp-paid-likes.js', array('jquery'), '1.0', true);
    wp_localize_script('bp-paid-likes-js', 'bpPaidLikes', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('bp-paid-likes-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'bp_paid_likes_scripts');

// AJAX обработчик для кнопки "Нравится"
function bp_paid_likes_handler() {
    check_ajax_referer('bp-paid-likes-nonce', 'security');

    $user_id = get_current_user_id();
    $post_id = intval($_POST['post_id']);
    $cost = 10; // Стоимость одного лайка

    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Вы должны войти в систему, чтобы ставить лайки.'));
    }

    // Проверка и списание баллов
    if (!mycred_deduct('bp_like', $user_id, $cost, 'Стоимость лайка')) {
        wp_send_json_error(array('message' => 'Недостаточно средств для лайка.'));
    }

    // Логика добавления лайка
    $likes = get_post_meta($post_id, 'bp_likes', true);
    $likes = empty($likes) ? 1 : ++$likes;
    update_post_meta($post_id, 'bp_likes', $likes);

    wp_send_json_success(array('likes' => $likes));
}
add_action('wp_ajax_bp_paid_likes', 'bp_paid_likes_handler');

// Добавление кнопки "Нравится" в шаблоны BuddyPress
function bp_add_like_button() {
    $post_id = bp_get_activity_id();
    echo '<button class="bp-like-button" data-post-id="' . esc_attr($post_id) . '">Нравится</button>';
}
add_action('bp_activity_entry_meta', 'bp_add_like_button');
