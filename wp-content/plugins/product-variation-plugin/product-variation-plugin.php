<?php
/*
Plugin Name: Product Variation Plugin
Plugin URI: https://example.com/
Description: Плагин для преобразования продуктов в вариативные и добавления атрибутов.
Version: 1.0
Author: Your Name
Author URI: https://example.com/
License: GPL2
*/



// Добавление действия для перемещения продукта в бесплатную категорию после оформления заказа
add_action('woocommerce_thankyou', 'move_product_to_free_category', 10, 1);

function move_product_to_free_category($order_id) {
    if (!$order_id) return;

    $order = wc_get_order($order_id);

    foreach ($order->get_items() as $item) {
        $product_id = $item->get_product_id();
        $product = wc_get_product($product_id);

        if (has_term('homiylik', 'product_cat', $product_id)) {
            // Делаем товар вариативным
            make_product_variation($product);
        }
    }
}

// Функция для создания вариаций продукта
function make_product_variation($product) {
    // Получаем все глобальные атрибуты
    $global_attributes = wc_get_attribute_taxonomies();
    $found_attribute = null;

    // Ищем атрибут с именем "tip-czeny"
    foreach ($global_attributes as $attribute) {
        if ($attribute->attribute_name == 'tip-czeny') {
            $found_attribute = $attribute;
            break;
        }
    }

    if ($found_attribute) {
        // Убедимся, что термины "Оплата бонусом" и "Стандартная Оплата" существуют
        $attribute_taxonomy = 'pa_' . $found_attribute->attribute_name;
        $terms = array('Оплата бонусом', 'Стандартная Оплата');

        foreach ($terms as $term) {
            if (!term_exists($term, $attribute_taxonomy)) {
                wp_insert_term($term, $attribute_taxonomy);
            }
        }

        // Получаем ID терминов
        $term_ids = [];
        foreach ($terms as $term) {
            $term_obj = get_term_by('name', $term, $attribute_taxonomy);
            if ($term_obj) {
                $term_ids[] = $term_obj->term_id;
            }
        }

        // Создаем новый вариативный продукт
        $new_product = new WC_Product_Variable();
        $new_product->set_props(array(
            'name' => $product->get_name(),
            'slug' => $product->get_slug(),
            'date_created' => $product->get_date_created(),
            'date_modified' => $product->get_date_modified(),
            'status' => $product->get_status(),
            'featured' => $product->get_featured(),
            'catalog_visibility' => $product->get_catalog_visibility(),
            'description' => $product->get_description(),
            'short_description' => $product->get_short_description(),
            'sku' => $product->get_sku(),
            'menu_order' => $product->get_menu_order(),
            'virtual' => $product->get_virtual(),
            'tax_status' => $product->get_tax_status(),
            'tax_class' => $product->get_tax_class(),
            'manage_stock' => $product->get_manage_stock(),
            'stock_quantity' => $product->get_stock_quantity(),
            'stock_status' => $product->get_stock_status(),
            'backorders' => $product->get_backorders(),
            'sold_individually' => $product->get_sold_individually(),
            'weight' => $product->get_weight(),
            'length' => $product->get_length(),
            'width' => $product->get_width(),
            'height' => $product->get_height(),
            'upsell_ids' => $product->get_upsell_ids(),
            'cross_sell_ids' => $product->get_cross_sell_ids(),
            'parent_id' => $product->get_parent_id(),
            'reviews_allowed' => $product->get_reviews_allowed(),
            'purchase_note' => $product->get_purchase_note(),
            'menu_order' => $product->get_menu_order(),
            'image_id' => $product->get_image_id(), // Копируем изображение
            'gallery_image_ids' => $product->get_gallery_image_ids(), // Копируем галерею изображений
        ));

        // Добавляем атрибут "Тип цены" к новому продукту
        $attributes = [];
        $new_attribute = new WC_Product_Attribute();
        $new_attribute->set_id($found_attribute->attribute_id);
        $new_attribute->set_name($attribute_taxonomy);
        $new_attribute->set_options($term_ids); // указываем ID терминов
        $new_attribute->set_position(0);
        $new_attribute->set_visible(true);
        $new_attribute->set_variation(true);

        $attributes[] = $new_attribute; 

        $new_product->set_attributes($attributes);
        $new_product->save();

        // Удаляем старый продукт
        $translated_id = pll_get_post($product->get_id(), 'ru');

        // wp_delete_post($product->get_id(), true);
        // wp_delete_post($translated_id, true);

        wp_set_object_terms($new_product->get_id(), 'tekin-mahsulotlar', 'product_cat', false);

        // Создаем вариации
        create_product_variations($new_product->get_id(), $attribute_taxonomy, $terms, $product->get_regular_price());

        // Создаем переводы для нового вариативного продукта
        $languages = pll_languages_list(); // Получаем список поддерживаемых языков
        foreach ($languages as $locale) {
            if ($locale != 'uz') { // Предполагая, что основной язык - узбекский
                $translated_product_data = array(
                    'name' => $product->get_name() . ' (' . $locale . ')', // Пример переведенного имени продукта
                    'slug' => $product->get_slug() . '-' . $locale,
                    'description' => $product->get_description(),
                    'short_description' => $product->get_short_description(),
                    'status' => 'publish',
                    'regular_price' => $product->get_regular_price(),
                    'sale_price' => $product->get_sale_price(),
                    'manage_stock' => $product->get_manage_stock(),
                    'stock_quantity' => $product->get_stock_quantity(),
                    'stock_status' => $product->get_stock_status(),
                    'image_id' => $product->get_image_id(), // ID изображения для перевода
                    'gallery_image_ids' => $product->get_gallery_image_ids(), // IDs галереи изображений для перевода
                );

                $new_category = 'tovary-dlya-ballov'; // Новая категория для перевода
                create_product_translation($new_product->get_id(), $translated_product_data, $locale, $new_category, $attributes);
            }
        }
    } else {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error is-dismissible">
                    <p>Глобальный атрибут "Тип цены" не найден.</p>
                  </div>';
        });
    }
}

// Функция для создания вариаций продукта
function create_product_variations($product_id, $attribute_taxonomy, $terms, $base_price) {
    $new_price = $base_price * 1.15;
    foreach ($terms as $term) {
        $term_slug = get_term_by('name', $term, $attribute_taxonomy)->slug;
        $variation = new WC_Product_Variation();
        $variation->set_parent_id($product_id);
        $variation->set_attributes(array($attribute_taxonomy => $term_slug));
        $variation->set_regular_price($new_price); // Установите цену для каждой вариации, если требуется
        if ($term == 'Стандартная Оплата') {
            $variation->set_sale_price('0');
        }
        $variation->set_manage_stock(true);
        $variation->set_stock_quantity(10); // Установите количество на складе для каждой вариации, если требуется
        $variation->set_stock_status('instock'); // Устанавливаем статус наличия
        $variation->save();
    }
}

// Функция для создания перевода продукта
function create_product_translation($product_id, $translated_product_data, $locale, $new_category, $attributes) {
    // Создаем перевод продукта
    $translated_product = new WC_Product_Variable();
    $translated_product->set_props($translated_product_data);
    $translated_product->set_attributes($attributes);
    $translated_product->save();

    wp_set_object_terms($translated_product->get_id(), 'tovary-dlya-ballov', 'product_cat', false);

    // Устанавливаем связь перевода с оригинальным продуктом
    pll_set_post_language($translated_product->get_id(), $locale);
    pll_save_post_translations(array(
        'uz' => $product_id,
        $locale => $translated_product->get_id(),
    ));

    // Устанавливаем новую категорию для переведенного продукта
    wp_set_object_terms($translated_product->get_id(), $new_category, 'product_cat', false);

    // Получаем вариации оригинального продукта
    $original_variations = wc_get_products(array(
        'parent' => $product_id,
        'type' => 'variation',
    ));

    // Переводим каждую вариацию
    foreach ($original_variations as $original_variation) {
        $variation_data = array(
            'parent_id' => $translated_product->get_id(),
            'attributes' => $original_variation->get_attributes(),
            'regular_price' => $original_variation->get_regular_price(),
            'sale_price' => $original_variation->get_sale_price(),
            'manage_stock' => $original_variation->get_manage_stock(),
            'stock_quantity' => $original_variation->get_stock_quantity(),
            'stock_status' => $original_variation->get_stock_status(),
        );

        $translated_variation = new WC_Product_Variation();
        $translated_variation->set_props($variation_data);
        $translated_variation->save();

        // Устанавливаем связь перевода вариации с оригинальной вариацией
        pll_set_post_language($translated_variation->get_id(), $locale);
        pll_save_post_translations(array(
            'uz' => $original_variation->get_id(),
            $locale => $translated_variation->get_id(),
        ));
    }
}

