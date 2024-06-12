<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WC_Ad_Form {
    const PRICE_PER_VIEW = 18;
    const INITIAL_VIEWS = 1000;

    public function __construct() {
        add_action('woocommerce_before_add_to_cart_button', [$this, 'display_ad_buttons']);
        add_action('woocommerce_add_to_cart', [$this, 'save_ad_form_data'], 10, 2);
        add_action('woocommerce_checkout_create_order_line_item', [$this, 'add_ad_data_to_order_items'], 10, 4);
        add_action('woocommerce_order_item_meta_end', [$this, 'display_ad_data_in_admin_order'], 10, 3);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('woocommerce_thankyou', [$this, 'add_initial_views'], 10, 1);
    }

    public function enqueue_scripts() {
        // wp_enqueue_script('wc-ad-form-script', plugins_url('../js/wc-ad-form.js', __FILE__), ['jquery'], null, true);
        wp_enqueue_style('wc-ad-form-style', plugins_url('../css/wc-ad-form.css', __FILE__));
        wp_enqueue_script('wc-ad-form', plugins_url('../js/wc-ad-form.js', __FILE__), array('jquery'), null, true);

        // Передача nonce в JavaScript
        wp_localize_script('wc-ad-form', 'wc_ad_form_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'placement_nonce' => wp_create_nonce('placement_nonce')
        ));
    }


    public function display_ad_buttons() 
    {
        global $product;
        if (has_term('homiylik', 'product_cat', $product->get_id())) {
            ?>
            <div class="ad-buttons">
                <button type="button" id="public_ad_btn">Ommaviy</button>
                <button type="button" id="anonymous_ad_btn">Anonim</button>
                <button type="button" id="paid_ad_btn">Pullik reklama</button>
            </div>

            <div id="public_ad_modal" class="ad-modal">
                <div class="ad-modal-content">
                    <span class="close" data-modal="public_ad_modal">&times;</span>
                    <div class="ad-form-wrapper">
                        <div class="ad-form">
                            <h3>Ommaviy reklama uchun ma'lumotlarni kiriting</h3>
                            <p>
                                <input type="text" id="ad_title_public" placeholder="Ismingiz yoki Brendingiz nomi (masalan Abdullayevlar oilasi)" name="ad_title_public" />
                            </p>
                            <p>
                                <input type="file" id="ad_image_public"  placeholder="Rasm" name="ad_image_public" accept="image/*" />
                            </p>
                            <p>
                                <input type="text" id="ad_phone_public"  placeholder="Telefon raqamingiz" name="ad_phone_public" />
                            </p>
                            <p>
                                <input type="text" id="ad_social_links_public" placeholder="Sayt yoki ijtimoiy tarmoq havola " name="ad_social_links_public" />
                            </p>
                            <p>Ko'rishlar soni 1000</p>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div id="anonymous_ad_modal" class="ad-modal">
                <div class="ad-modal-content">
                    <span class="close" data-modal="anonymous_ad_modal">&times;</span>
                    <div class="ad-form-wrapper">
                        <div class="ad-form">
                            <h3>Anonim homiylik uchun ma'lumotlarni kiriting</h3>
                            <p>
                                <input type="text" id="ad_title_anonymous" placeholder="Ismingiz yoki Brendingiz nomi (masalan Abdullayevlar oilasi)" name="ad_title_anonymous" />
                            </p>
                            <p>
                                <input type="text" id="ad_phone_anonymous" placeholder="Telefon raqamingiz" name="ad_phone_anonymous" />
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="paid_ad_modal" class="ad-modal">
                <div class="ad-modal-content">
                    <span class="close" data-modal="paid_ad_modal">&times;</span>
                    <div class="ad-form-wrapper">
                        <div class="ad-form">
                            <h3>Pullik reklama uchun ma'lumotlarni kiriting</h3>

                            <p>
                                <input type="text" id="ad_title_paid" placeholder="Ismingiz yoki Brendingiz nomi (masalan Abdullayevlar oilasi)" name="ad_title_paid" />
                            </p>
                            <p>
                                <input type="file" id="ad_image_paid" placeholder="Rasm" name="ad_image_paid" accept="image/*" />
                            </p>
                            <p>
                                <input type="text" id="ad_social_links_paid" placeholder="Sayt yoki ijtimoiy tarmoq havola" name="ad_social_links_paid" />
                            </p>
                            <p>
                                <label for="ad_views_paid">ko‘rishlar soni</label>
                                <select id="ad_views_paid" name="ad_views_paid">
                                    <?php
                                    for ($i = 10000; $i <= 90000; $i += 10000) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </p>
                            <p>
                                <label for="ad_total_price_paid">Umumiy narx (sumda)</label>
                                <input type="text" id="ad_total_price_paid" name="ad_total_price_paid" readonly />
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    public function save_ad_form_data($cart_item_key, $product_id) {
        if (isset($_POST['ad_title']) && isset($_POST['ad_social_links']) && isset($_POST['ad_views'])) {
            $additional_views = intval($_POST['ad_views']);
            $total_views = self::INITIAL_VIEWS + $additional_views;
            $total_price = $additional_views * self::PRICE_PER_VIEW;

            $ad_data = [
                'title' => sanitize_text_field($_POST['ad_title']),
                'social_links' => sanitize_text_field($_POST['ad_social_links']),
                'views' => $total_views,
                'total_price' => $total_price,
            ];

            if (!empty($_FILES['ad_image']['name'])) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                $uploaded_file = wp_handle_upload($_FILES['ad_image'], ['test_form' => false]);
                if (isset($uploaded_file['url'])) {
                    $ad_data['image'] = esc_url($uploaded_file['url']);
                }
            }

            WC()->session->set('ad_data_' . $product_id, $ad_data);
        }
    }

    public function add_ad_data_to_order_items($item, $cart_item_key, $values, $order) {
        $product_id = $values['product_id'];
        $ad_data = WC()->session->get('ad_data_' . $product_id);
        if ($ad_data) {
            $item->add_meta_data('Ad Data', $ad_data);
            WC()->session->__unset('ad_data_' . $product_id);
        }
    }

    public function display_ad_data_in_admin_order($item_id, $item, $order) {
        $ad_data = $item->get_meta('Ad Data');
        if ($ad_data) {
            echo '<p><strong>Ad Data:</strong></p>';
            if (isset($ad_data['image'])) {
                echo '<p><img src="' . esc_url($ad_data['image']) . '" style="max-width: 100px;" /></p>';
            }
            echo '<p>Nomi: ' . esc_html($ad_data['title']) . '</p>';
            echo '<p>Ijtimoiy tarmoqlarga havola: ' . esc_html($ad_data['social_links']) . '</p>';
            echo '<p>Ko‘rishlar soni: ' . intval($ad_data['views']) . '</p>';
            echo '<p>Umumiy narx: ' . intval($ad_data['total_price']) . ' sum</p>';
        }
    }

    public function add_initial_views($order_id) {
        $order = wc_get_order($order_id);
        foreach ($order->get_items() as $item_id => $item) {
            $ad_data = $item->get_meta('Ad Data');
            if ($ad_data) {
                $ad_data['views'] += self::INITIAL_VIEWS;
                $item->update_meta_data('Ad Data', $ad_data);
                $item->save();
            }
        }
    }
}

