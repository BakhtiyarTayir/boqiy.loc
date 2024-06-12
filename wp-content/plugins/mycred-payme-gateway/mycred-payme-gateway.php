<?php
/*
Plugin Name: myCRED Payme Gateway
Description: Плагин для пополнения баланса myCRED через платежный шлюз Payme.
Version: 1.0
Author: Your Name
*/

class Mycred_Payme_Gateway {

    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action('init', array($this, 'payme_init'));
        add_action('template_redirect', array($this, 'handle_payme_response'));
    }

    public function payme_init() {
        add_shortcode('payme_form', array($this, 'render_payme_form'));
    }

    public function render_payme_form() {
        if (!is_user_logged_in()) {
            return '<p>Вы должны войти в систему, чтобы пополнить баланс.</p>';
        }

        ob_start();
        ?>
        <form action="<?php echo esc_url(home_url('/payme-callback')); ?>" method="POST">
            <label for="amount">Сумма пополнения (сум):</label>
            <input type="number" id="amount" name="amount" min="1000" required>
            <button type="submit">Пополнить баланс</button>
        </form>
        <?php
        return ob_get_clean();
    }

    public function handle_payme_response() {
        if (isset($_POST['amount'])) {
            $amount = intval($_POST['amount']);
            $user_id = get_current_user_id();

            if ($amount >= 1000) {
                if ($this->validate_payme_payment()) {
                    mycred_add('balance_recharge', $user_id, $amount, 'Пополнение баланса через Payme', 0, array(), 'mycred_default');
                    wp_redirect(add_query_arg('balance_recharge_success', '1', wp_get_referer()));
                    exit;
                } else {
                    wp_redirect(add_query_arg('balance_recharge_failed', '1', wp_get_referer()));
                    exit;
                }
            } else {
                wp_redirect(add_query_arg('balance_recharge_invalid_amount', '1', wp_get_referer()));
                exit;
            }
        }
    }

    private function validate_payme_payment() {
        // Здесь должна быть логика валидации платежа через Payme
        return true; // Placeholder для фактической логики валидации
    }
}

Mycred_Payme_Gateway::instance();

add_action('wp_footer', function() {
    if (isset($_GET['balance_recharge_success']) && $_GET['balance_recharge_success'] == '1') {
        echo '<p>Баланс успешно пополнен!</p>';
    } elseif (isset($_GET['balance_recharge_failed']) && $_GET['balance_recharge_failed'] == '1') {
        echo '<p>Ошибка пополнения баланса.</p>';
    } elseif (isset($_GET['balance_recharge_invalid_amount']) && $_GET['balance_recharge_invalid_amount'] == '1') {
        echo '<p>Сумма пополнения должна быть не менее 1000 сум.</p>';
    }
});

?>
