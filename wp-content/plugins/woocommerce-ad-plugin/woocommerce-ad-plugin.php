<?php
/*
Plugin Name: WooCommerce Ad Plugin
Plugin URI: https://example.com/
Description: Плагин для управления рекламными данными и копирования товаров в WooCommerce.
Version: 1.0
Author: Your Name
Author URI: https://example.com/
License: GPL2
*/

// Определяем константы для путей
define('MY_COMBINED_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Подключаем файлы с классами
require_once MY_COMBINED_PLUGIN_DIR . 'includes/class-wc-ad-form.php';
require_once MY_COMBINED_PLUGIN_DIR . 'includes/class-wc-product-variation.php';


// Инициализация плагина
function woocommerce_ad_plugin_init() {
    if (class_exists('WC_Ad_Form')) {
        new WC_Ad_Form();
    }  

    if (class_exists('WC_Product_Variation_Copy')) {
        new WC_Product_Variation_Copy();
    }
}
add_action('plugins_loaded', 'woocommerce_ad_plugin_init');



 