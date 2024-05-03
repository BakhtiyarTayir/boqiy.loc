<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div class="row">


	<div id="product-<?php the_ID(); ?>" class="container">

	
		<div class="row">
			<div class="col-md-9">
				<?php woocommerce_template_single_title(); ?>

				<div class="col-md-12">
					<div class="row">
						<div class="col-md-7">
								<?php 
									/**
									 * Hook: woocommerce_before_single_product_summary.
									 *
									 * @hooked woocommerce_show_product_sale_flash - 10
									 * @hooked woocommerce_show_product_images - 20
									 */
									do_action( 'woocommerce_before_single_product_summary' );
								?>
						</div>
						<div class="col-md-5">
							<?php
								woocommerce_template_single_price();
							?>	
												<?php 
						/**
				 * Hook: woocommerce_single_product_summary.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */

				if($product->price <= 0 && !is_user_logged_in()){
					echo "Saytdan ro'yxatdan o'ting";
				}else{
					woocommerce_template_single_add_to_cart();
				}
				
					?>
						</div>
					</div>
					<br>
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
			<div class="summary entry-summary col-md-3">
				<?php
				
				?>

				<div class="proposal-view-more">
					<div class="categories_widget">
						<?php dynamic_sidebar('shop_sidebar');?>
					</div>
					<div class="product_widget_banner">
						<?php dynamic_sidebar('product_ads');?>
					</div>
					<div class="share">
						<span class="d-block mr-2"><?php echo __( 'Share with friends', 'boss' )?></span>
						<div class="ya-share2 ya-share2_inited" data-size="s">
							<div
								class="ya-share2__container ya-share2__container_size_s ya-share2__container_color-scheme_normal ya-share2__container_shape_normal">
								<ul class="ya-share2__list ya-share2__list_direction_horizontal">
									<li class="ya-share2__item ya-share2__item_service_vkontakte">
										<a class="ya-share2__link"
											href="https://vk.com/share.php?url=<?php echo rawurlencode( get_permalink() );?>&amp;title=<?php echo rawurlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;utm_source=share2"
											rel="nofollow noopener" target="_blank" title="ВКонтакте">
											<span class="ya-share2__badge"><i class="fab fa-vk"></i></span>
										</a>
									</li>
									<li class="ya-share2__item ya-share2__item_service_twitter">
										<a class="ya-share2__link"
											href="https://twitter.com/intent/tweet?text=<?php echo rawurlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;url=<?php echo rawurlencode( get_permalink() );?>&amp;utm_source=share2"
											rel="nofollow noopener" target="_blank" title="Twitter">
											<span class="ya-share2__badge"><i class="fab fa-twitter"></i></span>
										</a>
									</li>
									<li class="ya-share2__item ya-share2__item_service_facebook">
										<a class="ya-share2__link"
											href="https://www.facebook.com/sharer.php?src=sp&amp;u=<?php echo rawurlencode( get_permalink() );?>&amp;title=<?php echo rawurlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;utm_source=share2"
											rel="nofollow noopener" target="_blank" title="Facebook">
											<span class="ya-share2__badge"><i class="fab fa-facebook"></i></span>
										</a>
									</li>
									<li class="ya-share2__item ya-share2__item_service_odnoklassniki">
										<a class="ya-share2__link"
											href="https://connect.ok.ru/offer?url=<?php echo rawurlencode( get_permalink() );?>&amp;title=<?php echo rawurlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;utm_source=share2"
											rel="nofollow noopener" target="_blank" title="Одноклассники">
											<span class="ya-share2__badge"><i class="fab fa-odnoklassniki"></i></span>
										</a>
									</li>
									<li class="ya-share2__item ya-share2__item_service_telegram">
										<a class="ya-share2__link"
											href="https://t.me/share/url?url=<?php echo rawurlencode( get_permalink() );?>&amp;text=<?php echo rawurlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;utm_source=share2"
											rel="nofollow noopener" target="_blank" title="Telegram">
											<span class="ya-share2__badge"><i class="fab fa-telegram-plane"></i></span>

										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		woocommerce_output_product_data_tabs();
		
		?>
	</div>
	
		

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
</div>
<div class="relat">
	<?php woocommerce_output_related_products();?>