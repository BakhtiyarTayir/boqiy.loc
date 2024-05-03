<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$children = $product->get_children();
?>

<?php 
    if(!empty($product->get_stock_quantity())){ ?>
        <p class="stock <?php echo esc_attr( $class ); ?>">Mavjud: <?php echo $product->get_stock_quantity(); ?></p>
    <?php }
?>


<?php if ( isset($children) && !empty($children) ) { ?>
	<div class="price_block">
		<ins><?php echo $product->get_variation_price().' '.get_woocommerce_currency_symbol();?></ins>
		<del><?php echo $product->get_variation_price('max').' '.get_woocommerce_currency_symbol();?></del>
	</div>
<?php } else{ ?>
	<div class="price_block">
		<ins><?php echo $product->get_price_html();?></ins>
	</div>
<?php }  ?>
