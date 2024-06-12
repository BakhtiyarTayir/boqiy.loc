<?php
add_action('woocommerce_thankyou', 'move_product_to_correct_category', 10, 1);

function move_product_to_correct_category($order_id) {
    if (!$order_id) return;

    $order = wc_get_order($order_id);

    foreach ($order->get_items() as $item) {
        $product_id = $item->get_product_id();
        $product = wc_get_product($product_id);

        if (has_term('homiylik', 'product_cat', $product_id)) {
            // Удаляем все категории у оригинального продукта
            wp_remove_object_terms($product_id, 'homiylik', 'product_cat');
            // Добавляем товар в категорию "tekin-mahsulotlar"
            wp_set_object_terms($product_id, 'tekin-mahsulotlar', 'product_cat', true);

            
        } 
    } 
}