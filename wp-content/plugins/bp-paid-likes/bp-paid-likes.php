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


function register_like_post_type() {
    $labels = array(
        'name' => 'Лайки',
        'singular_name' => 'Лайк',
        'menu_name' => 'Лайки',
        'name_admin_bar' => 'Лайк',
        'add_new' => 'Добавить новый',
        'add_new_item' => 'Добавить новый Лайк',
        'new_item' => 'Новый Лайк',
        'edit_item' => 'Редактировать Лайк',
        'view_item' => 'Просмотреть Лайк',
        'all_items' => 'Все Лайки',
        'search_items' => 'Искать Лайки',
        'parent_item_colon' => 'Родительский Лайк:',
        'not_found' => 'Лайки не найдены.',
        'not_found_in_trash' => 'В корзине лайки не найдены.',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'like'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
    );

    register_post_type('like', $args);
}
add_action('init', 'register_like_post_type');


function like_meta_boxes() {
    add_meta_box('like_price', 'Цена лайка', 'like_price_callback', 'like', 'side');
}

function like_price_callback($post) {
    wp_nonce_field(basename(__FILE__), 'like_nonce');
    $like_price = get_post_meta($post->ID, '_like_price', true);
    ?>
    <label for="like_price">Цена (сум):</label>
    <input type="number" id="like_price" name="like_price" value="<?php echo esc_attr($like_price); ?>" step="1" min="0">
    <?php
}

function save_like_meta($post_id) {
    if (!isset($_POST['like_nonce']) || !wp_verify_nonce($_POST['like_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    $new_price = (isset($_POST['like_price']) ? sanitize_text_field($_POST['like_price']) : '');

    // Проверка и логирование при сохранении мета-поля
    if ($new_price === '') {
        error_log('Цена лайка не установлена. post_id: ' . $post_id);
    } else {
        error_log('Сохранение цены лайка. post_id: ' . $post_id . ' цена: ' . $new_price);
    }

    update_post_meta($post_id, '_like_price', $new_price);
}



add_action('add_meta_boxes', 'like_meta_boxes');
add_action('save_post', 'save_like_meta');



// AJAX обработчик для кнопки "Нравится"
add_action('wp_ajax_bp_paid_likes', 'bp_paid_likes_handler');
add_action('wp_ajax_nopriv_bp_paid_likes', 'bp_paid_likes_handler');


function bp_paid_likes_handler() {
    check_ajax_referer('bp-paid-likes-nonce', 'security');
    $user_id = get_current_user_id();
    $post_id = intval($_POST['post_id']);
    $like_id = intval($_POST['like_id']);

    if (!is_user_logged_in() || !$user_id) {
        wp_send_json_error(array('message' => 'Вы должны войти в систему, чтобы ставить лайки.'));
        wp_die();
    }

    $like_price = get_post_meta($like_id, '_like_price', true);

    // Логирование для отладки
    if (!$like_price || $like_price <= 0) {
        error_log('Ошибка в цене лайка. like_id: ' . $like_id . ' цена: ' . $like_price);
        wp_send_json_error(array('message' => 'Ошибка в цене лайка. like_id: ' . $like_id . ' цена: ' . $like_price));
        wp_die();
    }

    $user_balance = mycred_get_users_balance($user_id, 'like_points');

    if ($user_balance < $like_price) {
        wp_send_json_error(array('message' => 'У вас недостаточно средств для покупки этого лайка.'));
        wp_die();
    }

    mycred_subtract('like_points_deduction', $user_id, $like_price, 'Покупка лайка', $post_id, array(), 'like_points');

    // Получаем текущие лайки и добавляем новый
    $likes = get_post_meta($post_id, 'like_ids', true);
    if (!$likes) {
        $likes = array();
    }
    $likes[] = $like_id;
    update_post_meta($post_id, 'like_ids', $likes);
    $likes = count($likes);

    wp_send_json_success(array('message' => 'Лайк добавлен! Всего лайков: ' . $likes));
    wp_die();
}



function like_purchase_form() {
    if (!is_user_logged_in()) {
        return '<p>Вы должны войти в систему, чтобы пополнить баланс.</p>';
    }

    ob_start();
    ?>
    <form id="balance-recharge-form" method="post">
        <label for="recharge-amount">Сумма пополнения (сум):</label>
        <input type="number" id="recharge-amount" name="recharge_amount" min="1" required>
        <button type="submit">Пополнить баланс</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('like_purchase_form', 'like_purchase_form');



function handle_balance_recharge() {
    if (!is_user_logged_in() || !isset($_POST['recharge_amount'])) {
        return;
    }

    $user_id = get_current_user_id();
    $recharge_amount = intval($_POST['recharge_amount']);

    if ($recharge_amount > 0) {
        mycred_add('balance_recharge', $user_id, $recharge_amount, 'Пополнение баланса', 0, array(), 'like_points');
        wp_redirect(add_query_arg('balance_recharge_success', '1', wp_get_referer()));
        exit;
    }
}
add_action('init', 'handle_balance_recharge');


function show_balance_recharge_success_message() {
    if (isset($_GET['balance_recharge_success']) && $_GET['balance_recharge_success'] == '1') {
        echo '<p>Баланс успешно пополнен!</p>';
    }
}
add_action('wp_footer', 'show_balance_recharge_success_message');



function bp_add_like_button() {
    $post_id = bp_get_activity_id();
    $like_ids = get_post_meta($post_id, 'like_ids', true);

    echo '<div class="like-container">';
    echo '<button class="bp-like-button" data-post-id="' . esc_attr($post_id) . '">👍 Нравится</button>';
    echo '<div class="like-options">';

    $args = array(
        'post_type' => 'like',
        'posts_per_page' => -1,
    );

    $loop = new WP_Query($args);

    if ($loop->have_posts()) { 
                while ($loop->have_posts()) {
            $loop->the_post();
            $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
            $like_price = get_post_meta(get_the_ID(), '_like_price', true);

            // Логирование для отладки
            if (!$like_price || $like_price <= 0) {
                error_log('Ошибка в цене лайка в цикле. like_id: ' . get_the_ID() . ' цена: ' . $like_price);
            }

            echo '<div class="like-item" data-post-id="' . esc_attr($post_id) . '" data-like-id="' . get_the_ID() . '" data-like-price="' . esc_attr($like_price) . '">';
            echo '<img src="' . esc_url($image_url) . '" alt="' . get_the_title() . '" style="width: 50px; height: 50px;">';
            echo '<p> ' . esc_html($like_price) . ' сум</p>';
            echo '</div>';
        }
            }
    wp_reset_postdata(); 

    echo '</div>';
echo '</div>';

    // // Добавление сохраненных лайков
    // if ($like_ids) {
    //     foreach ($like_ids as $like_id) {
    //         $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($like_id), 'full')[0];
    //         echo '<div class="covered-image magic" style="background-image: url(' . esc_url($image_url) . '); background-size: cover;"></div>';
    //     }
    // }
}
add_action('bp_activity_entry_meta', 'bp_add_like_button', 1);


function bp_add_likes_to_activity_content($content, $activity) {
    // Получаем ID поста активности
    $post_id = $activity->id;



    // Получаем идентификаторы лайков для этого поста
    $like_ids = get_post_meta($post_id, 'like_ids', true); // Предполагается, что они хранятся в мета-поле 'like_ids'

    // Проверяем, есть ли лайки
    if ($like_ids) {
        foreach ($like_ids as $like_id) {
            // Получаем URL изображения для текущего лайка
            $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($like_id), 'full')[0];

            // Создаем разметку
            $covered_image = '<div class="covered-image" style="background-image: url(' . esc_url($image_url) . '); background-size: cover;"></div>';

            // Добавляем разметку в контент
            $content .= $covered_image;
        }
    }

    return $content;
}

// Добавляем наш фильтр к контенту активности
add_filter('bp_get_activity_content_body', 'bp_add_likes_to_activity_content', 10, 2);
