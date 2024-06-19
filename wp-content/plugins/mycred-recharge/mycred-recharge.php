<?php
/*
Plugin Name: Boqiy.uz MyCRED Balance Recharge via WooCommerce
Description: Пополнение баланса myCRED через WooCommerce.
Version: 1.0
Author: Boqiy.uz
*/




add_action('woocommerce_thankyou', 'mycred_show_balance_recharge_success_message');

function mycred_show_balance_recharge_success_message($order_id) {
    $order = wc_get_order($order_id);
    foreach ($order->get_items() as $item) {
        if ($item->get_product()->is_virtual()) {
            echo '<p>Ваш баланс успешно пополнен на ' . $order->get_total() . ' сум!</p>';
            break;
        }
    }
}

// Добавление произвольного поля на страницу товара
add_action('woocommerce_before_add_to_cart_button', 'custom_recharge_amount_field');

function custom_recharge_amount_field() {
    global $product;
    if ($product->is_type('simple') && $product->is_virtual()) {
        echo '<div class="custom-recharge-amount">
                <label for="recharge_amount">Введите сумму пополнения (минимум 1000 сум):</label>
                <input type="number" id="recharge_amount" name="recharge_amount" min="1000" step="100" value="1000" required>
              </div>';
    }
}

// Сохранение произвольного поля в корзине
add_filter('woocommerce_add_cart_item_data', 'save_custom_recharge_amount_field', 10, 2);

function save_custom_recharge_amount_field($cart_item_data, $product_id) {
    if (isset($_POST['recharge_amount'])) {
        $cart_item_data['recharge_amount'] = (int) $_POST['recharge_amount'];
        $cart_item_data['unique_key'] = md5(microtime().rand()); // Чтобы избежать объединения товаров в корзине
    }
    return $cart_item_data;
}

// Отображение произвольного поля в корзине
add_filter('woocommerce_get_item_data', 'display_custom_recharge_amount_field', 10, 2);

function display_custom_recharge_amount_field($item_data, $cart_item) {
    if (isset($cart_item['recharge_amount'])) {
        $item_data[] = array(
            'key' => __('Сумма пополнения'),
            'value' => wc_price($cart_item['recharge_amount'])
        );
    }
    return $item_data;
}

// Изменение цены товара в корзине на указанную сумму пополнения
add_action('woocommerce_before_calculate_totals', 'set_custom_recharge_amount_price', 10, 1);

function set_custom_recharge_amount_price($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;

    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['recharge_amount'])) {
            $cart_item['data']->set_price($cart_item['recharge_amount']);
        }
    }
}


add_action('woocommerce_order_status_completed', 'mycred_recharge_like_points_on_order_complete');

function mycred_recharge_like_points_on_order_complete($order_id) {
    // Получаем заказ
    $order = wc_get_order($order_id);
    
    // Получаем пользователя
    $user_id = $order->get_user_id();
    
    // Проверяем, есть ли пользователь
    if (!$user_id) {
        return;
    }
    
    // Проходим по всем товарам в заказе
    foreach ($order->get_items() as $item) {
        // Проверяем, является ли товар виртуальным
        if ($item->get_product()->is_virtual()) {
            // Получаем сумму пополнения из мета-данных товара
            $recharge_amount = $item->get_meta('recharge_amount');

            // Пополняем баланс like_points
            mycred_add('balance_recharge', $user_id, $recharge_amount, 'Пополнение баланса через WooCommerce', $order_id, array(), 'like_points');
        }
    }
}


// Добавление кнопки "Купить сейчас" на страницу товара
add_action('woocommerce_after_add_to_cart_button', 'add_buy_now_button');

function add_buy_now_button() {
    global $product;
    if ($product->is_type('simple') && $product->is_virtual()) {
        echo '<button type="button" class="buy-now-button button alt" data-product-id="' . $product->get_id() . '">'. __('Buy now', 'boss')     . '</button>';
    }
}

// Добавление скрипта для обработки кнопки "Купить сейчас"
add_action('wp_enqueue_scripts', 'enqueue_buy_now_script');

function enqueue_buy_now_script() {
    if (is_product()) {
        wp_enqueue_script('buy-now-script', plugin_dir_url(__FILE__) . 'js/buy-now.js', array('jquery'), '1.0', true);
        wp_localize_script('buy-now-script', 'buyNow', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
}

// Обработка AJAX-запроса на сервере
add_action('wp_ajax_buy_now', 'handle_buy_now');
add_action('wp_ajax_nopriv_buy_now', 'handle_buy_now');

function handle_buy_now() {
    $product_id = intval($_POST['product_id']);
    $recharge_amount = floatval($_POST['recharge_amount']);

    // Добавляем товар в корзину
    $cart_item_data = array(
        'recharge_amount' => $recharge_amount,
        'unique_key' => md5(microtime().rand())
    );

    $result = WC()->cart->add_to_cart($product_id, 1, 0, array(), $cart_item_data);

    if ($result) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
// Добавление мета-данных в данные заказа
add_action('woocommerce_checkout_create_order_line_item', 'add_recharge_amount_to_order_items', 10, 4);
function add_recharge_amount_to_order_items($item, $cart_item_key, $values, $order) {
    if (isset($values['recharge_amount'])) {
        $item->add_meta_data('recharge_amount', $values['recharge_amount']);
    }
}
