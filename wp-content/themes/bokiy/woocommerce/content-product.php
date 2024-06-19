<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;


global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$current_product_id = get_the_ID();
$product = wc_get_product( $current_product_id );
if('onbackorder' === $product->get_meta( '_stock_status' )){
	$stock_text = __('Pre-order', 'boss');
	$stock_class = "#34D374";
} elseif('outofstock' === $product->get_meta( '_stock_status' )){
	$stock_text = __('Not available', 'boss');
	$stock_class = "#d9663b";
}else{
	if($product->get_stock_status()){
		$stock_text = __('In stock', 'boss');
		$stock_class = "#34D374";
	} else {
		$stock_text = __('Not available', 'boss');
		$stock_class = "#d9663b";
	}
}

$newness_days = 15;
$created = strtotime( $product->get_date_created() );
$count = get_post_meta(get_the_ID(),'total_sales', true);

$badge_text='';
$badge_class='';
if($product->is_on_sale()){
	if ($product->sale_price){
		$percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
	}
	$badge_text = __('Sale - ', 'boss'). $percentage.'%';
	$badge_class= "salest";
} else if($count>0){
	$badge_text = __('TOP', 'boss');
	$badge_class= "top";
}  else if(( time() - ( 60 * 60 * 24 * $newness_days ) ) < $created){
	$badge_text = __('Newest', 'boss');
	$badge_class= "newest";
} 
?>
<li <?php wc_product_class( 'col-md-3 mb-4 col-6 styles_container__3wHdd', $product ); ?>>
	<div class="product-thumb transition">
	 
	   <div class="masterTooltip masterTooltip image" title="<?php echo get_the_title();?>">		   
		  	<a href="<?php echo get_post_permalink(); ?>">
				<img alt="<?php echo get_the_title();?>" class="w-100 img-responsive" src="<?php the_post_thumbnail_url();?>">
			</a>
	   </div>
	   <h4>
			<a class="masterTooltip masterTooltip" href="<?php echo get_post_permalink(); ?>" title="<?php echo get_the_title();?>">
				<?php echo get_the_title();?>
			</a>
		</h4>
	
	   <div class="row buttons-row">
		  <div class="col-sm-12">		  		 
			
		  <?php 
				if ($product->is_type( 'simple' )) {
					if ($product->is_on_sale()) {
					?>
					<p class="mb-0">
							<b class="price-old ml-0"><?php echo wc_price($product->get_regular_price()) ?></b>
							<span class="stock" style="color:<?php echo $stock_class; ?>"><?php echo $stock_text; ?></span>	
						</p>
						<p class="price price-new"><?php echo wc_price($product->get_sale_price()); 
				  } else {
					?>
					<p class="stock" style="color:<?php echo $stock_class; ?>"><?php echo $stock_text; ?></p>	 
					<p class="price price-new">
					<?php $training_fee = $product->get_price() * 0.16; ?>
			  		<p><?php echo number_format( $training_fee, 0, '.', ' ' ) . ' ' . __( 'sum', 'boss' ); echo ' ' . __('ta\'lim uchun', 'boss') ?></p>	
					
					<?php echo number_format($product->get_regular_price(), 0, '.', ' ').' '.__('sum', 'boss');
				
				  }
				} elseif($product->product_type=='variable'){
					$available_variations = $product->get_available_variations();
					$count = count($available_variations)-1;
					$variation_id=$available_variations[$count]['variation_id']; // Getting the variable id of just the 1st product. You can loop $available_variations to get info about each variation.
					$variable_product1= new WC_Product_Variation( $variation_id );
					$children = $product->get_children();
					$regular_price = $variable_product1 ->regular_price;
					$sales_price =$product->get_variation_sale_price( 'min', true );
					

					?>
					<p class="stock" style="color:<?php echo $stock_class; ?>"><?php echo $stock_text; ?></p>	 
					<p class="price price-new">
					<?php echo $sales_price.' '.__('sum', 'boss');
					
				}
				?>
			</p>
		  </div>
		  <div class="col-sm-12 ">
			 <div class="button-group">
			     <?php 
				 echo apply_filters( 'woocommerce_loop_add_to_cart_link',
				 sprintf( '<a href="%s" data-quantity="%s" class="woo_loop_btn %s"%s %s>%s</a>',
					 esc_url( $product->add_to_cart_url() ),
					 esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),		
					 esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
					 $product->get_type() =='external' ? ' target="_blank" rel="nofollow sponsored"' : '',
					 isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
					 esc_html( $product->add_to_cart_text() )
				 ),
			 $product, $args );
				 ?>
			 </div>
		  </div>
	   </div>
	</div>	
</li>
