<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}



class WC_Ad_Form {
    const PRICE_PER_VIEW = 18;
    const INITIAL_VIEWS = 1000;

    
    public function __construct() {
        
        add_action('woocommerce_before_add_to_cart_button', [$this, 'display_ad_buttons']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

        add_action('wp_ajax_save_ad_data', [$this, 'save_ad_data_callback']);
        add_action('wp_ajax_nopriv_save_ad_data', [$this, 'save_ad_data_callback']);

        add_filter('woocommerce_add_cart_item_data', [$this, 'add_custom_price_field'], 10, 2);
        add_action('woocommerce_before_calculate_totals', [$this, 'add_custom_price_to_cart_item']);
        add_filter('woocommerce_get_item_data', [$this, 'display_custom_price_cart'], 10, 2);

    }


    public function enqueue_scripts() {
        wp_enqueue_style('wc-ad-form-style', plugins_url('../css/wc-ad-form.css', __FILE__));
        wp_enqueue_script('wc-ad-form', plugins_url('../js/wc-ad-form.js', __FILE__), array('jquery'), null, true);

        wp_enqueue_script('save_ad_data', plugins_url('../js/ad-form.js', __FILE__), ['jquery'], null, true);

        wp_localize_script('save_ad_data', 'adFormAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('save_ad_data-nonce'),
            'checkout_url' => wc_get_checkout_url()
        ));
        wp_localize_script('wc-ad-form', 'wc_add_to_cart_params', [
            'cart_url' => wc_get_cart_url(),
            'checkout_url' => wc_get_checkout_url()
        ]);
    }


    public function add_custom_price_field($cart_item_data, $product_id) {
        if (isset($_GET['total_price'])) {
            $cart_item_data['total_price'] = floatval($_GET['total_price']);
        }
        return $cart_item_data;
    }

    public function add_custom_price_to_cart_item($cart) {
        if (is_admin() && !defined('DOING_AJAX')) {
            return;
        }

        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            if (isset($cart_item['total_price'])) {
                $original_price = $cart_item['data']->get_price();
                $additional_price = $cart_item['total_price'];
                $new_price = $original_price + $additional_price;
                $cart_item['data']->set_price($new_price);
            }
        }
    }

    public function display_custom_price_cart($item_data, $cart_item) {
        if (isset($cart_item['total_price'])) {
            $item_data[] = array(
                'name' => __('Additional Price', 'textdomain'),
                'value' => wc_price($cart_item['total_price']),
            );
        }
        return $item_data;
    }




    public function save_ad_data_callback() {
        // Проверяем, был ли отправлен запрос через AJAX
        if (!wp_doing_ajax()) {
            wp_send_json_error('This is not an AJAX request.');
        }
    
        // Получаем данные из AJAX запроса
        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $ad_data_json = isset($_POST['ad_data']) ? wp_unslash($_POST['ad_data']) : '';
        $ad_data = json_decode($ad_data_json, true);
        file_put_contents('ad_data_test.txt', 'test');
        file_put_contents('ad_data.txt', $ad_data);

        if (isset($_FILES['ad_image'])) {
            // Получаем директорию загрузок в WordPress
            $upload_dir_info = wp_upload_dir();
            $upload_dir = $upload_dir_info['basedir'];
            $upload_url = $upload_dir_info['baseurl'];
            
            // Определяем текущий год и месяц
            $year = date('Y');
            $month = date('m');
            
            // Полный путь для загрузки файлов
            $upload_path = "{$upload_dir}/{$year}/{$month}/";
            $upload_url_path = "{$upload_url}/{$year}/{$month}/";
            
            // Проверяем и создаем директорию, если она не существует
            if (!file_exists($upload_path)) {
                mkdir($upload_path, 0755, true);
            }
            
            // Проверка MIME-типа файла
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_type = mime_content_type($_FILES['ad_image']['tmp_name']);
            
            if (!in_array($file_type, $allowed_types)) {
                $response['data'] = 'Недопустимый формат файла';
                echo json_encode($response);
                exit;
            }
            
            // Получение расширения файла
            $file_ext = pathinfo($_FILES['ad_image']['name'], PATHINFO_EXTENSION);
            
            // Генерация уникального имени файла с исходным расширением
            $unique_name = uniqid() . '.' . $file_ext;
            $upload_file = $upload_path . $unique_name;
            
            // Перемещение загруженного файла
            if (move_uploaded_file($_FILES['ad_image']['tmp_name'], $upload_file)) {
                $ad_data['image'] = $upload_url_path . $unique_name;
                
                // Создание текстового файла
                $text_file = $upload_path . 'info.txt';
                $content = "Файл загружен: " . date('Y-m-d H:i:s') . "\nИмя файла: " . $unique_name;
                file_put_contents($text_file, $content);
                
            } else {
                $response['data'] = 'Ошибка при загрузке файла';
                echo json_encode($response);
                exit;
            }
        }
        
        
        // Проверяем, что данные получены корректно
        if (!$product_id || !$ad_data) {
            wp_send_json_error('Invalid data received.');
        }
    
        WC()->session->set('ad_data_' . $product_id, $ad_data);


    
        // Дополнительные данные для отправки в ответе
        $response_data = array(
            'product_id' => $product_id,
            'ad_data' => $ad_data,
            'message' => 'Ad data saved successfully!'
        );
    
        // Сообщаем об успешном сохранении данных и отправляем дополнительные данные
        wp_send_json_success($response_data); 
    }
    


    public function display_ad_buttons() {
        global $product;
        if (has_term('homiylik', 'product_cat', $product->get_id())) {
            ?>
            <div class="ad-buttons">
                <button type="button" id="public_ad_btn">Ommaviy</button>
                <button type="button" id="anonymous_ad_btn">Anonim</button>
                <button type="button" id="paid_ad_btn">Pullik reklama</button>
            </div>

            <?php $this->render_modal('public', 'Ommaviy reklama uchun ma\'lumotlarni kiriting'); ?>
            <?php $this->render_modal('anonymous', 'Anonim homiylik uchun ma\'lumotlarni kiriting'); ?>
            <?php $this->render_modal('paid', 'Pullik reklama uchun ma\'lumotlarni kiriting', true); ?>
            <?php
        }
    }

    
    
    private function render_modal($type, $title, $has_price = false) {
        global $product;
        ?>
        <div id="<?php echo $type; ?>_ad_modal" class="ad-modal">
            <div class="ad-modal-content">
                <span class="close" data-modal="<?php echo $type; ?>_ad_modal">&times;</span>
                <div class="ad-form-wrapper">
                    <div class="ad-form">
                        <h3><?php echo $title; ?></h3>
                        <p>
                            <input type="text" id="ad_title_<?php echo $type; ?>" placeholder="Ismingiz yoki Brendingiz nomi (masalan Abdullayevlar oilasi)" name="ad_title_<?php echo $type; ?>" />
                        </p>
                        <?php if ($type !== 'anonymous') : ?>
                            <p>
                                <input type="file" id="ad_image_<?php echo $type; ?>" placeholder="Rasm" name="ad_image_<?php echo $type; ?>" accept="image/*" />
                            </p>
                        <?php endif; ?>
                        <p>
                            <input type="text" id="ad_phone_<?php echo $type; ?>" placeholder="Telefon raqamingiz" name="ad_phone_<?php echo $type; ?>" />
                        </p>
                        <?php if ($type !== 'anonymous') : ?>
                            <p>
                                <input type="text" id="ad_social_links_<?php echo $type; ?>" placeholder="Sayt yoki ijtimoiy tarmoq havola" name="ad_social_links_<?php echo $type; ?>" />
                            </p>
                        <?php endif; ?>
                        <?php if ($type === 'public') : ?>
                            <p>Ko'rishlar soni 1000</p>
                        <?php elseif ($has_price) : ?>
                            <p>
                                <label for="ad_views_<?php echo $type; ?>">ko'rishlar soni</label>
                                <select id="ad_views_<?php echo $type; ?>" name="ad_views_<?php echo $type; ?>">
                                    <?php
                                    for ($i = 10000; $i <= 90000; $i += 10000) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </p>
                            <p>
                                <label for="ad_total_price_<?php echo $type; ?>">Umumiy narx (sumda)</label>
                                <input type="text" id="ad_total_price_<?php echo $type; ?>" name="ad_total_price_<?php echo $type; ?>" readonly />
                            </p>
                        <?php endif; ?>

                        <div class="quantity-wrapper quantity">
                            <div class="control">
                                <button type="button" class="minus btn-number qtyminus quantity-minus">
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </button>
                                <input type="number" id="quantity_<?php echo $type; ?>" name="quantity_<?php echo $type; ?>" value="1" min="1" />
                                <button type="button" class="plus btn-number qtyplus quantity-plus">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </div>
                             
                        </div>
                        <button type="button" 
                            class="buy-now button save_ad_btn" 
                            data-product-id="<?php echo $product->get_id(); ?>" 
                            data-type="<?php echo $type; ?>
                            "> 
                            <?php echo __('Buy now', 'boss') ?>
                        </button>
                    </div>
                </div> 
            </div> 
        </div>
        <div id="preloader" style="display: none;">
            <div class="spinner-2"></div>
        </div>

        <?php
    } 


}
