<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;
$total = (WC()->cart->cart_contents_total*16)/100;
?>
<div class="col-md-6">
	<div class="cart-notify">
		<img src="<?php echo get_template_directory_uri();?>/images/5n2Y.gif" style="width: 150px">
		<p><b><?php echo __( 'Thank you for your purchase!', 'boss' ); ?></b></p>
		<p><span style="font-size: 30px;color: #000;font-weight: 900;"><?php echo $total;?></span> so'm foyda mablag'ini farzandingiz bilimini rivojlantirish uchun qaytarib oling.</p>
		<p><?php echo __( 'Sincerely, BOQIY.UZ TEAM.', 'boss' ); ?></p>
		
	</div>
	
</div>
<div class="cart_totals col-md-6 <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	

	<ul class="shop_table shop_table_responsive">

		<li class="cart-subtotal">
			<div><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
			<div data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
				<?php wc_cart_totals_subtotal_html(); ?>
			</div>
		</li>
		

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<li><?php wc_cart_totals_shipping_html(); ?></li>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

			<li class="shipping">
				<div><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></div>
				<div data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></div>
			</li>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<li class="fee">
				<div><?php echo esc_html( $fee->name ); ?></div>
				<div data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></div>
			</li>
		<?php endforeach; ?>


		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<li class="order-total">
			<div><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
			<div data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></div>
		</li>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</ul>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>

