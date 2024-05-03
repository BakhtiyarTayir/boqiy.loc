<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );
function get_instock_products_count($product_id){


    $product = wc_get_product( $product_id );
	$stock_quantity = $product->get_stock_quantity();
    
    return $stock_quantity;
}
?>
	<div class="page-content header-clear-medium">
		<div class="container">

				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>

					<div class="row">
						<section class="more__about mt-3">
							<div class="row mb-40">
								<!-- CAROUSEL NAV  -->
								<div class="col-xl-6 col-md-6 col-sm-12">
									<div class="row imglist">
										<div class="col-lg-12 col-sm-12">
											<div class="slider-more-about-for-wrapper position-relative">
												
												<div
													class="slider slider-more-about-for ">
													<div class="swiper-wrapper" >
													<?php 
														$attachment_ids = $product->get_gallery_image_ids();
														?> <pre> <?php // var_dump($product); ?> </pre> <?php
														if(!empty($attachment_ids)) {
															foreach( $attachment_ids as $attachment_id ) 
															{
															// Display the image URL
															$image_url = wp_get_attachment_url( $attachment_id );
															
															?>
															<a class="swiper-slide item__main-img"
															href="<?php echo $image_url ?>"
															role="group" >
																<img class="img-fluid"
																src="<?php echo $image_url ?>"
																alt="<?php the_title(); ?>">
															</a>
															<?php
															}
														} else {
															?>
															<a class="swiper-slide item__main-img"
															href="<?php the_post_thumbnail_url(); ?>"
															role="group" >
																<img class="img-fluid"
																src="<?php the_post_thumbnail_url(); ?>"
																alt="<?php the_title(); ?>">
															</a>
															<?php
														}										
														?>
													</div>
													<div class="swiper-button-next" ></div>
													<div class="swiper-button-prev" ></div>
													<span class="swiper-notification" aria-live="assertive"
														aria-atomic="true"></span>
												</div>
											</div>
										</div>
										<div class="col-lg-12 d-lg-block mt-3">
											<div class="slider slider-more-about-nav">
												<div class="swiper-wrapper">
													<?php
											
													$attachment_ids = $product->get_gallery_image_ids();													
													if(!empty($attachment_ids)) {
													foreach( $attachment_ids as $attachment_id ) 
														{
														// Display the image URL
														$image_url = wp_get_attachment_url( $attachment_id );
														?>
														<div class="swiper-slide" role="group">
															<div class="item__img">
																<img class="img-fluid" src="<?php echo $image_url ?>">
															</div>
														</div>
														<?php
														}
														} else {
															?>
															<div class="swiper-slide" role="group">
																<div class="item__img">
																	<img class="img-fluid" src="<?php the_post_thumbnail_url(); ?>">
																</div>
															</div>															
															<?php
														}	
													?>
												</div>
												<div class="swiper-button-next"></div>
												<div class="swiper-button-prev"></div>
												<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
											</div>
										</div>
										<!-- CAROUSEL NAV END  -->
									
									</div>
								</div>
								<!-- PRODUCT INFO  -->
								<div class="col-xl-5 col-md-6 col-sm-12">
									<div class="more__about-content">
										<h1 class="product-title"><?php the_title();?></h1>
										
										<?php if ( !$product->is_type( 'variable' ) ) {
											
											?>
										<div class="price-box">
											<span class="price-box_new-price"><span><?php echo $product->get_price(); echo '</span> ' . get_woocommerce_currency_symbol(); ?></span>
										</div>
										<?php }?>
										<?php 
											
										$current_product_id = get_the_ID();
										$product = wc_get_product( $current_product_id );
										$children = $product->get_children();
										
										if('onbackorder' === $product->get_meta( '_stock_status' )){?>
										<div class="text__content d-flex align-items-center mb-3">
											<span class="text__content-title"><?php echo __('Pre-order', 'boss') ?></span>											
										</div> 
										<?}  elseif ('outofstock' === $product->get_meta( '_stock_status' )){?>
											<div class="text__content d-flex align-items-center mb-3">
											<span class="text__content-title" style="color:#f44336">Mavjud emas</span>											
										</div> 
										<?php 
										}
												if(!empty($product->get_stock_quantity())){ ?>
													<p class="stock <?php echo esc_attr( $class ); ?>">Mavjud: <?php echo $product->get_stock_quantity(); ?></p>
												<?php }
											?>


											<?php 
											if ( $product->is_type( 'variable' ) ) {
											if ( isset($children) && !empty($children) ) { ?>
												<div class="price_block">
													<ins><?php echo $product->get_variation_sale_price( 'min', true ).' '.get_woocommerce_currency_symbol();?></ins>
													<del><?php echo $product->get_variation_regular_price( 'max', true ).' '.get_woocommerce_currency_symbol();?></del>
												</div>
											<?php } else{ ?>
												<div class="price_block">
													<ins><?php echo $product->get_price_html();?></ins>
												</div>
											<?php } } ?>
										<div class="d-flex align-items-sm-center flex-column flex-sm-row mb-3">
											<p class="share__text mb-2 mb-sm-0 mr-0 mr-sm-2"><?php echo __('Share:', 'boss') ?></p>										
                                            <ul class="social__list">
                                                <li>
													<a target="_blank" class="sc_facebook" href="https://www.facebook.com/dialog/share?app_id=296649824842615&amp;u=<?php the_permalink(); ?>">
														<i class="fab fa-facebook-f"></i>
													</a>
												</li>
                                                <li>
													<a target="_blank" class="sc_telegram" href="https://t.me/share/url?url=<?php the_permalink(); ?>">
														<i class="fab fa-telegram-plane"></i>
													</a>
												</li>
                                                <li>
													<a target="_blank" class="sc_twitter" href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&amp;url=<?php the_permalink(); ?>">
														<i class="fab fa-twitter"></i>
													</a>
												</li>
                                            </ul>
											
										</div>
										<div class="right_summary_content">
											<?php if ( $product->is_type( 'variable' ) ) {
												if($product->price <= 0 && !is_user_logged_in()){

													echo "Saytdan ro'yxatdan o'ting";
												}else{
													do_action('woocommerce_variable_add_to_cart');
												}
											}  else {
											
		
												if($product->price <= 0 && !is_user_logged_in()){
													echo "Saytdan ro'yxatdan o'ting";
												
												}else{
													
												
												
											
											?>  
											<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
												<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
												<div class="Product_Quantity__quantity__1bkyi">
													<div class="Product_Quantity__title__1bkyi">
														<span class="ali-kit_Base__base__104pa1 ali-kit_Base__default__104pa1 ali-kit_Label__label__1n9sab ali-kit_Label__size-xs__1n9sab"><?php echo __('Amount', 'boss')?>:</span>
													</div>
													<div class="Product_Quantity__picker__1bkyi">
														<?php
														do_action( 'woocommerce_before_add_to_cart_quantity' );

														woocommerce_quantity_input(
															array(
																'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
																'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
																'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
															)
														);
														do_action( 'woocommerce_after_add_to_cart_quantity' );
														?>
													</div>
												</div>
												<div class="Product_Actions__wrapper__1j0pn">
												
													<div class="ali-kit_Tooltip__wrapper__sht7gl">
														<?php														
														$checkout_url = wc_get_checkout_url();													
														
														echo '<a href="'.$checkout_url.'?add-to-cart='.$current_product_id.'" class="buy-now button">'.__('Buy now', 'boss').'</a>';
														?>
													</div>
													
													<div class="ali-kit_Tooltip__wrapper__sht7gl">

														<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->add_to_cart_text() ); ?></button>

														<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
													</div>
												</div>
											</form>
											<?php } }?>  
										</div> 
										<div class="col-span-4 col-span-12">
											<div class="grid grid-flow-row gap-y-4 auto-rows-min">
												<div data-v-e4edce26="" class="grid grid-cols-1 gap-y-2 items-baseline">

													<div class="text-left">
														<?php woocommerce_template_single_excerpt(); ?>	
													</div>
												</div>
											</div>
											
										</div>
									</div>
								</div>
								<!-- PRODUCT INFO END  -->

	
							</div>
							<div class="row mb-40">
								<!-- PRODUCT DESCRIPTION  -->
								<div class="col-sm-12">
									<div class="product__description">
										<h4 class="product__description-title"><?php echo __('Description', 'boss');?></h4>
										<div class="description__item">                                            
											<?php echo $product->get_description();?> 
										</div>
									</div>
								</div>
								<!-- PRODUCT DESCRIPTION END  -->
							</div>
						</section>
						<!-- RECOMMENDEDS CAROUSEL  -->
						<section class="rax-view content-bottom">
							<div class="rax-view item-feed">

								<div class="rax-view item-feed-header">
									<span class="rax-text-v2 header-title"><?php echo __('Related products', 'boss');?></span>
								</div>

								<div class="container">
									<ul class="products 4 row white-bg">
										<?php  
										
											$post_id = get_the_ID();
											$cat_ids = array();
											$categories = get_the_terms( $post_id, 'product_cat' );

											if(!empty($categories) && !is_wp_error($categories)):
												foreach ($categories as $category):
													array_push($cat_ids, $category->term_id);
												endforeach;
											endif;									
											$args = array(
												'posts_per_page' => 4,
												'post_type' => 'product',
												'post_status' => 'publish',
												'ignore_sticky_posts' => 1,
												'tax_query'     => array(
													array(
														'taxonomy'  => 'product_cat',
														'field'     => 'id', 
														'terms'     => $cat_ids
													)
												),
												'post__not_in'    => array(get_the_ID()),
												'orderby' => 'date',
												'order' => 'DESC',
											);

											$loop = new \WP_Query( $args );

											while ( $loop->have_posts() ) : $loop->the_post();
												global $product; 
												wc_get_template_part( 'content', 'product' );
											
											endwhile;

											wp_reset_query();
										?>                                 
									</ul>
								</div>
							</div>
						</section>
						<!-- RECOMMENDEDS CAROUSEL END  -->
					</div>

				<?php endwhile; // end of the loop. ?>

			
		</div>
	</div>

<?php
get_footer( 'shop' );