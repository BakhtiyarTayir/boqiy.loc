<?php

/**
 * To view theme functions, navigate to /buddyboss-inc/theme.php
 *
 * @package Boss
 * @since Boss 1.0.0
 */
$init_file = get_template_directory() . '/buddyboss-inc/init.php';

if ( !file_exists( $init_file ) ) {
	$err_msg = __( 'BuddyBoss cannot find the starter file, should be located at: *wp root*/wp-content/themes/buddyboss/buddyboss-inc/init.php', 'boss' );

	wp_die( $err_msg );
}

require_once( $init_file );


// Shop menu 
function home_cat_menu() { 
	get_template_part( 'home-categories-menu' );
} 
add_shortcode('home_cat_menu', 'home_cat_menu');

function home_cat_mobile_menu() { 
	get_template_part( 'home-categories-menu-mobile' );
} 
add_shortcode('home_cat_mobile_menu', 'home_cat_mobile_menu');

// удаление категории hamkorlik 

add_action( 'woocommerce_product_query', 'ts_custom_pre_get_posts_query' );
function ts_custom_pre_get_posts_query( $q ) {

$tax_query = (array) $q->get( 'tax_query' );
$tax_query[] = array(
'taxonomy' => 'product_cat',
'field' => 'slug',
'terms' =>array( 'hamkorlik', 'partnerskie-tovary'), // Don't display products in the hamkorlik category on the shop page.
'operator' => 'NOT IN'
);
$q->set( 'tax_query', $tax_query );

}
function unauthorized_custom_redirect() {
	if (
		! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) )
		&& ! is_home()
		&& ! is_front_page()
		&& ! is_user_logged_in()
	) {
		if ( wp_safe_redirect( get_bloginfo( 'url' ), 301 ) ) {
			exit;
		}
	}
}

add_action( 'bp_groups_admin_meta_boxes', 'bpgcp_add_admin_metabox' );
function bpgcp_add_admin_metabox() {	
	add_meta_box( 
		'group_ext_st_description', // Meta box ID 
		'Tavsifi', // Meta box title
		'bpgcp_render_admin_metabox', // Meta box callback function
		get_current_screen()->id, // Screen on which the metabox is displayed. In our case, the value is toplevel_page_bp-groups
		'normal', // Where the meta box is displayed
		'core' // Meta box priority
	);
}
function bpgcp_render_admin_metabox() {
	$group_id = intval( $_GET['gid'] );
	$description = html_entity_decode(groups_get_groupmeta( $group_id, 'group_ext_st_description' ));
	?>

	<div class="bp-groups-settings-section" id="bp-groups-settings-section-content-protection">
		<fieldset>
		
            <?php
             $description_field  = 'Description';
             //Provide the settings arguments for this specific editor in an array
             $description_args   = array( 
                'media_buttons' => false, 
                'textarea_rows' => 12, 
                'textarea_name' => 'group_ext_st_description',
                'editor_class' => 'description-editor widefat', 
                'wpautop' => true
             );
             wp_editor( $description, $description_field, $description_args );
            ?>
		
		</fieldset>
	</div>

	<?php
}

add_action( 'bp_group_admin_edit_after', 'bpgcp_save_metabox_fields' );
function bpgcp_save_metabox_fields( $group_id ) {
	$hide_from_anonymous = $_POST['group_ext_st_description'];

	groups_update_groupmeta( $group_id, 'group_ext_st_description', $hide_from_anonymous );
}

if ( ! function_exists( 'minbazar_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function minbazar_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		minbazar_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'minbazar_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'minbazar_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 * 
	 * @return void
	 */
	function minbazar_woocommerce_cart_link() {
		?>
		<a class="cart-contens ec-header-btn ec-side-toggle hidden-xs" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'minbazar' ); ?>">
            <div class="header-icon"><i class="fa fa-shopping-cart"></i></div>
            <?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'minbazar' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
<!--			<span class="ec-header-count ec-cart-count cart-count-lable">--><?php //echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?><!--</span> -->
            <span class="ec-header-count ec-cart-count cart-count-lable"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'minbazar_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function minbazar_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php minbazar_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}
// Change the Number of WooCommerce Products Displayed Per Page
add_filter( 'loop_shop_per_page', 'lw_loop_shop_per_page', 30 );

function lw_loop_shop_per_page( $products ) {
 $products = 24;
 return $products;
}