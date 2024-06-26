<?php
/**
 * @package Boss
 */
/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! defined( 'DS' ) ) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

define( 'BILLEY_THEME_VERSION', '10' );
define( 'BILLEY_THEME_DIR', get_template_directory() );
define( 'BILLEY_THEME_URI', get_template_directory_uri() );
define( 'BILLEY_THEME_ASSETS_URI', get_template_directory_uri() . '/assets' );
define( 'BILLEY_THEME_IMAGE_URI', BILLEY_THEME_ASSETS_URI . '/images' );

define( 'BILLEY_ELEMENTOR_DIR', get_template_directory() . DS . 'elementor' );
define( 'BILLEY_ELEMENTOR_URI', get_template_directory_uri() . '/elementor' );
define( 'BILLEY_ELEMENTOR_ASSETS', get_template_directory_uri() . '/elementor/assets' );

require_once BILLEY_ELEMENTOR_DIR . '/class-entry.php';
global $content_width;
$content_width = ( isset( $content_width ) ) ? $content_width : 625;

function boss_show_adminbar() {
	$show = false;

	if ( !is_admin() && current_user_can( 'manage_options' ) && (boss_get_option( 'boss_adminbar' )) ) {
//	This is changed becuase other user type can see top bar.
//	if ( (boss_get_option( 'boss_adminbar' ) ) ) {
		$show = true;
	}

	return apply_filters( 'boss_show_adminbar', $show );
}

/**
 * Set global orientation variable
 */
global $rtl;

$rtl = false;

if ( is_rtl() ) {
	$rtl = true;
}

global $boss_learndash, $boss_sensei, $learner;
$learner = !is_null( $boss_learndash ) || !is_null( $boss_sensei );

/**
 * Sets up theme defaults and registers the various WordPress features that Boss supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Boss 1.0.0
 */
function buddyboss_setup() {
	// Completely Disable Adminbar from frontend.
	//show_admin_bar( false );
	// Makes Boss available for translation.
	load_theme_textdomain( 'boss', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Add title at wp_head
	add_theme_support( 'title-tag' );

	// Declare BuddyPress template pack support
    add_theme_support( 'buddypress-use-legacy' );

	// Declare theme support for WooCommerce
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Adds wp_nav_menu() in two locations with BuddyPress deactivated.
	register_nav_menus( array(
		'left-panel-menu'	 => __( 'BuddyPanel', 'boss' ),
		
		'header-my-account'	 => __( 'My Profile', 'boss' ),
		'header_menu'           => __('Header Menu', 'boss'),
		'header_mobile_menu'           => __('Header Mobile Menu', 'boss'),
		'header_features_menu'  => __('Header Features Menu', 'boss'),
		'side_menu'             => __('Side Menu', 'boss'),
		'footer_menu'           => __( 'Footer', 'boss' )
	) );

	// Adds wp_nav_menu() in two additional locations with BuddyPress activated.
	if ( function_exists( 'bp_is_active' ) ) {
		register_nav_menus( array(
			'profile-menu'	 => __( 'Profile: Extra Links', 'boss' ),
			'group-menu'	 => __( 'Group: Extra Links', 'boss' ),
		) );
	}


	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
	// Disable wordpress core css
	add_theme_support( 'html5', array(
		'gallery'
	) );
}

add_action( 'after_setup_theme', 'buddyboss_setup' );

/**
 * Adds Profile menu to BuddyPress profiles
 *
 * @since Boss 1.0.0
 */
function buddyboss_add_profile_menu() {
	if ( function_exists( 'bp_is_active' ) ) {
		if ( has_nav_menu( 'profile-menu' ) ) {
			wp_nav_menu( array( 'container' => false, 'theme_location' => 'profile-menu', 'items_wrap' => '%3$s' ) );
		}
	}
}

add_action( 'bp_member_options_nav', 'buddyboss_add_profile_menu' );

/**
 * Adds Group menu to BuddyPress groups
 *
 * @since Boss 1.0.0
 */
function buddyboss_add_group_menu() {
	if ( function_exists( 'bp_is_active' ) ) {
		if ( has_nav_menu( 'group-menu' ) ) {
			wp_nav_menu( array( 'container' => false, 'theme_location' => 'group-menu', 'items_wrap' => '%3$s' ) );
		}
	}
}

add_action( 'bp_group_options_nav', 'buddyboss_add_group_menu' );

function bb_unique_array( $a ) {
	return array_unique( array_filter( $a ) );
}

/**
 * Detecting phones
 *
 * @since Boss 1.0.6
 * from detectmobilebrowsers.com
 */
function is_phone() {
	if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
		return false;
	}
	$useragent = $_SERVER[ 'HTTP_USER_AGENT' ];
	if ( preg_match( '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent ) || preg_match( '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr( $useragent, 0, 4 ) ) )
		return true;
}

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Boss 1.0.0
 */
function buddyboss_scripts_styles() {

	/*	 * **************************** SCRIPTS ***************************** */

	global $bp, $buddyboss, $buddyboss_js_params, $rtl;
	/**
	 * Assign the Boss version to a var
	 */
	$theme			 = wp_get_theme( 'boss' );
	$boss_version	 = $theme[ 'Version' ];

	/*	 * *************************** STYLES ***************************** */

	// FontAwesome icon fonts. If browsing on a secure connection, use HTTPS.
	// We will only load if our is latest.
	$recent_fwver	 = (isset( wp_styles()->registered[ "fontawesome" ] )) ? wp_styles()->registered[ "fontawesome" ]->ver : "0";
	$current_fwver	 = "5.2.0";
	if ( version_compare( $current_fwver, $recent_fwver, '>' ) ) {
		wp_deregister_style( 'fontawesome' );
		wp_register_style( 'fontawesome', "https://use.fontawesome.com/releases/v{$current_fwver}/css/all.css", false, $current_fwver );
		//wp_enqueue_script( 'fontawesome-v4-shims', "https://use.fontawesome.com/releases/v{$current_fwver}/js/v4-shims.js", false, $current_fwver );
		wp_enqueue_style( 'fontawesome' );
	}

	// Used in js file to detect if we are using only mobile layout
	$only_mobile = false;

	$css_dest			 = ( is_rtl() ) ? '/css-rtl' : '/css';
	$css_compressed_dest = ( is_rtl() ) ? '/css-rtl-compressed' : '/css-compressed';
	$CSS_URL			 = boss_get_option( 'boss_minified_css' ) ? get_template_directory_uri() . $css_compressed_dest : get_template_directory_uri() . $css_dest;

	// Main stylesheet
	if ( !is_admin() ) {

		// Activate our main stylesheets. Load FontAwesome first.
		
	
		wp_enqueue_style('owl', get_template_directory_uri() . '/css/owl.carousel.min.css');
		wp_enqueue_style('font-awesome', get_template_directory_uri() . '/fonts/font-awesome/font-awesome.min.css', [], $boss_version);
		wp_enqueue_style('fonts', get_template_directory_uri() . '/css/fonts.css', [], $boss_version);
		if(!(get_post_type()=='product') && !is_page_template( 'template-shop.php' )){
			wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css'); 
			wp_enqueue_style( 'boss-main-global', get_template_directory_uri(). '/css/main-global.css', [], $boss_version, 'all');
		
			wp_enqueue_style('custom', get_template_directory_uri() . '/css/custom.css', [], $boss_version);
			wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css', [], $boss_version);
		}
		
		if( is_shop() || (is_archive() && is_woocommerce()) || (get_post_type()=='product' || is_page_template( 'template-shop.php' ))){
			wp_enqueue_style('shops-boot', get_template_directory_uri() . '/css/shop/bootstrap.min.css', [], $boss_version);
			wp_enqueue_style('woocommerces', get_template_directory_uri() . '/css/shop/woocommerce.css', [], $boss_version);
			wp_enqueue_style('swiper', get_template_directory_uri() . '/css/shop/swiper-bundle.min.css', [], $boss_version);
			wp_enqueue_style('fancybox', get_template_directory_uri() . '/css/shop/jquery.fancybox.min.css', [], $boss_version);
		
			wp_enqueue_style('shops', get_template_directory_uri() . '/css/shop/style.css', [], $boss_version);
			wp_enqueue_style('mediacss', get_template_directory_uri() . '/css/shop/media.css', [], $boss_version);
			
		}

		if ( defined( 'EM_VERSION' ) && EM_VERSION ) {
			wp_enqueue_style( 'boss-events-global', $CSS_URL . '/events/events-global.css', array( 'fontawesome' ), $boss_version, 'all' );
		}

		// Switch between mobile and desktop
		if ( isset( $_COOKIE[ 'switch_mode' ] ) && ( boss_get_option( 'boss_layout_switcher' ) ) ) {
			if ( $_COOKIE[ 'switch_mode' ] == 'mobile' ) {
				wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile.css', array( 'fontawesome' ), $boss_version, 'all' );

				if ( defined( 'EM_VERSION' ) && EM_VERSION ) {
					wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile.css', array( 'fontawesome' ), $boss_version, 'all' );
				}

				$only_mobile = true;
			} else {
				wp_enqueue_style( 'boss-main-desktop', $CSS_URL . '/main-desktop.css', array( 'fontawesome' ), $boss_version, 'screen and (min-width: 481px)' );
				wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile.css', array( 'fontawesome' ), $boss_version, 'screen and (max-width: 480px)' );

				if ( defined( 'EM_VERSION' ) && EM_VERSION ) {
					wp_enqueue_style( 'boss-events-desktop', $CSS_URL . '/events/events-desktop.css', array( 'fontawesome' ), $boss_version, 'screen and (min-width: 481px)' );
					wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile.css', array( 'fontawesome' ), $boss_version, 'screen and (max-width: 480px)' );
				}
			}
			// Defaults
		} else {
			if ( is_phone() ) {
				wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile.css', array( 'fontawesome' ), $boss_version, 'all' );
				if ( defined( 'EM_VERSION' ) && EM_VERSION ) {
					wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile.css', array( 'fontawesome' ), $boss_version, 'all' );
				}
				$only_mobile = true;
			} elseif ( wp_is_mobile() ) {
				if ( boss_get_option( 'boss_layout_tablet' ) == 'desktop' ) {
					wp_enqueue_style( 'boss-main-desktop', $CSS_URL . '/main-desktop.css', array( 'fontawesome' ), $boss_version, 'all' );
					if ( defined( 'EM_VERSION' ) && EM_VERSION ) {
						wp_enqueue_style( 'boss-events-desktop', $CSS_URL . '/events/events-desktop.css', array( 'fontawesome' ), $boss_version, 'all' );
					}
				} else {
					wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile.css', array( 'fontawesome' ), $boss_version, 'all' );

					if ( defined( 'EM_VERSION' ) && EM_VERSION ) {
						wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile.css', array( 'fontawesome' ), $boss_version, 'all' );
					}

					$only_mobile = true;
				}
			} else {
				if ( boss_get_option( 'boss_layout_desktop' ) == 'mobile' ) {
					wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile.css', array( 'fontawesome' ), $boss_version, 'all' );

					if ( defined( 'EM_VERSION' ) && EM_VERSION ) {
						wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile.css', array( 'fontawesome' ), $boss_version, 'all' );
					}

					$only_mobile = true;
				} else {
					wp_enqueue_style( 'boss-main-desktop', $CSS_URL . '/main-desktop.css', array( 'fontawesome' ), $boss_version, 'screen and (min-width: 481px)' );

					if ( defined( 'EM_VERSION' ) && EM_VERSION ) {
						wp_enqueue_style( 'boss-events-desktop', $CSS_URL . '/events/events-desktop.css', array( 'fontawesome' ), $boss_version, 'screen and (min-width: 481px)' );
					}
				}
			}

			// Media query fallback
			if ( !wp_script_is( 'boss-main-mobile', 'enqueued' ) ) {
				wp_enqueue_style( 'boss-main-mobile', $CSS_URL . '/main-mobile.css', array( 'fontawesome' ), $boss_version, 'screen and (max-width: 480px)' );
			}
			if ( !wp_script_is( 'boss-events-mobile', 'enqueued' ) && defined( 'EM_VERSION' ) && EM_VERSION ) {
				wp_enqueue_style( 'boss-events-mobile', $CSS_URL . '/events/events-mobile.css', array( 'fontawesome' ), $boss_version, 'screen and (max-width: 480px)' );
			}
		}

		global $learner;

		if ( $learner ) {
			wp_enqueue_style( 'social-learner', $CSS_URL . '/social-learner.css', array( 'fontawesome' ), $boss_version, 'all' );
		}


		if ( !empty( $GLOBALS[ 'badgeos' ] ) ) {
			wp_enqueue_style( 'boss-badgeos', $CSS_URL . '/badgeos/badgeos.css', array( 'fontawesome' ), $boss_version, 'all' );
		}

		if ( '2' == boss_get_option( 'boss_header' ) ) {
			wp_enqueue_style( 'header-style-2', $CSS_URL . '/header-style-2.css', array( 'fontawesome' ), $boss_version, 'all' );
		}
	}

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/*
	 * Adds mobile JavaScript functionality.
	 */
	if ( !is_admin() ) {
		wp_enqueue_script( 'idangerous-swiper', get_template_directory_uri() . '/js/swiper.jquery.js', array( 'jquery' ), '3.4.2', true );
	}

	$user_profile = null;

	if ( is_object( $bp ) && is_object( $bp->displayed_user ) && !empty( $bp->displayed_user->domain ) ) {
		$user_profile = $bp->displayed_user->domain;
	}

	/*
	 * Adds UI scripts.
	 */
	if ( !is_admin() ) {

		//lets remove these three on next version.
		// JS > Plupload
		//wp_deregister_script( 'moxie' );
		//wp_deregister_script( 'plupload' );

		wp_enqueue_script( 'jquery-effects-core' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-progressbar' );
		wp_enqueue_script( 'jquery-ui-tooltip' );
		//wp_enqueue_script( 'moxie', get_template_directory_uri() . '/js/plupload/moxie.min.js', array( 'jquery' ), '1.2.1' );
		//wp_enqueue_script( 'plupload', get_template_directory_uri() . '/js/plupload/plupload.dev.js', array( 'jquery', 'moxie' ), $boss_version );
		//Heartbeat
		wp_enqueue_script( 'heartbeat' );

		$translation_array = array(
			'only_mobile'			 => $only_mobile,
			'comment_placeholder'	 => __( 'Your Comment...', 'boss' ),
			'view_desktop'			 => __( 'View as Desktop', 'boss' ),
			'view_mobile'			 => __( 'View as Mobile', 'boss' )
		);


		// Add BuddyBoss words that we need to use in JS to the end of the page
		// so they can be translataed and still used.
		$buddyboss_js_vars = array(
			'select_label'	  => __( 'Show:', 'boss' ),
			'post_in_label'	  => __( 'Post in:', 'boss' ),
			'tpl_url'		  => get_template_directory_uri(),
			'child_url'		  => get_stylesheet_directory_uri(),
			'user_profile'	  => $user_profile,
			'excluded_inputs' => boss_get_option('boss_excluded_inputs'),
			'days'			  => array( __( 'Monday', 'boss' ), __( 'Tuesday', 'boss' ), __( 'Wednesday', 'boss' ), __( 'Thursday', 'boss' ), __( 'Friday', 'boss' ), __( 'Saturday', 'boss' ), __( 'Sunday', 'boss' ) )
		);

		$buddyboss_js_vars = apply_filters( 'buddyboss_js_vars', $buddyboss_js_vars );

		if ( boss_get_option( 'boss_minified_js' ) ) {
			wp_register_script( 'boss-main-min', get_template_directory_uri() . '/js/compressed/boss-main-min.js', array( 'jquery' ), $boss_version, true );
			wp_localize_script( 'boss-main-min', 'translation', $translation_array );
			wp_localize_script( 'boss-main-min', 'BuddyBossOptions', $buddyboss_js_vars );
			wp_enqueue_script( 'boss-main-min' );
		} else {

			/* Adds custom BuddyBoss JavaScript functionality. */

			wp_register_script( 'buddyboss-main', get_template_directory_uri() . '/js/buddyboss.js', array( 'jquery' ), $boss_version, true );

			wp_localize_script( 'buddyboss-main', 'translation', $translation_array );
			wp_localize_script( 'buddyboss-main', 'BuddyBossOptions', $buddyboss_js_vars );

			wp_enqueue_script( 'buddyboss-modernizr', get_template_directory_uri() . '/js/modernizr.min.js', false, '2.7.1', false );
			wp_enqueue_script( 'selectboxes', get_template_directory_uri() . '/js/ui-scripts/selectboxes.js', array(), '1.1.7', true );
			wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/ui-scripts/fitvids.js', array(), '1.1', true );
			wp_enqueue_script( 'cookie', get_template_directory_uri() . '/js/ui-scripts/jquery.cookie.js', array(), '1.4.1', true );
			wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/ui-scripts/superfish.js', array(), '1.7.4', true );
			wp_enqueue_script( 'hoverIntent', get_template_directory_uri() . '/js/ui-scripts/hoverIntent.js', array(), '1.8.0', true );
			wp_enqueue_script( 'imagesLoaded', get_template_directory_uri() . '/js/ui-scripts/imagesloaded.pkgd.js', array(), '3.1.8', true );
			wp_enqueue_script( 'owl', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), '1.1', true );
			wp_enqueue_script( 'resize', get_template_directory_uri() . '/js/ui-scripts/resize.js', array(), '1.1', true );
			wp_enqueue_script( 'growl', get_template_directory_uri() . '/js/jquery.growl.js', array(), '1.2.4', true );
			wp_enqueue_script( 'buddyboss-slider', get_template_directory_uri() . '/js/slider/slick.min.js', array( 'jquery' ), '1.1.2', true );
			if(!(get_post_type()=='product')  && !is_page_template( 'template-shop.php' )){
				wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '1.1.2', true );
			}
			
			wp_enqueue_script('scripts', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '1.1.2', true );
			
			if( is_shop() || (is_archive() && is_woocommerce()) || (get_post_type()=='product')  || is_page_template( 'template-shop.php' )){
				wp_enqueue_script('bootstraps', get_template_directory_uri() . '/js/shop/bootstrap.min.js', array( 'jquery' ), '1.1.2', true );
				wp_enqueue_script('swiper-bundle', get_template_directory_uri() . '/js/shop/swiper-bundle.min.js', array( 'jquery' ), '1.1.2', true );
				wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/shop/jquery.fancybox.min.js', array( 'jquery' ), '1.1.2', true );
				wp_enqueue_script('customsc', get_template_directory_uri() . '/js/shop/custom.js', array( 'jquery' ), '1.1.2', true );
			}
			//lets remove these two on next version.
			//	wp_enqueue_script( 'moxie', get_template_directory_uri() . '/js/plupload/moxie.min.js', array( 'jquery' ), '1.2.1' );
			//	wp_enqueue_script( 'plupload', get_template_directory_uri() . '/js/plupload/plupload.dev.js', array( 'jquery', 'moxie' ), '2.1.3' );

			wp_enqueue_script( 'buddyboss-main' );

			if ( '2' == boss_get_option( 'boss_header' ) ) {
				wp_enqueue_script( 'social-learner', get_template_directory_uri() . '/js/social-learner.js', false, $boss_version, false );
			}

			if ( defined( 'EM_VERSION' ) && EM_VERSION ) {
				wp_enqueue_script( 'boss-events', get_template_directory_uri() . '/js/boss-events.js', false, $boss_version, true );
			}
		}
	}

	/**
	 * If we're on the BuddyPress messages component we need to load jQuery Migrate first
	 * before bgiframe, so let's take care of that
	 */
	if ( function_exists( 'bp_is_messages_component' ) && bp_is_messages_component() && bp_is_current_action( 'compose' ) ) {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_dequeue_script( 'bp-jquery-bgiframe' );
		wp_enqueue_script( 'bp-jquery-bgiframe', BP_PLUGIN_URL . "bp-messages/js/autocomplete/jquery.bgiframe{$min}.js", array(), bp_get_version() );
	}

	/*
	 * Load our BuddyPress styles manually.
	 * We need to deregister the BuddyPress styles first then load our own.
	 * We need to do this for proper CSS load order.
	 */
	if ( $buddyboss->buddypress_active && ! is_admin() ) {
		// Deregister the built-in BuddyPress stylesheet
		wp_deregister_style( 'bp-child-css' );
		wp_deregister_style( 'bp-parent-css' );
		wp_dequeue_style( 'bp-legacy-css' );
		wp_deregister_style( 'bp-legacy-css' );
		wp_deregister_style( 'bp-legacy-css-rtl' );
	}

	/*
	 * Load our bbPress styles manually.
	 * We need to deregister the bbPress style first then load our own.
	 * We need to do this for proper CSS load order.
	 */
	if ( $buddyboss->bbpress_active && ! is_admin() ) {
		// Deregister the built-in bbPress stylesheet
		wp_deregister_style( 'bbp-child-bbpress' );
		wp_deregister_style( 'bbp-parent-bbpress' );
		wp_dequeue_style( 'bbp-default' );
		wp_deregister_style( 'bbp-default' );
	}

	// Deregister the wp admin bar stylesheet
	if ( !boss_show_adminbar() ) {
		wp_deregister_style( 'admin-bar' );
	}
}

add_action( 'wp_enqueue_scripts', 'buddyboss_scripts_styles' );

/**
 * We need to enqueue jQuery migrate before anything else for legacy
 * plugin support.
 * WordPress version 3.9 onwards already includes jquery 1.11.n version, which we required,
 * and jquery migrate is also properly enqueued.
 * So we dont need to do anything for WP versions greater than 3.9.
 *
 * @package  Boss
 * @since    Boss 1.0.0
 */
function buddyboss_scripts_jquery_migrate() {
	global $wp_version;
	if ( $wp_version >= 3.9 ) {
		return;
	}

	if ( !is_admin() ) {

		// Deregister the built-in version of jQuery
		wp_deregister_script( 'jquery' );
		// Register jQuery. If browsing on a secure connection, use HTTPS.
		wp_register_script( 'jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js", false, null );

		// Activate the jQuery script
		wp_enqueue_script( 'jquery' );

		// Activate the jQuery Migrate script from WordPress
		wp_enqueue_script( 'jquery-migrate', false, array( 'jquery' ) );
	}
}

add_action( 'wp_enqueue_scripts', 'buddyboss_scripts_jquery_migrate', 0 );

/**
 * Removes CSS in the header so we can keep buddyboss clean from admin bar stuff.
 * Note :- we can fully disable admin-bar too but we are using its nodes for BuddyPanel.
 *
 * @package  Boss
 * @since    Boss 1.0.0
 */
function buddyboss_remove_adminbar_inline_styles() {
	if ( !is_admin() && !boss_show_adminbar() ) {

		remove_action( 'wp_head', 'wp_admin_bar_header' );
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
	}
}

add_action( 'wp_head', 'buddyboss_remove_adminbar_inline_styles', 9 );

/**
 * JavaScript mobile init
 *
 * @package  Boss
 * @since    Boss 1.0.0
 */
function buddyboss_mobile_js_init() {
	?>
	<div id="mobile-check"></div><!-- #mobile-check -->
	<?php
}

add_action( 'buddyboss_before_header', 'buddyboss_mobile_js_init' );

/**
 * Dynamically removes the no-js class from the <body> element.
 *
 * By default, the no-js class is added to the body (see bp_dtheme_add_no_js_body_class()). The
 * JavaScript in this function is loaded into the <body> element immediately after the <body> tag
 * (note that it's hooked to bp_before_header), and uses JavaScript to switch the 'no-js' body class
 * to 'js'. If your theme has styles that should only apply for JavaScript-enabled users, apply them
 * to body.js.
 *
 * This technique is borrowed from WordPress, wp-admin/admin-header.php.
 *
 * @package  Boss
 * @since    Boss 1.0.0
 * @see bp_dtheme_add_nojs_body_class()
 */
function buddyboss_remove_nojs_body_class() {
	?><script type="text/JavaScript">//<![CDATA[
		(function(){var c=document.body.className;c=c.replace(/no-js/,'js');document.body.className=c;})();
		$=jQuery.noConflict();
		//]]></script>
	<?php
}

add_action( 'buddyboss_before_header', 'buddyboss_remove_nojs_body_class' );

/**
 * Determines if the currently logged in user is an admin
 * TODO: This should check in a better way, by capability not role title and
 * this function probably belongs in a functions.php file or utility.php
 */
function buddyboss_is_admin() {
	return is_user_logged_in() && current_user_can( 'administrator' );
}

function buddyboss_members_latest_update_filter( $latest ) {
	$latest = str_replace( array( '- &quot;', '&quot;' ), '', $latest );

	return $latest;
}

add_filter( 'bp_get_activity_latest_update_excerpt', 'buddyboss_members_latest_update_filter' );

/**
 * Remove an anonymous object filter.
 *
 * @param string $tag Hook name.
 * @param string $class Class name
 * @param string $method Method name
 * @return void
 */
function buddyboss_remove_anonymous_object_filter( $tag, $class, $method ) {
	$filters = $GLOBALS[ 'wp_filter' ][ $tag ];

	if ( empty( $filters ) ) {
		return;
	}

	foreach ( $filters as $priority => $filter ) {
		foreach ( $filter as $identifier => $function ) {
			if ( is_array( $function )
            && is_array( $function['function'] )
			&& $function[ 'function' ][0] instanceof $class
			&& $method === $function[ 'function' ][1]
			) {
				remove_filter(
				$tag, array( $function[ 'function' ][0], $method ), $priority
				);
			}
		}
	}
}

/**
 * Moves sitewide notices to the header
 *
 * Since BuddyPress doesn't give us access to BP_Legacy, let
 * us begin the hacking
 *
 * @since Boss 1.0.0
 */
function buddyboss_fix_sitewide_notices() {
	// Check if BP_Legacy is being used and messages are active
	if ( class_exists( 'BP_Legacy' ) && bp_is_active( 'messages' ) ) {
		buddyboss_remove_anonymous_object_filter( 'wp_footer', 'BP_Legacy', 'sitewide_notices' );
		add_action( 'buddyboss_inside_wrapper', 'buddyboss_print_sitewide_notices', 9999 );
	}
}

add_action( 'wp', 'buddyboss_fix_sitewide_notices' );

/**
 * Prints sitewide notices (used in the header, by default is in footer)
 */
function buddyboss_print_sitewide_notices() {

	// Do not show notices if user is not logged in.
	if ( ! is_user_logged_in() )
		return;

	// Add a class to determine if the admin bar is on or not.
	$class = did_action( 'admin_bar_menu' ) ? 'admin-bar-on' : 'admin-bar-off';

	echo '<div id="sitewide-notice" class="' . $class . '">';
	bp_message_get_notices();
	echo '</div>';
}

/**
 * Load admin bar in header we need it to load on header for getting nodes to use on left panel but wont show it.
 *
 */
function buddyboss_admin_bar_in_header() {
	if ( !is_admin() ) {
		remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
		add_action( 'buddyboss_before_header', 'wp_admin_bar_render' );
	}
}

add_action( 'wp', 'buddyboss_admin_bar_in_header' );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Boss 1.0.0
 */
function buddyboss_page_menu_args( $args ) {
	$args[ 'show_home' ] = true;
	return $args;
}

add_filter( 'wp_page_menu_args', 'buddyboss_page_menu_args' );

/**
 * Registers all of our widget areas.
 *
 * @since Boss 1.0.0
 */
function buddyboss_widgets_init() {
	// Area 1, located in the pages and posts right column.
	register_sidebar( array(
		'name'			 => 'Page Sidebar (default)',
		'id'			 => 'sidebar',
		'description'	 => 'The default Page/Post widget area. Right column is always present.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );

	// Area 2, located in the homepage right column.
	register_sidebar( array(
		'name'			 => 'Homepage',
		'id'			 => 'home-right',
		'description'	 => 'The Homepage widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );

	register_sidebar( array(
		'name'			 => 'Copyright',
		'id'			 => 'copyright',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'description'	 => 'The Copyright widget area. Right column only appears if widgets are added.',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );

	// Area 3, located in the Members Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Members &rarr; Directory',
		'id'			 => 'members',
		'description'	 => 'The Members Directory widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 4, located in the Individual Member Profile right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Member &rarr; Single Profile',
		'id'			 => 'profile',
		'description'	 => 'The Individual Profile widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 5, located in the Groups Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Groups &rarr; Directory',
		'id'			 => 'groups',
		'description'	 => 'The Groups Directory widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 6, located in the Individual Group right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Group &rarr; Single Group',
		'id'			 => 'group',
		'description'	 => 'The Individual Group widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s"><div class="inner">',
		'after_widget'	 => '</div></aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 7, located in the Activity Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Activity &rarr; Directory',
		'id'			 => 'activity',
		'description'	 => 'The Activity Directory widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 8, located in the Forums Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Forums &rarr; Directory & Single',
		'id'			 => 'forums',
		'description'	 => 'The Forums Directory widget area. Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 9, located in the Members Directory right column. Right column only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Blogs &rarr; Directory (multisite)',
		'id'			 => 'blogs',
		'description'	 => 'The Blogs Directory widget area (only for Multisite). Right column only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h3 class="widgettitle">',
		'after_title'	 => '</h3>'
	) );
	// Area 10, located in the Footer column 1. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #1',
		'id'			 => 'footer-1',
		'description'	 => 'The first footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
	// Area 11, located in the Footer column 2. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #2',
		'id'			 => 'footer-2',
		'description'	 => 'The second footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
	// Area 12, located in the Footer column 3. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #3',
		'id'			 => 'footer-3',
		'description'	 => 'The third footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
	// Area 13, located in the Footer column 4. Only appears if widgets are added.
	register_sidebar( array(
		'name'			 => 'Footer #4',
		'id'			 => 'footer-4',
		'description'	 => 'The fourth footer widget area. Only appears if widgets are added.',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );

	register_sidebar( array(
		'name'			 => 'WooCommerce  Shop',
		'id'			 => 'woo_sidebar',
		'description'	 => 'Only display on shop page',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widgettitle">',
		'after_title'	 => '</h4>'
	) );
}

add_action( 'widgets_init', 'buddyboss_widgets_init' );

if ( !function_exists( 'buddyboss_content_nav' ) ) :

	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since Boss 1.0.0
	 */
	function buddyboss_content_nav( $nav_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) :
			?>
			<nav id="<?php echo esc_attr( $nav_id ); ?>" class="navigation" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Post navigation', 'boss' ); ?></h3>
				<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'boss' ) ); ?></div>
				<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'boss' ) ); ?></div>
			</nav><!-- #<?php echo esc_attr( $nav_id ); ?> .navigation -->
			<?php
		endif;
	}

endif;

if ( !function_exists( 'buddyboss_entry_meta' ) ) :

	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own buddyboss_entry_meta() to override in a child theme.
	 *
	 * @since Boss 1.0.0
	 */
	function buddyboss_entry_meta( $show_author = true, $show_date = true, $show_comment_info = true ) {
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'boss' ) );

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'boss' ) );

		$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark" class="post-date"><i class="far fa-clock"></i><time class="entry-date" datetime="%3$s">%4$s</time></a>', esc_url( get_permalink() ), esc_attr( get_the_time() ), esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() )
		);

		$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_attr( sprintf( __( 'View all posts by %s', 'boss' ), get_the_author() ) ), get_the_author()
		);

		if ( function_exists( 'get_avatar' ) ) {
			$avatar = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), get_avatar( get_the_author_meta( 'email' ), 55 )
			);
		}

		if ( $show_author ) {
			echo '<span class="post-author">';
			echo $avatar;
			echo $author;
			echo '</span>';
		}

		if ( $show_date ) {
			echo $date;
		}

		if ( $show_comment_info ) {
			if ( comments_open() ) :
				?>
				<!-- reply link -->
				<span class="comments-link">
					<i class="far fa-comment"></i>
					<?php comments_popup_link( '<span class="leave-reply">' . __( '0 comments', 'boss' ) . '</span>', __( '1 comment', 'boss' ), __( '% comments', 'boss' ) ); ?>
				</span><!-- .comments-link -->
				<?php
			endif; // comments_open()
		}
	}

endif;

/**
 * Extends the default WordPress body classes.
 *
 * @since Boss 1.0.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function buddyboss_body_class( $classes ) {
	global $wp_customize;

	if ( !empty( $wp_customize ) ) {
		$classes[] = 'wp-customizer';
	}
	if ( !is_multi_author() )
		$classes[] = 'single-author';

	if ( current_user_can( 'manage_options' ) ) {
		$classes[] = 'role-admin';
	}

	if ( bp_is_user_activity() || ( bp_is_group_home() && bp_is_active( 'activity' ) ) || bp_is_group_activity() || bp_is_current_component( 'activity' ) ) {
		$classes[] = 'has-activity';
	}

	return array_unique( $classes );
}

if ( buddyboss_is_bp_active() ) {
	add_filter( 'body_class', 'buddyboss_body_class' );
}

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Boss 1.0.0
 */
function buddyboss_content_width() {
	if ( is_page_template( 'full-width.php' ) || is_attachment() || !is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}

add_action( 'template_redirect', 'buddyboss_content_width' );



/* * **************************** LOGIN FUNCTIONS ***************************** */

function buddyboss_is_login_page() {
	return in_array( $GLOBALS[ 'pagenow' ], array( 'wp-login.php', 'wp-register.php' ) );
}

add_filter( 'login_redirect', 'buddyboss_redirect_previous_page', 10, 3 );

function buddyboss_redirect_previous_page( $redirect_to, $request, $user ) {

    if ( ! empty( $_GET['redirect_to'] ) ) {
        return $redirect_to;
    }

	if ( buddyboss_is_bp_active() ) {
		$bp_pages = bp_get_option( 'bp-pages' );

		$activate_page_id = !empty( $bp_pages ) && isset( $bp_pages[ 'activate' ] ) ? $bp_pages[ 'activate' ] : null;

		if ( (int) $activate_page_id <= 0 ) {
			return $redirect_to;
		}

		$activate_page = get_post( $activate_page_id );

		if ( empty( $activate_page ) || empty( $activate_page->post_name ) ) {
			return $redirect_to;
		}

		$activate_page_slug = $activate_page->post_name;

		if ( strpos( $request, '/' . $activate_page_slug ) !== false ) {
			$redirect_to = home_url();
		}
	}

	$request = isset( $_SERVER[ "HTTP_REFERER" ] ) && !empty( $_SERVER[ "HTTP_REFERER" ] ) ? $_SERVER[ "HTTP_REFERER" ] : false;

	if ( !$request ) {
		return $redirect_to;
	}

	$req_parts	 = explode( '/', $request );
	$req_part	 = array_pop( $req_parts );

	if ( substr( $req_part, 0, 3 ) == 'wp-' ) {
		return $redirect_to;
	}

	$request = str_replace( array( '?loggedout=true', '&loggedout=true' ), '', $request );

	return $request;
}

/**
 * Custom Login Logo and Helper scripts
 *
 * @since Boss 1.0.0
 */
function buddyboss_custom_login_scripts() {
	//placeholders
	if ( boss_get_option( 'boss_custom_login' ) ) {

	echo '<script>
        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById("user_login").setAttribute( "placeholder", "' . __( "Username", "boss" ) . '" );
            document.getElementById("user_pass").setAttribute( "placeholder", "' . __( "Password", "boss" ) . '" );

            var input = document.querySelectorAll(".forgetmenot input")[0];
            var label = document.querySelectorAll(".forgetmenot label")[0];
            var text = document.querySelectorAll(".forgetmenot label")[0].innerHTML.replace(/<[^>]*>/g, "");

            label.innerHTML = "";

            label.appendChild(input); ;

            label.innerHTML += "<strong>"+ text +"</strong>";

            labels = document.querySelectorAll("label");

            for (var i = labels.length - 1; i >= 0; i--)
            {
                var child = labels[i].firstChild, nextSibling;

                while (child) {
                    nextSibling = child.nextSibling;
                    if (child.nodeType == 3) {
                        child.parentNode.removeChild(child);
                    }
                    child = nextSibling;
                }
            }

        });

    </script>';

	$show		 = boss_get_option( 'boss_custom_login' );
	$logo_id	 = boss_get_option( 'boss_admin_login_logo', 'id' );
	$logo_img	 = wp_get_attachment_image_src( $logo_id, 'full' );

	// Logo styles updated for the best view
	if ( $show && $logo_id ) {
		$boss_wp_loginbox_width	 = 312;
		$boss_logo_url			 = $logo_img[ 0 ];
		$boss_logo_width		 = $logo_img[ 1 ];
		$boss_logo_height		 = $logo_img[ 2 ];

		if ( $boss_logo_width > $boss_wp_loginbox_width ) {
			$ratio					 = $boss_logo_height / $boss_logo_width;
			$boss_logo_height		 = ceil( $ratio * $boss_wp_loginbox_width );
			$boss_logo_width		 = $boss_wp_loginbox_width;
			$boss_background_size	 = 'contain';
		} else {
			$boss_background_size = 'auto';
		}

		echo '<style type="text/css">
				#login h1 a { 
				background: url( ' . esc_url( $boss_logo_url ) . ' ) no-repeat 50% 0;
                background-size: ' . esc_attr( $boss_background_size ) . ';
				overflow: hidden;
				text-indent: -9999px;
				display: block;';

		if ( $boss_logo_width && $boss_logo_height ) {
			echo 'height: ' . esc_attr( $boss_logo_height ) . 'px;
					width: ' . esc_attr( $boss_logo_width ) . 'px;
					margin: 0 auto;
					padding: 0;';
		}
		echo '}';

		echo '</style>';
	}

	$title_font = boss_get_option( 'boss_site_title_font_family' );

	$title_font = wp_parse_args( $title_font, array(
			'font-family' => '',
			'font-size' => '',
			'font-style' => '',
			'google' => '',
		));


	?>

	<style type="text/css">
		.oneall_social_login {
			padding-top: 20px;
		}
	</style>

		<style type="text/css">
			body.login {
				background-color: <?php echo esc_attr( boss_get_option( 'boss_admin_screen_background_color' ) ); ?> !important;
			}

			<?php if ( $font_family ) { ?>
				#login h1 a {
					font-family: <?php echo $font_family; ?>;
					font-size: <?php echo $font_size; ?>;
					font-weight: <?php echo $title_font[ 'font-weight' ]; ?>;
					<?php if ( $font_style ) { ?>
						font-style: <?php echo $font_style; ?>;
					<?php } ?>
				}
			<?php } ?>

			.login #nav, .login #backtoblog a, .login #nav a, .login label, .login p.indicator-hint, .admin-email-confirm-form, .login h1.admin-email__heading {
				color: <?php echo esc_attr( boss_get_option( 'boss_admin_screen_text_color' ) ); ?> !important;
			}

			.login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover {
				color: <?php echo esc_attr( boss_get_option( 'boss_admin_screen_button_color' ) ); ?> !important;
			}

			.login form .forgetmenot input[type="checkbox"]:checked + strong:before,
			.login .admin-email__actions .button-primary,
			#login form p.submit input {
				background-color: <?php echo esc_attr( boss_get_option( 'boss_admin_screen_button_color' ) ); ?> !important;
				box-shadow: none;
			}

			#login a {
				color: <?php echo esc_attr( boss_get_option( 'boss_admin_screen_button_color' ) ); ?>;
			}

		</style>

		<?php
	}
}

add_action( 'login_head', 'buddyboss_custom_login_scripts', 1 );

/**
 * Custom Login Link
 *
 * @since Boss 1.0.0
 */
function change_wp_login_url() {
	return home_url();
}

function change_wp_login_title( $login_header_title ) {
	return get_option( 'blogname' );
}

add_filter( 'login_headerurl', 'change_wp_login_url' );
add_filter( 'login_headertext', 'change_wp_login_title' );


/*
 * Adds Login form style.
 */

function buddyboss_login_stylesheet() {
	/**
	 * Assign the Boss version to a var
	 */
	$theme			 = wp_get_theme( 'boss' );
	$boss_version	 = $theme[ 'Version' ];

	$css_dest			 = ( is_rtl() ) ? '/css-rtl' : '/css';
	$css_compressed_dest = ( is_rtl() ) ? '/css-rtl-compressed' : '/css-compressed';
	$CSS_URL			 = boss_get_option( 'boss_minified_css' ) ? get_template_directory_uri() . $css_compressed_dest : get_template_directory_uri() . $css_dest;

	if ( boss_get_option( 'boss_custom_login' ) ) {
		wp_enqueue_style( 'custom-login', $CSS_URL . '/style-login.css', false, $boss_version, 'all' );
	}
}

add_action( 'login_enqueue_scripts', 'buddyboss_login_stylesheet' );


/* * **************************** ADMIN BAR FUNCTIONS ***************************** */

/**
 * Strip all waste and unuseful nodes and keep components only and memory for notification
 * @since Boss 1.0.0
 * */
function buddyboss_strip_unnecessary_admin_bar_nodes( &$wp_admin_bar ) {
	global $admin_bar_myaccount, $bb_adminbar_notifications, $bb_adminbar_messages, $bb_adminbar_friends, $bp;

	$dontalter_adminbar = apply_filters( 'boss_prevent_adminbar_processing', is_admin() );
	if ( $dontalter_adminbar ) { //nothing to do on admin
		return;
	}

	$nodes = $wp_admin_bar->get_nodes();

	$bb_adminbar_notifications[] = @$nodes[ "bp-notifications" ];

	$current_href = $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ];

	foreach ( $nodes as $name => $node ) {

		if ( $node->parent == "bp-notifications" ) {
			$bb_adminbar_notifications[] = $node;
		}

		if ( $node->parent == "" || $node->parent == "top-secondary" AND $node->id != "top-secondary" ) {
			if ( $node->id == "my-account" ) {
				continue;
			}
		}

		//adding active for parent link
		if ( $node->id == "my-account-xprofile-edit" ||
		$node->id == "my-account-groups-create" ) {

			if ( strpos( "http://" . $current_href, $node->href ) !== false ||
			strpos( "https://" . $current_href, $node->href ) !== false ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		if ( $node->id == "my-account-activity-personal" ) {
			if ( $bp->current_component == "activity" AND $bp->current_action == "just-me" AND bp_displayed_user_id() == get_current_user_id() ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		if ( $node->id == "my-account-xprofile-public" ) {
			if ( $bp->current_component == "profile" AND $bp->current_action == "public" AND bp_displayed_user_id() == get_current_user_id() ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		if ( $node->id == "my-account-messages-inbox" ) {
			$bb_adminbar_messages[] = $node;
			if ( $bp->current_component == "messages" AND $bp->current_action == "inbox" ) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
			}
		}

		

		

		//add active class if it has viewing page href
		if ( !empty( $node->href ) ) {
			if (
			( "http://" . $current_href == $node->href || "https://" . $current_href == $node->href ) ||
			( $node->id = 'my-account-xprofile-edit' && strpos( "http://" . $current_href, $node->href ) === 0 )
			) {
				buddyboss_adminbar_item_add_active( $wp_admin_bar, $name );
				//add active class to its parent
				if ( $node->parent != '' && $node->parent != 'my-account-buddypress' ) {
					foreach ( $nodes as $name_inner => $node_inner ) {
						if ( $node_inner->id == $node->parent ) {
							buddyboss_adminbar_item_add_active( $wp_admin_bar, $name_inner );
							break;
						}
					}
				}
			}
		}
	}
}

add_action( 'admin_bar_menu', 'buddyboss_strip_unnecessary_admin_bar_nodes', 999 );

function buddyboss_adminbar_item_add_active( &$wp_admin_bar, $name ) {
	$gnode = $wp_admin_bar->get_node( $name );
	if ( $gnode ) {
		$gnode->meta[ "class" ] = isset( $gnode->meta[ "class" ] ) ? $gnode->meta[ "class" ] . " active" : " active";
		$wp_admin_bar->add_node( $gnode ); //update
	}
}

/**
 * Store adminbar specific nodes to use later for buddyboss
 * @since Boss 1.0.0
 * */
function buddyboss_memory_admin_bar_nodes() {
	static $bb_memory_admin_bar_step;
	global $bb_adminbar_myaccount;

	$dontalter_adminbar = apply_filters( 'boss_prevent_adminbar_processing', is_admin() );
	if ( $dontalter_adminbar ) { //nothing to do on admin
		return;
	}

	if ( !empty( $bb_adminbar_myaccount ) ) { //avoid multiple run
		return false;
	}

	if ( empty( $bb_memory_admin_bar_step ) ) {
		$bb_memory_admin_bar_step = 1;
		ob_start();
	} else {
		$admin_bar_output = ob_get_contents();
		ob_end_clean();

		//if ( boss_show_adminbar() )
		echo $admin_bar_output;

		//strip some waste
		$admin_bar_output = str_replace( array( 'id="wpadminbar"',
			'role="navigation"',
			'class ',
			'class="nojq nojs"',
			'class="quicklinks" id="wp-toolbar"',
			'id="wp-admin-bar-top-secondary"',
			'class="ab-top-secondary ab-top-menu"',
			'id="wp-admin-bar-top-secondary"',
            'class="ab-top-secondary active ab-top-menu"',
		), '', $admin_bar_output );

		//remove screen shortcut link
		$admin_bar_output	 = @explode( '<a class="screen-reader-shortcut"', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</a>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//remove screen logout link
		$admin_bar_output	 = @explode( '<a class="screen-reader-shortcut"', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</a>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//remove script tag
		$admin_bar_output	 = @explode( '<script', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</script>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//remove user details
		$admin_bar_output	 = @explode( '<a class="ab-item"', $admin_bar_output, 2 );
		$admin_bar_output2	 = "";
		if ( count( $admin_bar_output ) > 1 ) {
			$admin_bar_output2 = @explode( "</a>", $admin_bar_output[ 1 ], 2 );
			if ( count( $admin_bar_output2 ) > 1 ) {
				$admin_bar_output2 = $admin_bar_output2[ 1 ];
			}
		}
		$admin_bar_output = $admin_bar_output[ 0 ] . $admin_bar_output2;

		//add active class into vieving link item
		$current_link = $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ];

		$bb_adminbar_myaccount = $admin_bar_output;
	}
}

add_action( "wp_before_admin_bar_render", "buddyboss_memory_admin_bar_nodes" );
add_action( "wp_after_admin_bar_render", "buddyboss_memory_admin_bar_nodes" );

/**
 * Get adminbar myaccount section output
 * Note :- this function can be overwrite with child-theme.
 * @since Boss 1.0.0
 *
 * */
function buddyboss_adminbar_myaccount() {
	global $bb_adminbar_myaccount;
	echo $bb_adminbar_myaccount;
}

/**
 * Get Notification from admin bar
 * @since Boss 1.0.0
 * */
function buddyboss_adminbar_notification() {
	global $bb_adminbar_notifications;
	return @$bb_adminbar_notifications;
}

/**
 * Get Messages
 * */
if ( !function_exists( 'buddyboss_adminbar_messages' ) ) {

	function buddyboss_adminbar_messages() {
		global $bb_adminbar_messages;
		return @$bb_adminbar_messages;
	}

}

/**
 * Get Friends
 * */
if ( !function_exists( 'buddyboss_adminbar_friends' ) ) {

	function buddyboss_adminbar_friends() {
		global $bb_adminbar_friends;
		return @$bb_adminbar_friends;
	}

}

/**
 * Remove certain admin bar links useful as we using admin bar invisibly
 * @since Boss 1.0.0
 *
 */
function remove_admin_bar_links() {
	global $wp_admin_bar;

	$wp_admin_bar->remove_menu( 'wp-logo' );
	$wp_admin_bar->remove_menu( 'shop' );
	$wp_admin_bar->remove_menu( 'search' );

	if ( !is_admin() && !current_user_can( 'administrator' ) ):
		$wp_admin_bar->remove_menu( 'site-name' );
	endif;
}

add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

/**
 * Replace admin bar "Howdy" text
 *
 * @since Boss 1.0.0
 *
 */
function replace_howdy( $wp_admin_bar ) {

	if ( is_user_logged_in() ) {

		$my_account	 = $wp_admin_bar->get_node( 'my-account' );
		$newtitle	 = str_replace( 'Howdy,', '', $my_account->title );
		$wp_admin_bar->add_node( array(
			'id'	 => 'my-account',
			'title'	 => $newtitle,
		) );
	}
}

add_filter( 'admin_bar_menu', 'replace_howdy', 25 );



/* * **************************** AVATAR FUNCTIONS ***************************** */


/**
 * Replace default member avatar
 *
 * @since Boss 1.0.0
 * @todo: this will remove in final review
 */
if ( !function_exists( 'buddyboss_addgravatar' ) ) {

	function buddyboss_addgravatar( $avatar_defaults ) {
		$myavatar						 = get_stylesheet_directory_uri() . '/images/avatar-member.jpg';
		$avatar_defaults[ $myavatar ]	 = 'BuddyBoss Man';
		return $avatar_defaults;
	}

	add_filter( 'avatar_defaults', 'buddyboss_addgravatar' );
}

/**
 * Replace default group avatar
 *
 * @since Boss 1.0.0
 */
function buddyboss_default_group_avatar( $avatar ) {
	global $bp, $groups_template;
	if ( strpos( $avatar, 'group-avatars' ) ) {
		return $avatar;
	} else {
		$custom_avatar	 = get_stylesheet_directory_uri() . '/images/avatar-group.jpg';
		$alt			 = 'group avatar';

		if ( $groups_template && !empty( $groups_template->group->name ) ) {
			$alt = esc_attr( $groups_template->group->name );
		}

		$group_id = !empty( $bp->groups->current_group->id ) ? $bp->groups->current_group->id : 0;
		if ( $bp->current_action == "" ) {
			return '<img width="' . BP_AVATAR_THUMB_WIDTH . '" height="' . BP_AVATAR_THUMB_HEIGHT . '" src="' . $custom_avatar . '" class="avatar group-' . $group_id . '-avatar" alt="' . $alt . '" />';
		} else {
			return '<img width="' . BP_AVATAR_FULL_WIDTH . '" height="' . BP_AVATAR_FULL_HEIGHT . '" src="' . $custom_avatar . '" class="avatar group-' . $group_id . '-avatar" alt="' . $alt . '" />';
		}
	}
}

add_filter( 'bp_get_group_avatar', 'buddyboss_default_group_avatar' );
add_filter( 'bp_get_new_group_avatar', 'buddyboss_default_group_avatar' );

/**
 * Change the avatar size
 * @since Boss 1.0.0
 * */
function buddyboss_avatar_full_height( $val ) {
	global $bp;
	if ( $bp->current_component == "groups" ) {
		return 400;
	}
	return $val;
}

function buddyboss_avatar_full_width( $val ) {
	global $bp;
	if ( $bp->current_component == "groups" ) {
		return 400;
	}
	return $val;
}

function buddyboss_avatar_thumb_height( $val ) {
	global $bp;
	if ( $bp->current_component == "groups" ) {
		return 150;
	}
	return $val;
}

function buddyboss_avatar_thumb_width( $val ) {
	global $bp;
	if ( $bp->current_component == "groups" ) {
		return 150;
	}
	return $val;
}

//add_filter( "bp_core_avatar_full_height", "buddyboss_avatar_full_height" );
//add_filter( "bp_core_avatar_full_width", "buddyboss_avatar_full_width" );
//add_filter( "bp_core_avatar_thumb_height", "buddyboss_avatar_thumb_height" );
//add_filter( "bp_core_avatar_thumb_width", "buddyboss_avatar_thumb_width" );



/* * **************************** WORDPRESS FUNCTIONS ***************************** */

/**
 * Custom Pagination
 * Credits: http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
 *
 * @since Boss 1.0.0
 */
function buddyboss_pagination( $pages = '', $range = 2 ) {
	$showitems = ($range * 2) + 1;

	global $paged;
	if ( empty( $paged ) )
		$paged = 1;

	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( !$pages ) {
			$pages = 1;
		}
	}

	if ( 1 != $pages ) {
		echo "<div class='pagination'>";
		if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages )
			echo "<a href='" . esc_url( get_pagenum_link( 1 ) ) . "'>&laquo;</a>";
		if ( $paged > 1 && $showitems < $pages )
			echo "<a href='" . esc_url( get_pagenum_link( $paged - 1 ) ) . "'>&lsaquo;</a>";

		for ( $i = 1; $i <= $pages; $i++ ) {
			if ( 1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) ) {
				echo ($paged == $i) ? "<span class='current'>" . intval( $i ) . "</span>" : "<a href='" . esc_url( get_pagenum_link( $i ) ) . "' class='inactive' >" . intval( $i ) . "</a>";
			}
		}

		if ( $paged < $pages && $showitems < $pages )
			echo "<a href='" . esc_url( get_pagenum_link( $paged + 1 ) ) . "'>&rsaquo;</a>";
		if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages )
			echo "<a href='" . esc_url( get_pagenum_link( $pages ) ) . "'>&raquo;</a>";
		echo "</div>\n";
	}
}

/**
 * Checks if a plugin is active.
 *
 * @since Boss 1.0.0
 */
function buddyboss_is_plugin_active( $plugin ) {
	return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
}

/**
 * Return the ID of a page set as the home page.
 *
 * @return false|int ID of page set as the home page
 * @since Boss 1.0.0
 */
if ( !function_exists( 'bp_dtheme_page_on_front' ) ) :

	function bp_dtheme_page_on_front() {
		if ( 'page' != get_option( 'show_on_front' ) )
			return false;

		return apply_filters( 'bp_dtheme_page_on_front', get_option( 'page_on_front' ) );
	}

endif;

/**
 * Add a View Profile link in Dashboard > Users panel
 *
 * @since Boss 1.0.0
 */
function user_row_actions_bp_view( $actions, $user_object ) {
	if ( function_exists( 'bp_is_active' ) ) {
		$actions[ 'view' ] = '<a href="' . bp_core_get_user_domain( $user_object->ID ) . '">' . __( 'View Profile', 'boss' ) . '</a>';
	}
	return $actions;
}

add_filter( 'user_row_actions', 'user_row_actions_bp_view', 10, 2 );

/**
 * Function that checks if BuddyPress plugin is active
 *
 * @since Boss 1.0.0
 */
function buddyboss_is_bp_active() {
	if ( function_exists( 'bp_is_active' ) ) {
		return true;
	} else {
		return false;
	}
}

function buddyboss_override_page_template( $template ) {
	global $bp;
	$id				 = get_queried_object_id();
	$page_template	 = get_page_template_slug();
	$pagename		 = get_query_var( 'pagename' );

	$bp_pages = buddypress()->pages;

	$bp_page_ids = array();

	foreach ( $bp_pages as $bp_page ) {
		$bp_page_ids[] = $bp_page->id;
	}

	if ( in_array( $id, $bp_page_ids ) ) {
		// locate_template( array( $page_template ), true );
		// var_dump( $page_template, $id, $template, $pagename, buddypress()->pages );
	}
	// die;
}

// add_action( 'template_redirect', 'buddyboss_override_page_template' );

/**
 * Function that modify wp_list_categories function's post count
 *
 * @since Boss 1.0.0
 */
function cat_count_span_inline( $output ) {
	$output	 = str_replace( '</a> (', '</a><span><i>', $output );
	$output	 = str_replace( ')', '</i></span> ', $output );
	return $output;
}

add_filter( 'wp_list_categories', 'cat_count_span_inline' );

/**
 * Function that modify bp_new_group_invite_friend_list function's input checkboxes
 *
 * @since Boss 1.0.0
 */
function buddyboss_new_group_invite_friend_list() {
	echo buddyboss_get_new_group_invite_friend_list();
}

function buddyboss_get_new_group_invite_friend_list( $args = '' ) {
	global $bp;

	if ( !bp_is_active( 'friends' ) )
		return false;

	$defaults = array(
		'group_id'	 => false,
		'separator'	 => 'li'
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	if ( empty( $group_id ) )
		$group_id = !empty( $bp->groups->new_group_id ) ? $bp->groups->new_group_id : $bp->groups->current_group->id;

	if ( $friends = friends_get_friends_invite_list( bp_loggedin_user_id(), $group_id ) ) {
		$invites = groups_get_invites_for_group( bp_loggedin_user_id(), $group_id );

		for ( $i = 0, $count = count( $friends ); $i < $count; ++$i ) {
			$checked = '';

			if ( !empty( $invites ) ) {
				if ( in_array( $friends[ $i ][ 'id' ], $invites ) )
					$checked = ' checked="checked"';
			}

			$items[] = '<' . $separator . '><label><input' . $checked . ' type="checkbox" name="friends[]" id="f-' . $friends[ $i ][ 'id' ] . '" value="' . esc_attr( $friends[ $i ][ 'id' ] ) . '" />' . $friends[ $i ][ 'full_name' ] . '</label></' . $separator . '>';
		}
	}

	if ( !empty( $items ) )
		return implode( "\n", (array) $items );

	return false;
}

/**
 * Output a fancy description of the current forum, including total topics,
 * total replies, and last activity.
 *
 * @since Boss 1.0.0
 *
 * @param array $args Arguments passed to alter output
 * @uses bbp_get_single_forum_description() Return the eventual output
 */
function buddyboss_bbp_single_forum_description( $args = '' ) {
	echo buddyboss_bbp_get_single_forum_description( $args );
}

/**
 * Return a fancy description of the current forum, including total
 * topics, total replies, and last activity.
 *
 * @since Boss 1.0.0
 *
 * @param mixed $args This function supports these arguments:
 *  - forum_id: Forum id
 *  - before: Before the text
 *  - after: After the text
 *  - size: Size of the avatar
 * @uses bbp_get_forum_id() To get the forum id
 * @uses bbp_get_forum_topic_count() To get the forum topic count
 * @uses bbp_get_forum_reply_count() To get the forum reply count
 * @uses bbp_get_forum_freshness_link() To get the forum freshness link
 * @uses bbp_get_forum_last_active_id() To get the forum last active id
 * @uses bbp_get_author_link() To get the author link
 * @uses add_filter() To add the 'view all' filter back
 * @uses apply_filters() Calls 'bbp_get_single_forum_description' with
 *                        the description and args
 * @return string Filtered forum description
 */
function buddyboss_bbp_get_single_forum_description( $args = '' ) {

	// Parse arguments against default values
	$r = bbp_parse_args( $args, array(
		'forum_id'	 => 0,
		'before'	 => '<div class="bbp-template-notice info"><p class="bbp-forum-description">',
		'after'		 => '</p></div>',
		'size'		 => 14,
		'feed'		 => true
	), 'get_single_forum_description' );

	// Validate forum_id
	$forum_id = bbp_get_forum_id( $r[ 'forum_id' ] );

	// Unhook the 'view all' query var adder
	remove_filter( 'bbp_get_forum_permalink', 'bbp_add_view_all' );

	// Get some forum data
	$tc_int		 = bbp_get_forum_topic_count( $forum_id, false );
	$rc_int		 = bbp_get_forum_reply_count( $forum_id, false );
	$topic_count = bbp_get_forum_topic_count( $forum_id );
	$reply_count = bbp_get_forum_reply_count( $forum_id );
	$last_active = bbp_get_forum_last_active_id( $forum_id );

	// Has replies
	if ( !empty( $reply_count ) ) {
		$reply_text = sprintf( _n( '%s reply', '%s replies', $rc_int, 'boss' ), $reply_count );
	}

	// Forum has active data
	if ( !empty( $last_active ) ) {
		$topic_text		 = bbp_get_forum_topics_link( $forum_id );
		$time_since		 = bbp_get_forum_freshness_link( $forum_id );
		$last_updated_by = bbp_get_author_link( array( 'post_id' => $last_active, 'size' => $r[ 'size' ] ) );

		// Forum has no last active data
	} else {
		$topic_text = sprintf( _n( '%s topic', '%s topics', $tc_int, 'boss' ), $topic_count );
	}

	// Forum has active data
	if ( !empty( $last_active ) ) {

		if ( !empty( $reply_count ) ) {

			if ( bbp_is_forum_category( $forum_id ) ) {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span> <span class="last-activity">Last updated by %3$s %4$s</span>', 'boss' ), $topic_text, $reply_text, $last_updated_by, $time_since );
			} else {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span> <span class="last-activity">Last updated by %3$s %4$s<span>', 'boss' ), $topic_text, $reply_text, $last_updated_by, $time_since );
			}
		} else {

			if ( bbp_is_forum_category( $forum_id ) ) {
				$retstr = sprintf( __( '<span class="post-num">%1$s</span> <span class="last-activity">Last updated by %2$s %3$s</span>', 'boss' ), $topic_text, $last_updated_by, $time_since );
			} else {
				$retstr = sprintf( __( '<span class="post-num">%1$s</span> <span class="last-activity">Last updated by %2$s %3$s</span>', 'boss' ), $topic_text, $last_updated_by, $time_since );
			}
		}

		// Forum has no last active data
	} else {

		if ( !empty( $reply_count ) ) {

			if ( bbp_is_forum_category( $forum_id ) ) {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span>', 'boss' ), $topic_text, $reply_text );
			} else {
				$retstr = sprintf( __( '<span class="post-num">%1$s and %2$s</span>', 'boss' ), $topic_text, $reply_text );
			}
		} else {

			if ( !empty( $topic_count ) ) {

				if ( bbp_is_forum_category( $forum_id ) ) {
					$retstr = sprintf( __( '<span class="post-num">%1$s</span>', 'boss' ), $topic_text );
				} else {
					$retstr = sprintf( __( '<span class="post-num">%1$s</span>', 'boss' ), $topic_text );
				}
			} else {
				$retstr = __( '<span class="post-num">0 topics and 0 posts</span>', 'boss' );
			}
		}
	}

	// Add feeds
	//$feed_links = ( !empty( $r['feed'] ) ) ? bbp_get_forum_topics_feed_link ( $forum_id ) . bbp_get_forum_replies_feed_link( $forum_id ) : '';
	// Add the 'view all' filter back
	add_filter( 'bbp_get_forum_permalink', 'bbp_add_view_all' );

	// Combine the elements together
	$retstr = $r[ 'before' ] . $retstr . $r[ 'after' ];

	// Return filtered result
	return apply_filters( 'bbp_get_single_forum_description', $retstr, $r );
}

/**
 * Output a fancy description of the current topic, including total topics,
 * total replies, and last activity.
 *
 * @since Boss 1.0.0
 *
 * @param array $args See {@link bbp_get_single_topic_description()}
 * @uses bbp_get_single_topic_description() Return the eventual output
 */
function buddyboss_bbp_single_topic_description( $args = '' ) {
	echo buddyboss_bbp_get_single_topic_description( $args );
}

/**
 * Return a fancy description of the current topic, including total topics,
 * total replies, and last activity.
 *
 * @since Boss 1.0.0
 *
 * @param mixed $args This function supports these arguments:
 *  - topic_id: Topic id
 *  - before: Before the text
 *  - after: After the text
 *  - size: Size of the avatar
 * @uses bbp_get_topic_id() To get the topic id
 * @uses bbp_get_topic_voice_count() To get the topic voice count
 * @uses bbp_get_topic_reply_count() To get the topic reply count
 * @uses bbp_get_topic_freshness_link() To get the topic freshness link
 * @uses bbp_get_topic_last_active_id() To get the topic last active id
 * @uses bbp_get_reply_author_link() To get the reply author link
 * @uses apply_filters() Calls 'bbp_get_single_topic_description' with
 *                        the description and args
 * @return string Filtered topic description
 */
function buddyboss_bbp_get_single_topic_description( $args = '' ) {

	// Parse arguments against default values
	$r = bbp_parse_args( $args, array(
		'topic_id'	 => 0,
		'before'	 => '<div class="bbp-template-notice info"><p class="bbp-topic-description">',
		'after'		 => '</p></div>',
		'size'		 => 14
	), 'get_single_topic_description' );

	// Validate topic_id
	$topic_id = bbp_get_topic_id( $r[ 'topic_id' ] );

	// Unhook the 'view all' query var adder
	remove_filter( 'bbp_get_topic_permalink', 'bbp_add_view_all' );

	// Build the topic description
	$vc_int		 = bbp_get_topic_voice_count( $topic_id, true );
	$voice_count = bbp_get_topic_voice_count( $topic_id, false );
	$reply_count = bbp_get_topic_replies_link( $topic_id );
	$time_since	 = bbp_get_topic_freshness_link( $topic_id );

	// Singular/Plural
	$voice_count = sprintf( _n( '%s voice', '%s voices', $vc_int, 'boss' ), $voice_count );

	// Topic has replies
	$last_reply = bbp_get_topic_last_reply_id( $topic_id );
	if ( !empty( $last_reply ) ) {
		$last_updated_by = bbp_get_author_link( array( 'post_id' => $last_reply, 'size' => $r[ 'size' ] ) );
		$retstr			 = sprintf( __( '<span class="post-num">%1$s, %2$s</span> <span class="last-activity">Last updated by %3$s %4$s</span>', 'boss' ), $reply_count, $voice_count, $last_updated_by, $time_since );

		// Topic has no replies
	} elseif ( !empty( $voice_count ) && !empty( $reply_count ) ) {
		$retstr = sprintf( __( '<span class="post-num">%1$s, %2$s</span>', 'boss' ), $voice_count, $reply_count );

		// Topic has no replies and no voices
	} elseif ( empty( $voice_count ) && empty( $reply_count ) ) {
		$retstr = sprintf( __( '<span class="post-num">0 replies</span>', 'boss' ), $voice_count, $reply_count );
	}

	// Add the 'view all' filter back
	add_filter( 'bbp_get_topic_permalink', 'bbp_add_view_all' );

	// Combine the elements together
	$retstr = $r[ 'before' ] . $retstr . $r[ 'after' ];

	// Return filtered result
	return apply_filters( 'bbp_get_single_topic_description', $retstr, $r );
}

/**
 * Places "Compose" to the first place on messages navigation links
 *
 * @since Boss 1.0.0
 *
 */
function tricks_change_bp_tag_position() {
	global $bp;
	$version_compare = version_compare( BP_VERSION, '2.6', '<' );
	if ( $version_compare ) {
		$bp->bp_options_nav[ 'messages' ][ 'compose' ][ 'position' ] = 10;
		$bp->bp_options_nav[ 'messages' ][ 'inbox' ][ 'position' ]	 = 11;
		$bp->bp_options_nav[ 'messages' ][ 'sentbox' ][ 'position' ] = 30;
	} else {
		if ( !empty( $bp->messages ) ) {
			$subnavs = array( 'compose' => 10, 'inbox' => 11, 'sentbox' => 30, );
			foreach ( $subnavs as $subnav => $pos ) {
				$nav_args = array( 'position' => $pos );
				$bp->members->nav->edit_nav( $nav_args, $subnav, 'messages' );
			}
		}
	}
}

add_action( 'bp_init', 'tricks_change_bp_tag_position', 999 );

/**
 * Output the markup for the message type dropdown.
 *
 * @since Boss 1.0.0
 *
 */
function buddyboss_bp_messages_options() {
	?>

	<select name="message-type-select" id="message-type-select">
		<option value=""></option>
		<option value="read"><?php _ex( 'Read', 'Message dropdown filter', 'boss' ) ?></option>
		<option value="unread"><?php _ex( 'Unread', 'Message dropdown filter', 'boss' ) ?></option>
		<option value="all"><?php _ex( 'All', 'Message dropdown filter', 'boss' ) ?></option>
	</select> &nbsp;

	<?php if ( !bp_is_current_action( 'sentbox' ) && bp_is_current_action( 'notices' ) ) : ?>

		<a href="#" id="mark_as_read"><?php _ex( 'Mark as Read', 'Message management markup', 'boss' ) ?></a> &nbsp;
		<a href="#" id="mark_as_unread"><?php _ex( 'Mark as Unread', 'Message management markup', 'boss' ) ?></a> &nbsp;

	<?php endif; ?>

		<a href="#" id="delete_<?php echo bp_current_action(); ?>_messages" class="bb-delete-link"><i class="fas fa-trash-alt"></i></a> &nbsp;

	<?php
}

/**
 * Custom Walker for left panel menu
 *
 * @since Boss 1.0.0
 *
 */
class BuddybossWalker extends Walker {

	/**
	 * What the class handles.
	 *
	 * @see Walker::$tree_type
	 * @since Boss 1.0.0
	 * @var string
	 */
	public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

	/**
	 * Database fields to use.
	 *
	 * @see Walker::$db_fields
	 * @since Boss 1.0.0
	 * @todo Decouple this.
	 * @var array
	 */
	public $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since Boss 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent	 = str_repeat( "\t", $depth );
		$output	 .= "\n$indent<div class='sub-menu-wrap'><ul class=\"sub-menu\">\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since Boss 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent	 = str_repeat( "\t", $depth );
		$output	 .= "$indent</ul></div>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since Boss 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$icon_classes = array();
		$registered_icon_classes = array( 'bp-blogs-nav', 'bp-activity-nav', 'bp-profile-nav', 'bp-notifications-nav', 'bp-messages-nav', 'bp-friends-nav', 'bp-followers-nav', 'bp-following-nav', 'bp-groups-nav', 'bp-forums-nav', 'bp-settings-nav', 'bp-logout-nav', 'bp-login-nav', 'bp-register-nav', 'bp-courses-nav', 'bp-achievements-nav' );
		$in_registered_icon_classes = false;

		foreach ( $item->classes as $key => $value ) {
			if ( substr( $value, 0, 3 ) === 'fa-' || substr( $value, 0, 2 ) === 'fa' || substr( $value, 0, 3 ) === 'fab' || substr( $value, 0, 3 ) === 'far' ) {
				$icon_classes[] = $value;
			}
			if ( substr( $value, 0, 2 ) === 'fa' ) {
				unset( $item->classes[ $key ] );
			}
			if( in_array( $value, $registered_icon_classes ) ) {
				$in_registered_icon_classes = true;
				break;
            }
		}

		if ( $item->menu_item_parent === '0' && empty( $icon_classes ) ) {
			$icon_classes[] = 'far fa-arrow-alt-circle-right';
		}

		if ( $in_registered_icon_classes ) {
			$icon_classes = array();
        }

		$classes	 = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[]	 = 'menu-item-' . $item->ID;

		/**
		 * Filter the CSS class(es) applied to a menu item's <li>.
		 *
		 * @since Boss 1.0.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's <li>.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of wp_nav_menu() arguments.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's <li>.
		 *
		 * @since Boss 1.0.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param string $menu_id The ID that is applied to the menu item's <li>.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of wp_nav_menu() arguments.
		 */
		$id	 = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id	 = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts				 = array();
		$atts[ 'title' ]	 = !empty( $item->attr_title ) ? $item->attr_title : '';
		$atts[ 'target' ]	 = !empty( $item->target ) ? $item->target : '';
		$atts[ 'rel' ]		 = !empty( $item->xfn ) ? $item->xfn : '';
		$atts[ 'href' ]		 = !empty( $item->url ) ? $item->url : '';

		/**
		 * Filter the HTML attributes applied to a menu item's <a>.
		 *
		 * @since Boss 1.0.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item The current menu item.
		 * @param array  $args An array of wp_nav_menu() arguments.
		 */
		$archor_classes = join( ' ', $icon_classes );
		$archor_classes = 'class="' . esc_attr( $archor_classes ) . '"';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( !empty( $value ) ) {
				$value		 = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes	 .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		if ( ! empty( $icon_classes ) && ! empty( $args->theme_location ) && in_array( $args->theme_location, array('left-panel-menu', 'header-menu') ) ) {
			$item_output .= '<i ' . $archor_classes . '></i>';
		}
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes $args->before, the opening <a>,
		 * the menu item's title, the closing </a>, and $args->after. Currently, there is
		 * no filter for modifying the opening and closing <li> for a menu item.
		 *
		 * @since Boss 1.0.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @since Boss 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

}

// Walker_Nav_Menu


/*
 * Removing the create a group button from under the title
 *
 * @since Boss 1.0.0
 */

function buddyboss_remove_group_create_button() {
	if ( bp_is_active( 'groups' ) ) {
		remove_filter( 'bp_groups_directory_header', 'bp_legacy_theme_group_create_button' );
	}
}

add_action( "bp_init", "buddyboss_remove_group_create_button" );


/*
 * Places content bellow title on dir pages
 *
 * @since Creacial 1.0.0
 */

function inject_content() {
	global $bp;

	$custom_content = '';

	if ( bp_is_directory() ) {
		foreach ( (array) $bp->pages as $page_key => $bp_page ) {
			if ( $bp_page->slug == bp_current_component() || ($bp_page->slug == 'sites' && bp_current_component() == 'blogs') ) {
				$page_id = $bp_page->id;

				$page_query = new WP_query( array(
					'post_type'	 => 'page',
					'page_id'	 => $page_id
				) );

				$output_page = get_post( $page_id );

				$custom_content = wpautop( $output_page->post_content );
			}
		}
	}

	echo '<div class="entry-content">' . $custom_content . '</div>';
}

add_action( 'bp_before_directory_members_content', 'inject_content' );
add_action( 'bp_before_directory_groups_content', 'inject_content' );
add_action( 'bp_before_directory_blogs_content', 'inject_content' );
add_action( 'bp_before_directory_activity_content', 'inject_content' );

/*
 * Get title on dir pages
 *
 * @since Creacial 1.0.0
 */

function buddyboss_page_title() {
	echo buddyboss_get_page_title();
}

function buddyboss_get_page_title() {
	global $bp;

	if ( bp_is_directory() ) {
		foreach ( (array) $bp->pages as $page_key => $bp_page ) {

			if ( $bp_page->slug == bp_current_component() || ($bp_page->slug == 'sites' && bp_current_component() == 'blogs') ) {
				$page_id = $bp_page->id;

				$page_query = new WP_query( array(
					'post_type'	 => 'page',
					'page_id'	 => $page_id
				) );

				$output_page = get_post( $page_id );

				$custom_title = apply_filters( 'the_title', $output_page->post_title );
			}
		}
	}

	$pattern	 = '/([\s]*|&nbsp;)<a/im';
	$bp_title	 = '';
	$bp_title	 = get_the_title();
	// If we have a custom title and need to grab a BP title button
	if ( !empty( $custom_title ) && (int) preg_match( $pattern, $bp_title ) > 0 ) {
		$token = md5( '#b#u#d#d#y#b#o#s#s#' );

		$bp_title_parsed = preg_replace( $pattern, $token, $bp_title );

		$bp_title_parts = explode( $token, $bp_title_parsed, 2 );

		$custom_title .= '&nbsp;<a' . $bp_title_parts[ 1 ];
	}

	if ( empty( $custom_title ) ) {
		$custom_title = $bp_title;
	}

	return $custom_title;
}

add_action( 'wp_head', 'bb_check_page_template' );

function bb_check_page_template() {
	if ( is_page_template( 'page-boxed.php' ) ) {
		add_filter( 'boss_redux_option_value', 'boss_filter_layout', 10, 3 );
	}
}

/**
 * Filter Layout Option from Redux
 * @param  String $value value from Redux
 * @param  String $id    option name
 * @param  String $param default value
 * @return String new value
 */
function boss_filter_layout( $value, $id, $param ) {
	if ( $id == 'boss_layout_style' ) {
		$value = 'boxed';
	}
	return $value;
}

/**
 * Adds classes to body
 *
 * @since Boss 1.0.0
 *
 */
add_filter( 'body_class', 'buddyboss_body_classes' );

function buddyboss_body_classes( $classes ) {

	global $learner;

	$panel_class = 'left-menu-open';

	// Learner enabled
	if ( $learner ) {
		$classes[] = 'social-learner';
	}

	// Boxed layout
	if ( boss_get_option( 'boss_layout_style' ) == 'boxed' ) {
		$classes[]	 = 'boxed';
		$classes[]	 = $panel_class;
	}

	// Default layout class
	if ( is_phone() ) {
		$classes[] = 'is-mobile';
	} elseif ( wp_is_mobile() ) {
		if ( boss_get_option( 'boss_layout_tablet' ) == 'desktop' ) {
			$classes[] = 'is-desktop';
		} else {
			$classes[] = 'is-mobile';
		}
		$classes[] = 'tablet';
	} else {
		if ( boss_get_option( 'boss_layout_desktop' ) == 'mobile' ) {
			$classes[] = 'is-mobile';
		} else {
			$classes[] = 'is-desktop';
		}
	}

	// Switch layout class
	if ( isset( $_COOKIE[ 'switch_mode' ] ) && ( boss_get_option( 'boss_layout_switcher' ) ) ) {
		if ( $_COOKIE[ 'switch_mode' ] == 'mobile' ) {
			if ( ($key = array_search( 'is-desktop', $classes )) !== false ) {
				unset( $classes[ $key ] );
			}
			$classes[] = 'is-mobile';
		} else {
			if ( ($key = array_search( 'is-mobile', $classes )) !== false ) {
				unset( $classes[ $key ] );
			}
			$classes[] = 'is-desktop';
		}
	}


	// is bbpress active
	if ( buddyboss_is_bp_active() ) {
		$classes[] = 'bp-active';
	}

	// is panel active
	if ( isset( $_COOKIE[ 'left-panel-status' ] ) ) {
		if ( $_COOKIE[ 'left-panel-status' ] == 'open' ) {
			$classes[] = $panel_class;
		}
	} elseif ( boss_get_option( 'boss_panel_state' ) ) {
		$classes[] = $panel_class;
	}

	// is global media page
	if ( function_exists( 'buddyboss_media' ) && ! empty( buddyboss_media() ) && buddyboss_media()->option( 'all-media-page' ) && is_page( buddyboss_media()->option( 'all-media-page' ) ) ) {
		$classes[] = 'buddyboss-media-all-media';
	}

	//hide buddypanel
	if ( !boss_get_option( 'boss_panel_hide' ) && !is_user_logged_in() ) {
		$classes[]	 = 'page-template-page-no-buddypanel';
		$classes[]	 = $panel_class;
	}

	if ( is_page_template( 'page-no-buddypanel.php' ) ) {
		$classes[] = $panel_class;
	}

	// Adminbar class
	if ( ! boss_show_adminbar( 'boss_adminbar' ) ) {
		$classes[] = 'no-adminbar';
	}

	// Cover photo sizes
	$profile_cover_height = esc_attr( boss_get_option( 'boss_profile_cover_sizes' ) );
	$group_cover_height = esc_attr( boss_get_option( 'boss_cover_group_size' ) );

	if ( !empty( $profile_cover_height ) ) {
		$classes[] = 'profile-cover-' . $profile_cover_height;
	}

	if ( !empty( $group_cover_height ) ) {
		$classes[] = 'group-cover-' . $group_cover_height;
	}

	return array_unique( $classes );
}

/**
 * Correct notification count in header notification
 *
 * @since Boss 1.0.0
 *
 */
function buddyboss_js_correct_notification_count() {
	if ( !is_user_logged_in() || !buddyboss_is_bp_active() || !function_exists( "bp_notifications_get_all_notifications_for_user" ) )
		return;
	$notifications = bp_notifications_get_all_notifications_for_user( bp_loggedin_user_id() );
	if ( !empty( $notifications ) ) {
		$count = count( $notifications );
		?>
		<script type="text/javascript">
		    jQuery( 'document' ).ready( function ( $ ) {
		        $( '.header-notifications .notification-link span.alert' ).html( '<?php echo $count; ?>' );
		    } );
		</script>
		<?php
	}
}

add_action( 'wp_footer', 'buddyboss_js_correct_notification_count' );

/**
 * Heartbeat settings
 *
 * @since Boss 1.0.0
 *
 */
function buddyboss_heartbeat_settings( $settings ) {
	$settings[ 'interval' ] = 5; //pulse on each 20 sec.
	return $settings;
}

add_filter( 'heartbeat_settings', 'buddyboss_heartbeat_settings' );

/**
 * Sending a heartbeat for notification updates
 *
 * @since Boss 1.0.0
 *
 */
function buddyboss_notification_count_heartbeat( $response, $data, $screen_id ) {

	if ( function_exists( "bp_friend_get_total_requests_count" ) )
		$friend_request_count	 = bp_friend_get_total_requests_count();

	$notification_count = 0;

	if ( function_exists( "bp_notifications_get_all_notifications_for_user" ) ) {
		$notifications			 = bp_notifications_get_notifications_for_user( get_current_user_id(), 'object' );
		$notification_count		 = $notifications ? count( $notifications ) : 0;
		$notification_content	 = '';

		// Check if unread notification count is not same as the unread notification count already displayed at the frontend
		if ( $data['unread_notifications'] != $notification_count ) {

			if ( 0 < $notification_count ) {
				foreach ( (array) $notifications as $notification ) {
					if ( is_object( $notification ) ) {
						if ( isset( $notification->href ) && isset( $notification->content ) ) {
							$notification_content .= "<a href='" . esc_url( $notification->href ) . "'>{$notification->content}</a>";
						}
					} else {
						$notification_content .= $notification;
					}
				}
			} else {
				$notification_content = '<a href="' . bp_loggedin_user_domain() . '' . BP_NOTIFICATIONS_SLUG . '/">' . __( "No new notifications", "buddypress" ) . '</a>';
			}
		}
	}

	if ( function_exists( "messages_get_unread_count" ) ) {
		$unread_message_count = messages_get_unread_count();
		$message_content = '';
		// Check if unread message count is not same as the unread message count already displayed at the frontend
		if ( $unread_message_count != $data['unread_messages'] ) {
			$message_content = buddyboss_get_unread_messages_html();
		}
    }

	$response[ 'bb_notification_count' ] = array(
		'friend_request'		 => @intval( $friend_request_count ),
		'notification'			 => @intval( $notification_count ),
		'notification_content'	 => @$notification_content,
		'unread_message'		 => @intval( $unread_message_count ),
        'message_content'       => @$message_content
	);

	return $response;
}

// Logged in users:
add_filter( 'heartbeat_received', 'buddyboss_notification_count_heartbeat', 10, 3 );

/**
 * Add @handle to forum replies
 *
 * @since Boss 1.0.0
 *
 */
function buddyboss_add_handle() {
	if ( bbp_get_reply_id() ) {
		$bb_username = get_userdata( bbp_get_reply_author_id( bbp_get_reply_id() ) );
		echo '<span class="bbp-user-nicename"><span class="handle-sign">@</span>' . $bb_username->user_login . '</span>';
	}
}

add_action( 'bbp_theme_after_reply_author_details', 'buddyboss_add_handle' );


/*
 * Resize images dynamically using wp built in functions
 *
 *
 * Example:
 *
 * <?php
 * $thumb = get_post_thumbnail_id();
 * $image = buddyboss_resize( $thumb, '', 140, 110, true );
 * ?>
 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
 */
if ( !function_exists( 'buddyboss_resize' ) ) {

	function buddyboss_resize( $attach_id = null, $img_url = null, $ratio = null, $width = null, $height = null,
							$crop = false ) {
		// Cast $width and $height to integer
		$width	 = intval( $width );
		$height	 = intval( $height );
		// this is an attachment, so we have the ID
		if ( $attach_id ) {
			$image_src	 = wp_get_attachment_image_src( $attach_id, 'full' );
			$file_path	 = get_attached_file( $attach_id );
			// this is not an attachment, let's use the image url
		} else if ( $img_url ) {
			if ( false === ( $upload_dir = wp_cache_get( 'upload_dir', 'cache' ) ) ) {
				$upload_dir = wp_upload_dir();
				wp_cache_set( 'upload_dir', $upload_dir, 'cache' );
			}
			$file_path		 = explode( $upload_dir[ 'baseurl' ], $img_url );
			$file_path		 = $upload_dir[ 'basedir' ] . $file_path[ '1' ];
			//$file_path = ltrim( $file_path['path'], '/' );
			//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
			$orig_size		 = getimagesize( $file_path );
			$image_src[ 0 ]	 = $img_url;
			$image_src[ 1 ]	 = $orig_size[ 0 ];
			$image_src[ 2 ]	 = $orig_size[ 1 ];
		}
		$file_info = pathinfo( $file_path );
		// check if file exists
		if ( empty( $file_info[ 'dirname' ] ) && empty( $file_info[ 'filename' ] ) && empty( $file_info[ 'extension' ] ) )
			return $image_src;

		$base_file			 = $file_info[ 'dirname' ] . '/' . $file_info[ 'filename' ] . '.' . $file_info[ 'extension' ];
		if ( !file_exists( $base_file ) )
            return $image_src;
		$extension			 = '.' . $file_info[ 'extension' ];
		// the image path without the extension
		$no_ext_path		 = $file_info[ 'dirname' ] . '/' . $file_info[ 'filename' ];
        
        if ( $file_info[ 'extension' ] == 'svg' ) {
            $cropped_img_path	 = $no_ext_path . $extension;
            return $image_src[ 0 ];
        } else {
            $cropped_img_path	 = $no_ext_path . '-' . $width . 'x' . $height . $extension;   
        }
        
		// checking if the file size is larger than the target size
		// if it is smaller or the same size, stop right here and return

		if ( file_exists( $cropped_img_path ) ) {
			$cropped_img_url = str_replace( basename( $image_src[ 0 ] ), basename( $cropped_img_path ), $image_src[ 0 ] );
			$vt_image		 = array(
				'url'	 => $cropped_img_url,
				'width'	 => $width,
				'height' => $height
			);
			return $vt_image;
		}


		// Check if GD Library installed
		if ( !function_exists( 'imagecreatetruecolor' ) ) {
			echo 'GD Library Error: imagecreatetruecolor does not exist - please contact your web host and ask them to install the GD library';
			return;
		}
		// no cache files - let's finally resize it
		$image = wp_get_image_editor( $file_path );
		if ( !is_wp_error( $image ) ) {

			if ( $ratio ) {
				$size_array	 = $image->get_size();
				$width		 = $size_array[ 'width' ];
				$old_height	 = $size_array[ 'height' ];
				$height		 = intval( $width / $ratio );

				if ( $height > $old_height ) {
					$width	 = $old_height * $ratio;
					$height	 = $old_height;
				}
			}

			$image->resize( $width, $height, $crop );
			$save_data		 = $image->save();
			if ( ! is_wp_error( $save_data ) && isset( $save_data[ 'path' ] ) )
				$new_img_path	 = $save_data[ 'path' ];
		}

		if ( empty( $new_img_path ) ) {
		    return false;
        }

		$new_img_size	 = getimagesize( $new_img_path );
		$new_img		 = str_replace( basename( $image_src[ 0 ] ), basename( $new_img_path ), $image_src[ 0 ] );
		// resized output
		$vt_image		 = array(
			'url'	 => $new_img,
			'width'	 => $new_img_size[ 0 ],
			'height' => $new_img_size[ 1 ]
		);
		return $new_img;
	}

}

/**
 * Sensei plugin wrappers
 *
 * @since Boss 1.0.9
 *
 */
global $woothemes_sensei;
if ( $woothemes_sensei ) {
	remove_action( 'sensei_before_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ), 10 );
	remove_action( 'sensei_after_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ), 10 );

	if ( !function_exists( 'boss_education_wrapper_start' ) ) :
		add_action( 'sensei_before_main_content', 'boss_education_wrapper_start', 10 );

		function boss_education_wrapper_start() {
			if ( is_active_sidebar( 'sidebar' ) ) :
				echo '<div class="page-right-sidebar">';
			else :
				echo '<div class="page-full-width">';
			endif;
			echo '<div id="primary" class="site-content"><div id="content" role="main" class="sensei-content">';
		}

	endif;

	if ( !function_exists( 'boss_education_wrapper_end' ) ) :
		add_action( 'sensei_after_main_content', 'boss_education_wrapper_end', 10 );

		function boss_education_wrapper_end() {
			echo '</div><!-- #content -->
            </div><!-- #primary -->';
			get_sidebar();
			echo '</div><!-- .page-right-sidebar -->';
		}

	endif;
}
/**
 * Declaring Sensei Support
 *
 * @since Boss 1.1.0
 *
 */
add_action( 'after_setup_theme', 'declare_sensei_support' );

function declare_sensei_support() {
	add_theme_support( 'sensei' );
}

/**
 * Header cart live update
 *
 * @since Boss 1.1.0
 *
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woo_add_to_cart_ajax' );

function woo_add_to_cart_ajax( $fragments ) {
	global $woocommerce;
	ob_start();
	$cart_items = $woocommerce->cart->cart_contents_count;
	$mobile_classes = wp_is_mobile() ? 'sidebar-btn table-cell' : '';
	?>
	<a class="cart-notification notification-link <?php echo $mobile_classes; ?>" href="<?php echo wc_get_cart_url(); ?>">
		<i class="fa fa-shopping-cart"></i>
		<?php if ( $cart_items ) { ?>
			<span><?php echo $cart_items; ?></span>
		<?php } ?>
	</a>
	<?php
	$fragments[ 'a.cart-notification' ] = ob_get_clean();
	return $fragments;
}

/**
 * Removing woocomerce function that disables adminbar for subsribers
 *
 * @since Boss 1.1.4
 *
 */
remove_filter( 'show_admin_bar', 'wc_disable_admin_bar' );


add_action( 'boss_get_group_template', 'boss_get_group_template' );

function boss_get_group_template() {

	//Group Blog plugin template issue fix
	if ( function_exists( 'bp_set_template_included' ) ) {
		bp_set_template_included( 'group-single' );
	}

	bp_get_template_part( 'buddypress', 'group-single' );
}

// Add thumbnail size just for this custom post type
add_image_size( 'buddyboss_slides', 1040, 400, true );

/**
 * Add image size for cover photo.
 *
 * @since Boss 1.1.7
 */
if ( !function_exists( 'boss_cover_thumbnail' ) ) :

	add_action( 'after_setup_theme', 'boss_cover_thumbnail' );

	function boss_cover_thumbnail() {
		add_image_size( 'boss-cover-image', 1500, 500, true );
	}

endif;

/**
 * Buddyboss inbox layout support
 */
function boss_bb_inbox_selectbox() {
	if ( function_exists( 'bbm_inbox_pagination' ) ) {
		remove_action( 'bp_before_member_messages_threads', 'bbm_inbox_pagination', 99 );
	}
}

add_action( 'wp', 'boss_bb_inbox_selectbox' );

/**
 * Overriding BB Inbox Label button html
 * @param type $html
 * @return string
 */
function bbm_label_button_html_override( $html ) {
	$new_html	 = '<a class="bbm-label-button" title="Add/Create Label" href="javascript:void(0)">';
	$new_html	 .= '<span class="hida"><i class="fa fa-tag"></i></span>';
	$new_html	 .= '<p class="multiSel"></p></a>';

	return $new_html;
}

add_filter( 'bbm_label_button_html', 'bbm_label_button_html_override' );

/**
 * Buddypress Docs Count Tabs
 */
function bb_child_doc_menu_count_tabs() {
	global $bp, $wpdb;

	if ( !function_exists( 'bp_is_active' ) ) {
		return;
	}

	$numdocsposts = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'publish' AND post_type = 'bp_doc' AND post_author='" . bp_displayed_user_id() . "' AND ID NOT IN (SELECT object_id as post_id FROM `{$wpdb->prefix}term_relationships` WHERE term_taxonomy_id IN (SELECT term_taxonomy_id FROM `{$wpdb->prefix}term_taxonomy` where taxonomy='bpdw_is_wiki')))" );

	if ( 0 < $numdocsposts ) {
		$numdocsposts = number_format( $numdocsposts );
	}

	$name = get_option( 'bp-docs-user-tab-name' );
	if ( empty( $name ) ) {
		$name = __( 'Docs', 'boss' );
	}

	$bp->members->nav->edit_nav( array( 'name' => $name . ' <span class="count">' . $numdocsposts . '</span>' ), bp_docs_get_docs_slug() );

	if ( bp_is_group() ) {
		$get_term_id = get_term_by( 'slug', 'bp_docs_associated_group_' . bp_get_current_group_id(), 'bp_docs_associated_item' );
		if ( $get_term_id ) {
			$get_term_id = $get_term_id->term_id;

			$numdocsposts = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'publish' AND post_type = 'bp_doc' AND ID IN (SELECT object_id FROM {$wpdb->prefix}term_relationships WHERE term_taxonomy_id='{$get_term_id}') AND ID NOT IN (SELECT object_id as post_id FROM `{$wpdb->prefix}term_relationships` WHERE term_taxonomy_id IN (SELECT term_taxonomy_id FROM `{$wpdb->prefix}term_taxonomy` where taxonomy='bpdw_is_wiki')))" );

			if ( 0 < $numdocsposts ) {
				$numdocsposts = number_format( $numdocsposts );
			}

			$bp->groups->nav->edit_nav( array( 'name' => $name . ' <span class="count">' . $numdocsposts . '</span>' ), bp_docs_get_docs_slug(), bp_current_item() );
		}
	}
}

if ( function_exists( 'bp_is_active' ) && (buddyboss_is_plugin_active( 'buddypress-docs/loader.php' )) ) {
	add_action( 'template_redirect', 'bb_child_doc_menu_count_tabs', 999 );
}

if ( buddyboss_is_plugin_active( 'buddypress-docs/loader.php' ) ) {
	add_action( 'template_redirect', 'bb_child_doc_menu_count_tabs', 999 );
}

// THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
function bb_child_custom_admin_styles() {
	echo '<style type="text/css">
			.ia-tabs.ia-tabs {padding-top: 0; }
			.ia-tabs.ia-tabs li {margin: 10px 7px; border-bottom: 1px solid #f9f9f9; border-radius: 5px;}
			.ia-tabs.ia-tabs li.current {border-color: #666;}
			.ia-tabs.ia-tabs li a {text-decoration: none;}

			@media screen and (max-width: 1024px) {
			   div.cs.cs p { padding-right: 0; }
			}

			@media screen and (max-width: 640px) {
			   div.cs-explain.cs-explain { clear:both; padding-left: 0; }
			}
         </style>';
}

add_action( 'admin_head', 'bb_child_custom_admin_styles' );

/*
 *  Set of functions for:
 *  BuddyPress Documents - Group document template
 *  Description: Sets group documents to display inside the group, rather than in its own template file.
 */

define( 'BBOSS_BPDOC_GDS_PATH', get_stylesheet_directory() );

//add_filter( 'bp_docs_get_doc_link', 'bboss_bp_doc_group_doc_permalink', 11, 2 );
function bboss_bp_doc_group_doc_permalink( $permalink, $doc_id ) {
	// BP 1.2/1.3 compatibility
	$is_group_component = function_exists( 'bp_is_current_component' ) ? bp_is_current_component( 'groups' ) : $bp->current_component == $bp->groups->slug;

	if ( $is_group_component ) {
		$permalink = trailingslashit( bp_get_group_permalink() ) . bp_docs_get_docs_slug() . '/?doc_id=' . $doc_id;
		//$permalink = bp_docs_get_group_doc_permalink( $doc_id );
	}
	return $permalink;
}

//add_filter( 'bp_docs_get_current_view', 'bboss_bp_doc_group_doc_set_view', 11, 2 );
function bboss_bp_doc_group_doc_set_view( $view, $item_type ) {
	if ( $item_type = 'group' && isset( $_GET[ 'doc_id' ] ) && $_GET[ 'doc_id' ] != '' ) {

		global $bboss_single_group_doc_view;
		$bboss_single_group_doc_view = 'bp_doc_group_doc_single';

		return 'list';
	}
	return $view;
}

//add_filter( 'bp_docs_locate_template', 'bboss_bp_doc_group_doc_single_template', 11, 2 );
function bboss_bp_doc_group_doc_single_template( $template_path, $template ) {
	remove_filter( 'bp_docs_locate_template', 'bboss_bp_doc_group_doc_single_template', 11, 2 );
	global $bp, $bboss_single_group_doc_view;

	if ( $bp->bp_docs->current_view == 'list' && $bboss_single_group_doc_view == 'bp_doc_group_doc_single' ) {

		add_filter( 'bp_docs_is_existing_doc', '__return_true', 11 );

		return BBOSS_BPDOC_GDS_PATH . 'bpdocs_gds/single/index.php';
	}
	return $template_path;
}

//add_filter( 'bp_docs_doc_action_links', 'bboss_bp_doc_group_doc_action_links', 11, 2 );
function bboss_bp_doc_group_doc_action_links( $links, $doc_id ) {
	// BP 1.2/1.3 compatibility
	$is_group_component = function_exists( 'bp_is_current_component' ) ? bp_is_current_component( 'groups' ) : $bp->current_component == $bp->groups->slug;

	if ( $is_group_component ) {
		$permalink	 = trailingslashit( bp_get_group_permalink() ) . bp_docs_get_docs_slug() . '/?doc_id=' . $doc_id;
		$links[ 0 ]	 = '<a href="' . $permalink . '">' . __( 'Read', 'buddypress-docs' ) . '</a>';
	}
	return $links;
}

function bboss_bp_doc_group_doc_comment_template_path( $path ) {
	return BBOSS_BPDOC_GDS_PATH . 'bpdocs_gds/single/comments.php';
}

//add_action( 'template_redirect', 'bboss_bp_doc_redirect_to_group' );
function bboss_bp_doc_redirect_to_group() {
	if ( !is_singular( 'bp_doc' ) )
		return;

	if ( bp_docs_is_doc_edit() || bp_docs_is_doc_history() )
		return;

	if ( function_exists( 'bp_is_active' ) && bp_is_active( 'groups' ) ) {
		$doc_group_ids	 = bp_docs_get_associated_group_id( get_the_ID(), false, true );
		$doc_groups		 = array();
		foreach ( $doc_group_ids as $dgid ) {
			$maybe_group = groups_get_group( 'group_id=' . $dgid );

			// Don't show hidden groups if the
			// current user is not a member
			if ( isset( $maybe_group->status ) && 'hidden' === $maybe_group->status ) {
				// @todo this is slow
				if ( !current_user_can( 'bp_moderate' ) && !groups_is_user_member( bp_loggedin_user_id(), $dgid ) ) {
					continue;
				}
			}

			if ( !empty( $maybe_group->name ) ) {
				$doc_groups[] = $maybe_group;
			}
		}

		if ( !empty( $doc_groups ) && count( $doc_groups ) == 1 ) {
			//the doc is asssociated with one group
			//redirect
			$group_link	 = bp_get_group_permalink( $doc_groups[ 0 ] );
			$permalink	 = trailingslashit( $group_link ) . bp_docs_get_docs_slug() . '/?doc_id=' . get_the_ID();

			wp_redirect( $permalink );
			exit();
		}
	}
}

function bp_doc_single_group_id( $return_dummy = true ) {
	$group_id = false;
	if ( function_exists( 'bp_is_active' ) && bp_is_active( 'groups' ) ) {
		if ( bp_docs_is_doc_create() ) {
			$group_slug = isset( $_GET[ 'group' ] ) ? $_GET[ 'group' ] : '';
			if ( $group_slug ) {
				global $bp, $wpdb;
				$group_id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$bp->groups->table_name} WHERE slug=%s", $group_slug ) );
			}
			if ( !$group_id ) {
				if ( $return_dummy )
					$group_id = 99999999;
			}
			return $group_id;
		}

		$doc_group_ids	 = bp_docs_get_associated_group_id( get_the_ID(), false, true );
		$doc_groups		 = array();
		foreach ( $doc_group_ids as $dgid ) {
			$maybe_group = groups_get_group( 'group_id=' . $dgid );

			// Don't show hidden groups if the
			// current user is not a member
			if ( isset( $maybe_group->status ) && 'hidden' === $maybe_group->status ) {
				// @todo this is slow
				if ( !current_user_can( 'bp_moderate' ) && !groups_is_user_member( bp_loggedin_user_id(), $dgid ) ) {
					continue;
				}
			}

			if ( !empty( $maybe_group->name ) ) {
				$doc_groups[] = $dgid;
			}
		}

		if ( !empty( $doc_groups ) && count( $doc_groups ) == 1 ) {
			$group_id = $doc_groups[ 0 ];
		}
	}

	if ( !$group_id ) {
		if ( $return_dummy )
			$group_id = 99999999;
	}
	return $group_id;
}

add_action( 'bp_group_options_nav', 'bboss_bpd_sg_save_group_navs_info' );

/**
 * Apparantely, there is no direct way of determining what all nav items will be displayed on a group page.
 *
 * So we'll hook into this action and save the nav items in db for later use.
 *
 * @since 0.0.1
 */
function bboss_bpd_sg_save_group_navs_info() {
	$bp = buddypress();

	if ( !bp_is_single_item() )
		return;
	/**
	 * get all nav items for a single group
	 */
	$group_navs		 = array();
	$bp_options_nav	 = buddyboss_bp_options_nav( bp_current_component(), bp_current_item() );
	if ( empty( $bp_options_nav ) ) {
		return false;
	} else {
		$the_index = bp_current_item();
	}

	// Loop through each navigation item
	foreach ( (array) $bp_options_nav as $subnav_item ) {

		if ( empty( $subnav_item[ 'slug' ] ) )
			continue;

		$item = array(
			'name'		 => $subnav_item[ 'name' ],
			'position'	 => $subnav_item[ 'position' ],
		);

		$group_navs[ $subnav_item[ 'slug' ] ] = $item;
	}

	update_option( 'bboss_bpd_sg_group_navs_info', $group_navs );
}

/**
 *
 */
function bboss_bpd_sg_get_create_link( $link ) {

	if ( !bp_is_active( 'groups' ) )
		return $link;

	$slug = bp_get_group_slug();
	if ( $slug && current_user_can( 'bp_docs_associate_with_group', bp_get_group_id() ) ) {
		$link = add_query_arg( 'group', $slug, $link );
	}

	return $link;
}

/**
 * Manage logo height for top bar
 */
if ( !function_exists( 'boss_logo_height' ) ) {

	function boss_logo_height( $size ) {
		$h = 74;

		if ( $size == 'big' ) {
			$site_logo_id			 = boss_get_option( 'boss_logo', 'id' );
			$site_logo_img			 = wp_get_attachment_image_src( $site_logo_id, 'full' );
			$boss_fixed_logo_width	 = 187;
			$boss_site_logo_width	 = $site_logo_img[ 1 ];
			$boss_site_logo_height	 = $site_logo_img[ 2 ];
		} else {
			$site_logo_id			 = boss_get_option( 'boss_small_logo', 'id' );
			$logo_img				 = wp_get_attachment_image_src( $site_logo_id, 'full' );
			$boss_fixed_logo_width	 = 45;
			$boss_site_logo_width	 = $logo_img[ 1 ];
			$boss_site_logo_height	 = $logo_img[ 2 ];
		}

		if ( $site_logo_id && ( $boss_site_logo_width > $boss_fixed_logo_width ) ) {
			$ratio	 = $boss_site_logo_height / $boss_site_logo_width;
			$h		 = ceil( $ratio * $boss_fixed_logo_width ) + 10; // 10 is padding-top + padding-bottom given to #mastlogo
		}

		return ( $h > 74 ) ? $h : 74;
	}

}

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own buddyboss_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Boss 1.0.0
 */
if ( !function_exists( 'buddyboss_comment' ) ) {

	function buddyboss_comment( $comment, $args, $depth ) {
		$GLOBALS[ 'comment' ] = $comment;
		switch ( $comment->comment_type ) {
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments.
				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p><?php _e( 'Pingback:', 'boss' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'boss' ), '<span class="edit-link">', '</span>' ); ?></p>
					<?php
					break;
				default :
					// Proceed with normal comments.
					global $post;
					?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">

						<div class="table-cell avatar-col">
							<?php echo get_avatar( $comment, 60 ); ?>
						</div><!-- .comment-left-col -->

						<div class="table-cell">
							<header class="comment-meta comment-author vcard">
								<?php
								printf( '<cite class="fn">%1$s %2$s</cite>', get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
				( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'boss' ) . '</span>' : ''
								);
								?>
							</header><!-- .comment-meta -->

							<?php if ( '0' == $comment->comment_approved ) : ?>
								<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'boss' ); ?></p>
							<?php endif; ?>

							<section class="comment-content comment">
								<?php comment_text(); ?>
							</section><!-- .comment-content -->

							<footer class="comment-meta">
								<?php
								printf( __( '<a href="%1$s"><time datetime="%2$s">%3$s ago</time></a>', 'boss' ), esc_url( get_comment_link( $comment->comment_ID ) ), get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */ human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) )
								);
								?>
								<span class="entry-actions">
									<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<i class="fa fa-reply"></i>', 'boss' ), 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ) ); ?>
								</span><!-- .entry-actions -->
								<?php edit_comment_link( __( 'Edit', 'boss' ), '<span class="edit-link">', '</span>' ); ?>
							</footer>
						</div>
					</article><!-- #comment-## -->
					<?php
					break;
			}
		}

	}

	function boss_get_docs_group_id() {
		// First, try to set the preselected group by looking at the URL params
		$selected_group_slug = isset( $_GET[ 'group' ] ) ? $_GET[ 'group' ] : '';

		// See if we're associated with a group
		if ( !function_exists( 'bp_is_active' ) || !bp_is_active( 'groups' ) ) {
			return 0;
		}

		// Support for BP Group Hierarchy
		if ( false !== $slash = strrpos( $selected_group_slug, '/' ) ) {
			$selected_group_slug = substr( $selected_group_slug, $slash + 1 );
		}

		$selected_group = BP_Groups_Group::get_id_from_slug( $selected_group_slug );
		if ( $selected_group && !current_user_can( 'bp_docs_associate_with_group', $selected_group ) ) {
			$selected_group = 0;
		}

		// If the selected group is still 0, see if there's something in the db
		if ( !$selected_group && is_singular() ) {
			$selected_group = bp_docs_get_associated_group_id( get_the_ID() );
		}

		// Last check: if this is a second attempt at a newly created Doc,
		// there may be a previously submitted value
		if ( empty( $selected_group ) && !empty( buddypress()->bp_docs->submitted_data->associated_group_id ) ) {
			$selected_group = intval( buddypress()->bp_docs->submitted_data->associated_group_id );
		}

		return intval( $selected_group );
	}

	if ( !function_exists( 'boss_pmpro_getLevelCost' ) ):

		/**
		 * Get nicer price formatting for Membership PRO tables
		 * @since Boss 2.0.2
		 */
		function boss_pmpro_getLevelCost( &$level, $tags = true, $short = false ) {
			//initial payment
			if ( !$short )
				$r	 = sprintf( __( 'The price for membership is <strong>%s</strong> now', 'boss' ), pmpro_formatPrice( $level->initial_payment ) );
			else
				$r	 = sprintf( __( '<strong><span>%s</span> now</strong>', 'boss' ), pmpro_formatPrice( $level->initial_payment ) );

			//recurring part
			if ( $level->billing_amount != '0.00' ) {
				if ( $level->billing_limit > 1 ) {
					if ( $level->cycle_number == '1' ) {
						$r .= sprintf( __( ' and then <strong>%s per %s for %d more %s</strong>.', 'boss' ), pmpro_formatPrice( $level->billing_amount ), pmpro_translate_billing_period( $level->cycle_period ), $level->billing_limit, pmpro_translate_billing_period( $level->cycle_period, $level->billing_limit ) );
					} else {
						$r .= sprintf( __( ' and then <strong>%s every %d %s for %d more %s</strong>.', 'boss' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ), $level->billing_limit, pmpro_translate_billing_period( $level->cycle_period, $level->billing_limit ) );
					}
				} elseif ( $level->billing_limit == 1 ) {
					$r .= sprintf( __( ' and then <strong>%s after %d %s</strong>.', 'boss' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
				} else {
					if ( $level->billing_amount === $level->initial_payment ) {
						if ( $level->cycle_number == '1' ) {
							if ( !$short )
								$r	 = sprintf( __( 'The price for membership is <strong>%s per %s</strong>.', 'boss' ), pmpro_formatPrice( $level->initial_payment ), pmpro_translate_billing_period( $level->cycle_period ) );
							else
								$r	 = sprintf( __( '<strong><span>%s</span> per %s</strong>.', 'boss' ), pmpro_formatPrice( $level->initial_payment ), pmpro_translate_billing_period( $level->cycle_period ) );
						}
						else {
							if ( !$short )
								$r	 = sprintf( __( 'The price for membership is <strong>%s every %d %s</strong>.', 'boss' ), pmpro_formatPrice( $level->initial_payment ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
							else
								$r	 = sprintf( __( '<strong><span>%s</span> every %d %s</strong>.', 'boss' ), pmpro_formatPrice( $level->initial_payment ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
						}
					} else {
						if ( $level->cycle_number == '1' ) {
							$r .= sprintf( __( ' and then <strong>%s per %s</strong>.', 'boss' ), pmpro_formatPrice( $level->billing_amount ), pmpro_translate_billing_period( $level->cycle_period ) );
						} else {
							$r .= sprintf( __( ' and then <strong>%s every %d %s</strong>.', 'boss' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
						}
					}
				}
			} else
				$r .= '.';

			//add a space
			$r .= ' ';

			//trial part
			if ( $level->trial_limit ) {
				if ( $level->trial_amount == '0.00' ) {
					if ( $level->trial_limit == '1' ) {
						$r .= ' ' . __( 'After your initial payment, your first payment is Free.', 'boss' );
					} else {
						$r .= ' ' . sprintf( __( 'After your initial payment, your first %d payments are Free.', 'boss' ), $level->trial_limit );
					}
				} else {
					if ( $level->trial_limit == '1' ) {
						$r .= ' ' . sprintf( __( 'After your initial payment, your first payment will cost %s.', 'boss' ), pmpro_formatPrice( $level->trial_amount ) );
					} else {
						$r .= ' ' . sprintf( __( 'After your initial payment, your first %d payments will cost %s.', 'boss' ), $level->trial_limit, pmpro_formatPrice( $level->trial_amount ) );
					}
				}
			}

			//taxes part
			$tax_state	 = pmpro_getOption( "tax_state" );
			$tax_rate	 = pmpro_getOption( "tax_rate" );

			if ( $tax_state && $tax_rate && !pmpro_isLevelFree( $level ) ) {
				$r .= sprintf( __( 'Customers in %s will be charged %s%% tax.', 'boss' ), $tax_state, round( $tax_rate * 100, 2 ) );
			}

			if ( !$tags )
				$r = strip_tags( $r );

			$r = apply_filters( "pmpro_level_cost_text", $r, $level, $tags, $short ); //passing $tags and $short since v2.0
			return $r;
		}

	endif;

	/**
	 * Cart icon html
	 */
	function boss_cart_icon_html() {

		global $woocommerce;
		if ( $woocommerce ) {
			$cart_items = $woocommerce->cart->cart_contents_count;
			?>

			<div class="header-notifications cart">
				<a class="cart-notification notification-link" href="<?php echo wc_get_cart_url() ?>">
					<i class="fa fa-shopping-cart"></i>
					<?php if ( $cart_items ) { ?>
						<span><?php echo $cart_items; ?></span>
					<?php } ?>
				</a>
			</div>
			<?php
		}
	}

    /**
	 * Cart icon html for the mobile devices
	 */
	function boss_mobile_cart_icon_html() {

		global $woocommerce;
		if ( $woocommerce ) {
			$cart_items = $woocommerce->cart->cart_contents_count;
			?>
            <div id="cart-nav-wrap" class="btn-wrap">
                <a id="cart-nav" class="cart-notification sidebar-btn table-cell" href="<?php echo wc_get_cart_url() ?>">
					<i class="fa fa-shopping-cart"></i>
                    <?php if ( $cart_items ) { ?>
                        <span><?php echo $cart_items; ?></span>
                    <?php } ?>
                </a>
            </div>
			<?php
		}
	}

	if ( defined( 'EM_VERSION' ) && EM_VERSION ) {
		add_action( 'em_options_page_footer_formats', 'boss_events_setup' );

		/**
		 * Add settings page
		 */
		function boss_events_setup() {
			global $save_button, $events_placeholder_tip;
			?>
			<div  class="postbox " id="em-opt-boss-events-formats" >
				<div class="handlediv" title="<?php __( 'Click to toggle', 'boss' ); ?>"><br /></div><h3><span><?php _e( 'BuddyBoss Events', 'boss' ); ?> </span></h3>
				<div class="inside">
					<table class="form-table">
						<tr class="em-header"><td colspan="2">
								<h4><?php echo sprintf( __( '%s Page', 'boss' ), __( 'Events', 'boss' ) ); ?></h4>
								<p><?php _e( 'These formats will be used on your events page. They will override settings previously set on "Events" dropdown of this page. This will also be used if you do not provide specified formats in other event lists, like in shortcodes.', 'boss' ); ?></p>
							</td></tr>
						<?php
						em_options_radio_binary( __( 'Use BuddyBoss list layout?', 'boss' ), 'dbem_bb_event_list_layout', __( "Use BuddyBoss grid layout.", 'boss' ) );
						em_options_textarea( __( 'Default event list format header', 'boss' ), 'dbem_bb_event_list_item_format_header', __( 'This content will appear just above your code for the default event list format. Default is blank', 'boss' ) );
						em_options_textarea( __( 'Default event list format', 'boss' ), 'dbem_bb_event_list_item_format', __( 'The format of any events in a list.', 'boss' ) . $events_placeholder_tip );
						em_options_textarea( __( 'Default event list format footer', 'boss' ), 'dbem_bb_event_list_item_format_footer', __( 'This content will appear just below your code for the default event list format. Default is blank', 'boss' ) );
						em_options_textarea( __( 'Default event grid format header', 'boss' ), 'dbem_bb_event_grid_item_format_header', __( 'This content will appear just above your code for the default event grid format. Default is blank', 'boss' ) );
						em_options_textarea( __( 'Default event grid format', 'boss' ), 'dbem_bb_event_grid_item_format', __( 'The format of any events in a list.', 'boss' ) . $events_placeholder_tip );
						em_options_textarea( __( 'Default event grid format footer', 'boss' ), 'dbem_bb_event_grid_item_format_footer', __( 'This content will appear just below your code for the default event grid format. Default is blank', 'boss' ) );
						?>
						<tr class="em-header">
							<td colspan="2">
								<h4><?php echo sprintf( __( 'Single %s Page', 'boss' ), __( 'Event', 'boss' ) ); ?></h4>
								<em><?php echo sprintf( __( 'These formats can be used on %s pages or on other areas of your site displaying an %s.', 'boss' ), __( 'event', 'boss' ), __( 'event', 'boss' ) ); ?></em>
						</tr>
						<?php
//                em_options_textarea ( sprintf(__('Single %s page header format', 'boss' ),__('event','boss')), 'dbem_bb_single_event_header_format', sprintf(__( 'Choose how to format your event headings.', 'boss' ),__('event','boss')).$events_placeholder_tip );
						em_options_radio_binary( __( 'Use BuddyBoss single event layout?', 'boss' ), 'dbem_bb_single_event', __( "Use BuddyBoss single event layout.", 'boss' ) );
						em_options_textarea( sprintf( __( 'Single %s page format', 'boss' ), __( 'event', 'boss' ) ), 'dbem_bb_single_event_format', sprintf( __( 'The format used to display %s content on single pages or elsewhere on your site.', 'boss' ), __( 'event', 'boss' ) ) . $events_placeholder_tip );

						echo $save_button;
						?>
					</table>
				</div> <!-- . inside -->
			</div> <!-- .postbox -->
			<?php
		}

		add_filter( 'em_ml_translatable_options', 'boss_add_translatable_options', 10, 1 );

		/**
		 * Add options to translatable array
		 * @param array $array Options array
		 */
		function boss_add_translatable_options( $array ) {
			array_push( $array, 'dbem_bb_event_list_layout', 'dbem_bb_event_list_item_format_header', 'dbem_bb_event_list_item_format', 'dbem_bb_event_list_item_format_footer', 'dbem_bb_event_grid_layout', 'dbem_bb_event_grid_item_format_header', 'dbem_bb_event_grid_item_format', 'dbem_bb_event_grid_item_format_footer', 'dbem_bb_single_event', 'dbem_bb_single_event_format' );
			return $array;
		}

		add_filter( 'em_content_events_args', 'boss_events_page_arguments', 10, 1 );

		/**
		 * Events page agruments
		 * @param  array $args Arguments array
		 * @return array Arguments array
		 */
		function boss_events_page_arguments( $args ) {
			$layout = 'list';
			if ( !isset( $_COOKIE[ 'events_layout' ] ) ) {
				if ( get_option( 'dbem_bb_event_list_layout' ) ) {
					$layout = 'list';
				}
				if ( get_option( 'dbem_bb_event_grid_layout' ) ) {
					$layout = 'grid';
				}
			} else {
				$layout = $_COOKIE[ 'events_layout' ];
			}

			$args[ 'format_header' ] = get_option( 'dbem_bb_event_' . $layout . '_item_format_header' );
			$args[ 'format' ]		 = get_option( 'dbem_bb_event_' . $layout . '_item_format' );
			$args[ 'format_footer' ] = get_option( 'dbem_bb_event_' . $layout . '_item_format_footer' );

			return $args;
		}

		if ( get_option( 'dbem_bb_single_event' ) ) {

			add_filter( 'em_event_output_single', 'boss_single_event', 10, 3 );

			/**
			 * Use Boss Setting on Single Event page
			 */
			function boss_single_event( $output, $object, $target ) {
				$format = get_option( 'dbem_bb_single_event_format' );
				return $object->output( $format, $target );
			}

		}

//    add_action('em_options_page_footer_formats', 'boss_events_default_options');
		/**
		 * Prepate things on theme switch
		 */
		function boss_events_default_options() {

			if ( !get_option( 'dbem_bb_event_default_options' ) ) {

				$bb_event_options = array(
					'dbem_full_calendar_event_format'		 => '<li style="background-color: #_CATEGORYCOLOR">#_EVENTLINK</li>',
					'dbem_bb_event_list_layout'				 => 1,
					'dbem_bb_event_default_options'			 => 1,
					'dbem_bb_event_list_item_format_header'	 => '<table cellpadding="0" cellspacing="0" class="events-table" >
            <thead>
                <tr>
                    <th class="event-time" width="150">' . __( 'Date/Time', 'boss' ) . '</th>
                    <th class="event-description" width="*">' . __( 'Event', 'boss' ) . '</th>
                    <th class="event-location" width="*">' . __( 'Location', 'boss' ) . '</th>
                </tr>
            </thead>
            <tbody>',
					'dbem_bb_event_list_item_format'		 => '<tr>
                <td class="event-time">
                    <i class="fas fa-calendar-alt"></i>#_EVENTDATES<br/>
                    <i class="far fa-clock"></i>#_EVENTTIMES
                </td>
                <td class="event-description">
                    <span class="event-image">
                    #_EVENTIMAGE{100,100}
                    </span>
                    <span class="event-details">
                    #_EVENTLINK
                    {has_location}<br/><span>#_LOCATIONNAME</span>{/has_location}
                    </span>
                </td>
                <td class="event-location">
                    {has_location}<i class="fa fa-globe"></i><span>#_LOCATIONTOWN #_LOCATIONSTATE</span>{/has_location}
                </td>
            </tr>',
					'dbem_bb_event_list_item_format_footer'	 => '</tbody></table>',
					'dbem_bb_event_grid_layout'				 => 0,
					'dbem_bb_event_grid_item_format_header'	 => '<div class="events-grid">',
					'dbem_bb_event_grid_item_format'		 => '<div class="event-item">
                <a href="#_EVENTURL" class="event-image">
                #_EVENTIMAGECROP{events_thumbnail}
                </a>
                #_EVENTLINK
                <div class="event-details">
                {has_location}<span>#_LOCATIONNAME, #_LOCATIONTOWN #_LOCATIONSTATE</span>{/has_location}
                </div>
                <div class="event-time">
                #_EVENTDATES<span> / </span>#_EVENTTIMES
                </div>
            </div>',
					'dbem_bb_event_grid_item_format_footer'	 => '</div>',
					'dbem_bb_single_event_format'			 => '<div class="event-image">#_EVENTIMAGE{1400,332}</div>
             #_EVENTNOTES
            <div class="event-details">
            <div style="float:right; margin:0px 0px 0 15px;">#_LOCATIONMAP</div>
            <p>
                <strong>' . __( 'Date/Time', 'boss' ) . '</strong>
               #_EVENTDATES @ <i>#_EVENTTIMES</i>
            </p>
            {has_location}
            <p>
                <strong>' . __( 'Location', 'boss' ) . '</strong>
                #_LOCATIONLINK
            </p>
            {/has_location}
            <p>
                <strong>' . __( 'Categories', 'boss' ) . '</strong>
                #_CATEGORIES
            </p>
			</div>
             {has_bookings}
            <h3>' . __( 'Bookings', 'boss' ) . '</h3>
            #_BOOKINGFORM
            {/has_bookings}',
					'dbem_image_min_width'					 => 200,
					'dbem_image_min_height'					 => 200
//            'dbem_bb_single_event_header_format' => '<h1 class="entry-title">#s</h1><div class="subtitle">#_EVENTDATES @ #_EVENTTIMES</div>'
				);

				//add new options
				foreach ( $bb_event_options as $key => $value ) {
					update_option( $key, $value );
				}

				$events_page_id	 = get_option( 'dbem_events_page' );
				$events_page	 = array(
					'ID'			 => $events_page_id,
					'page_template'	 => 'page-events.php'
				);
				wp_update_post( $events_page );
			}
		}

		/**
		 * Since straight call to boss_events_default_options giving a php warning, boss_events_default_options call is moved on init with priority 11
		 */
		add_action( 'init', 'boss_events_default_options', 11 );


		add_filter( 'body_class', 'boss_events_page_class' );

		/**
		 * Evants Page body class
		 * @param  array $classes Body classes
		 * @return array Body classes
		 */
		function boss_events_page_class( $classes ) {
			global $post;
			$events_page_id = get_option( 'dbem_events_page' );

			if ( isset( $post->ID ) && $post->ID == $events_page_id ) {
				$classes[] = 'events-page';
			}

			if ( isset( $post->ID ) && $post->ID == $events_page_id && get_option( 'dbem_display_calendar_in_events_page' ) ) {
				$classes[] = 'fullcalendar-page';
			}
			return array_unique( $classes );
		}

		add_action( 'widgets_init', 'boss_events_widgets' );

		/**
		 * Events Sidebar
		 */
		function boss_events_widgets() {
			register_sidebar( array(
				'name'			 => 'Events Sidebar',
				'id'			 => 'events',
				'description'	 => 'Only display on events pages',
				'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'	 => '</aside>',
				'before_title'	 => '<h4 class="widgettitle">',
				'after_title'	 => '</h4>',
			) );
		}

	}

// Add thumbnail size just events
	add_image_size( 'events_thumbnail', 200, 200, true );

	/**
	 * Crop Event Image by string name
	 *
	 */
	if ( !function_exists( 'boss_hard_crop_event_image' ) ):

		add_filter( 'em_event_output', 'boss_hard_crop_event_image', 10, 4 );

		function boss_hard_crop_event_image( $event_string, $post, $format, $target ) {
			preg_match_all( "/(#@?_?[A-Za-z0-9]+)({([^}]+)})?/", $event_string, $placeholders );
			$replaces = array();

			foreach ( $placeholders[ 1 ] as $key => $result ) {
				$match		 = true;
				$replace	 = '';
				$full_result = $placeholders[ 0 ][ $key ];
				if ( '#_EVENTIMAGECROP' == $result ) {
					$image_size		 = $placeholders[ 3 ][ $key ];
					$replace		 = get_the_post_thumbnail( $post->ID, $image_size );
					$event_string	 = preg_replace( "/" . $result . "({([^}]+)})?/", $replace, $event_string );
				}
			}
			return $event_string;
		}

	endif;


	if ( !function_exists( 'boss_profile_achievements' ) ):

		/**
		 * Output badges on profile
		 *
		 */
		function boss_profile_achievements() {
			global $user_ID;

			//user must be logged in to view earned badges and points

			if ( is_user_logged_in() && function_exists( 'badgeos_get_user_achievements' ) ) {

				$achievements = badgeos_get_user_achievements( array( 'user_id' => bp_displayed_user_id(), 'display' => true ) );

				if ( is_array( $achievements ) && !empty( $achievements ) ) {

					$number_to_show	 = 5;
					$thecount		 = 0;

					wp_enqueue_script( 'badgeos-achievements' );
					wp_enqueue_style( 'badgeos-widget' );

					//load widget setting for achievement types to display
					$set_achievements = ( isset( $instance[ 'set_achievements' ] ) ) ? $instance[ 'set_achievements' ] : '';

					//show most recently earned achievement first
					$achievements = array_reverse( $achievements );

					echo '<ul class="profile-achievements-listing">';

					foreach ( $achievements as $achievement ) {

						//verify achievement type is set to display in the widget settings
						//if $set_achievements is not an array it means nothing is set so show all achievements
						if ( !is_array( $set_achievements ) || in_array( $achievement->post_type, $set_achievements ) ) {

							//exclude step CPT entries from displaying in the widget
							if ( get_post_type( $achievement->ID ) != 'step' ) {

								$permalink	 = get_permalink( $achievement->ID );
								$title		 = get_the_title( $achievement->ID );
								$img		 = badgeos_get_achievement_post_thumbnail( $achievement->ID, array( 50, 50 ), 'wp-post-image' );
								$thumb		 = $img ? '<a style="margin-top: -25px;" class="badgeos-item-thumb" href="' . esc_url( $permalink ) . '">' . $img . '</a>' : '';
								$class		 = 'widget-badgeos-item-title';
								$item_class	 = $thumb ? ' has-thumb' : '';

								// Setup credly data if giveable
								$giveable	 = credly_is_achievement_giveable( $achievement->ID, $user_ID );
								$item_class	 .= $giveable ? ' share-credly addCredly' : '';
								$credly_ID	 = $giveable ? 'data-credlyid="' . absint( $achievement->ID ) . '"' : '';

								echo '<li id="widget-achievements-listing-item-' . absint( $achievement->ID ) . '" ' . $credly_ID . ' class="widget-achievements-listing-item' . esc_attr( $item_class ) . '">';
								echo $thumb;
								echo '<a class="widget-badgeos-item-title ' . esc_attr( $class ) . '" href="' . esc_url( $permalink ) . '">' . esc_html( $title ) . '</a>';
								echo '</li>';

								$thecount++;

								if ( $thecount == $number_to_show && $number_to_show != 0 && is_plugin_active('badgeos-community-add-on/badgeos-community.php') ) {
									echo '<li id="widget-achievements-listing-item-more" class="widget-achievements-listing-item">';
									echo '<a class="badgeos-item-thumb" href="' . bp_core_get_user_domain( bp_displayed_user_id() ) . '/achievements/"><i class="fa fa-ellipsis-h"></i></a>';
									echo '<a class="widget-badgeos-item-title ' . esc_attr( $class ) . '" href="' . bp_core_get_user_domain( bp_displayed_user_id() ) . '/achievements/">' . __( 'See All', 'social-learner' ) . '</a>';
									echo '</li>';
									break;
								}
							}
						}
					}

					echo '</ul><!-- widget-achievements-listing -->';
				}
			}
		}

	endif;

	/**
	 * Run custom slider shortcode
	 */
	if ( !function_exists( 'boss_execute_slider_shortcode' ) ):

		function boss_execute_slider_shortcode() {
			$slider_shortcode = boss_get_option( 'boss_plugins_slider' );
			if ( !empty( $slider_shortcode ) && !boss_get_option( 'boss_slider_switch' ) ) {
				echo do_shortcode( boss_get_option( 'boss_plugins_slider' ) );
			}
		}

	endif;

	add_action( 'boss_custom_slider', 'boss_execute_slider_shortcode' );

	/**
	 * Boss header nav > Dashboard
	 */
	function boss_header_dashboard_subnav_links() {
		?>
		<div class="ab-sub-wrapper">
			<ul class="ab-submenu">
				<li>

					<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
						<a href="<?php echo admin_url( 'admin.php?page=boss_options' ); ?>"><?php _e( 'Boss Options', 'boss' ); ?></a>
						<a href="<?php echo admin_url( 'customize.php' ); ?>"><?php _e( 'Customize', 'boss' ); ?></a>
						<a href="<?php echo admin_url( 'widgets.php' ); ?>"><?php _e( 'Widgets', 'boss' ); ?></a>
						<a href="<?php echo admin_url( 'nav-menus.php' ); ?>"><?php _e( 'Menus', 'boss' ); ?></a>
						<a href="<?php echo admin_url( 'themes.php' ); ?>"><?php _e( 'Themes', 'boss' ); ?></a>
					<?php endif; ?>

					<?php if ( current_user_can( 'activate_plugins' ) ): ?>
						<a href="<?php echo admin_url( 'plugins.php' ); ?>"><?php _e( 'Plugins', 'boss' ); ?></a>
					<?php endif; ?>

					<a href="<?php echo admin_url( 'profile.php' ); ?>"><?php _e( 'Profile', 'boss' ); ?></a>

				</li>
			</ul>
		</div>
		<?php
	}

	if ( !function_exists( 'buddyboss_bp_options_nav' ) ) {

		/**
		 * Support legacy buddypress nav items manipulation
		 */
		function buddyboss_bp_options_nav( $component_index = false, $current_item = false ) {
			$secondary_nav_items = false;

			$bp = buddypress();

			$version_compare = version_compare( BP_VERSION, '2.6', '<' );
			if ( $version_compare ) {
				/**
				 * @todo In future updates, remove the version compare check completely and get rid of legacy code
				 */
				//legacy code
				$secondary_nav_items = isset( $bp->bp_options_nav[ $component_index ] ) ? $bp->bp_options_nav[ $component_index ] : false;
			} else {
				//new navigation apis
				// Default to the Members nav.
				if ( !bp_is_single_item() ) {
					$secondary_nav_items = $bp->members->nav->get_secondary( array( 'parent_slug' => $component_index ) );
				} else {
					$component_index = $component_index ? $component_index : bp_current_component();
					$current_item	 = $current_item ? $current_item : bp_current_item();

					// If the nav is not defined by the parent component, look in the Members nav.
					if ( !isset( $bp->{$component_index}->nav ) ) {
						$secondary_nav_items = $bp->members->nav->get_secondary( array( 'parent_slug' => $current_item ) );
					} else {
						$secondary_nav_items = $bp->{$component_index}->nav->get_secondary( array( 'parent_slug' => $current_item ) );
					}
				}
			}

			return $secondary_nav_items;
		}

	}

	if ( ! function_exists( 'buddyboss_get_unread_messages_html' ) ) {
	    function buddyboss_get_unread_messages_html() {
	    	global $messages_template;

	        ob_start();

			// Parse the arguments.
			$r = array(
				'user_id'      => get_current_user_id(),
				'box'          => 'inbox',
				'per_page'     => 10,
				'max'          => false,
				'type'         => 'unread',
				'page_arg'     => 'mpage', // See https://buddypress.trac.wordpress.org/ticket/3679.
				'meta_query'   => array()
			);

			// Reserve original messages template
			$main_messages_template = $messages_template;

			// Load the messages loop global up with messages.
			$messages_template = new BP_Messages_Box_Template( $r );

			if ( $messages_template->has_threads() ) { ?>

            <ul class="bb-user-notifications">
                <?php while (bp_message_threads()) : bp_message_thread(); ?>

                    <li>

                        <?php bp_message_thread_avatar('height=20&width=20'); ?>

                        <?php bp_message_thread_from() ?>

                        <a class="bb-message-link" href="<?php esc_url(bp_message_thread_view_link()); ?>">
                            <?php _e('Sent you message', 'boss'); ?>
                        </a>

                    </li>

                <?php endwhile; ?>
            </ul>

            <?php } else { ?>
            <a href="#"><?php _e('No unread messages', 'boss'); ?></a>
	<?php }
			// Restore original messages template
			$messages_template = $main_messages_template;
	        return ob_get_clean();
        }
    }

/**
 * BuddyBoss Global Search Support
 */
add_action( 'wp', 'bb_search_result_page_body_class' );

function bb_search_result_page_body_class() {
	remove_filter( 'body_class', 'buddyboss_global_search_body_class', 10, 1 );
}

//  load single event template from theme or plugin
function bb_event_single_template( $single_template ) {
	global $post;

	if ( is_plugin_active( 'events-manager/events-manager.php' ) && $post->post_type == 'event' ) {
		$theme_template = locate_template( 'single-events-manager.php' );
		if( file_exists( $theme_template ) )
			$single_template = $theme_template;
    }

	return $single_template;
}
add_filter( 'single_template', 'bb_event_single_template', 16 );

// Disable styles and scripts

function wpschool_disable_scripts_styles() {
	add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
	add_action('elementor/frontend/after_register_styles',function() {
	  foreach( [ 'solid', 'regular', 'brands' ] as $style ) {
		wp_deregister_style( 'elementor-icons-fa-' . $style );
	  }
	}, 20 );
  
	if ( is_front_page() && !is_user_logged_in()) { 
  
  
  
  
	  wp_dequeue_script( 'frontjs');
	  wp_dequeue_script( 'jquery-choosen');
	  wp_dequeue_script( 'flexible_shipping_notices');
	  wp_dequeue_script( 'hierarchical-groups-for-bp-plugin-script');
   
	wp_dequeue_script( 'buy_sell_ads_pro_js_script');
	wp_dequeue_script( 'buy_sell_ads_pro_viewport_checker_js_script');
	wp_dequeue_script( 'buy_sell_ads_pro_chart_js_script');
	wp_dequeue_script( 'buy_sell_ads_pro_carousel_js_script');
	wp_dequeue_script( 'buy_sell_ads_pro_simply_scroll_js_script');
	// wp_dequeue_script( 'bp-confirm');
	// wp_dequeue_script( 'bp-legacy-js');
	// wp_dequeue_script( 'contact-form-7');
	// wp_dequeue_script( 'jquery-form');
	// wp_dequeue_script( 'wpdm-front-bootstrap');
	// wp_dequeue_script( 'elementor-frontend');
  
	// wp_dequeue_style( 'elementor-frontend-legacy' );
	// wp_dequeue_style( 'elementor-frontend' );  
  
	wp_dequeue_style( 'elementor-animations' );
	wp_dequeue_style( 'elementor-pro' );    
	wp_dequeue_style( 'wc-block-style' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'bp-groups-block' );
	wp_dequeue_style( 'bp-group-block' );
	wp_dequeue_style( 'bp-members-block' );
	wp_dequeue_style( 'bp-member-block' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'google-fonts-1' );
	wp_dequeue_style( 'woo-variation-swatches-tooltip' );
	wp_dequeue_style( 'woo-variation-swatches-theme-override' );
	wp_dequeue_style( 'woo-variation-swatches' );
	wp_dequeue_style( 'elementor-frontend' );
	wp_dequeue_style( 'mycred-front' );
	wp_dequeue_style( 'vikinger-swiper-slider-styles' );
	wp_dequeue_style( 'vikinger-simplebar-styles' );
	wp_dequeue_style( 'hierarchical-groups-for-bp-plugin-styles' );
	// wp_dequeue_style( 'flexible_shipping_notices' );
	// wp_dequeue_style( 'woocommerce-inline' );
	wp_dequeue_style( 'wpdm-front' );
	wp_dequeue_style( 'wpdm-front-bootstrap' );
	wp_dequeue_style( 'wpdm-font-awesome' );
	wp_dequeue_style( 'contact-form-7' );
	wp_dequeue_style( 'buy_sell_ads_pro_materialize_stylesheet' );
	wp_dequeue_style( 'buy_sell_ads_pro_carousel_stylesheet' );
	wp_dequeue_style( 'buy_sell_ads_pro_chart_stylesheet' );
	wp_dequeue_style( 'buy_sell_ads_pro_animate_stylesheet' );
	wp_dequeue_style( 'buy_sell_ads_pro_template_stylesheet' );
	wp_dequeue_style( 'buy_sell_ads_pro_user_panel' );
	wp_dequeue_style( 'buy_sell_ads_pro_main_stylesheet' );
	wp_deregister_style('google-fonts-1');
  
	};
  }
  add_action( 'wp_enqueue_scripts', 'wpschool_disable_scripts_styles', 9999 );
  add_action( 'wp_head', 'wpschool_disable_scripts_styles', 9999 );

  function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );



add_filter( 'woocommerce_states', 'awrr_states_uzbekistan' );

function awrr_states_uzbekistan( $states ) {

	$states['UZ'] = array(
		'01' => __("Ташкент"),
		'02' => __("Ташкентская область"),
		'03' => __("Каракалпакстан"),
		'04' => __("Бухарская область"),
		'05' => __("Андижанская область"),
		'06' => __("Хорезмская область"),
		'07' => __("Самаркандская область"),
		'08' => __("Кашкадарьинская область"),
		'09' => __("Джизакская область"),
		'10' => __("Новоийская область"),
		'11' => __("Сурхандарьинская область"),
		'12' => __("Наманганская область"),
    '13' => __("Сырдарьинская область"),
    '14' => __("Ферганская область"),
  );
  return $states;
}
/**
 * Register a custom post type called "Университет".
 *
 * @see get_post_type_labels() for label keys.
 */
function university_init()
{
    $labels = array(
        'name' => _x('Университеты', 'Post type general name', 'boss'),
        'singular_name' => _x('Университет', 'Post type singular name', 'boss'),
        'menu_name' => _x('Университеты', 'Admin Menu text', 'boss'),
        'name_admin_bar' => _x('Университет', 'Add New on Toolbar', 'boss'),
        'add_new' => __('Добавить новый', 'boss'),
        'add_new_item' => __('Добавить новый Университет', 'boss'),
        'new_item' => __('Новый Университет', 'boss'),
        'edit_item' => __('Редактировать Университет', 'boss'),
        'view_item' => __('Посмотреть Университет', 'boss'),
        'all_items' => __('Все Университеты', 'boss'),
        'search_items' => __('Найти Университеты', 'boss'),
        'parent_item_colon' => '',
        'not_found' => __('Университеты не найдены.', 'boss'),
        'not_found_in_trash' => __('Университеты в корзине не найдены.', 'boss'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
    );
    register_post_type('university', $args);
}
add_action('init', 'university_init');
// register taxnomy of Университет
add_action('init', 'create_taxonomy');
function create_taxonomy() { 

    // список параметров: wp-kama.ru/function/get_taxonomy_labels
    register_taxonomy('university_tax', ['university'], [
        'label' => '', // определяется параметром $labels->name
        'labels' => [
            'name' => 'Категории',
            'singular_name' => 'Категория',
            'menu_name' => 'Категория',
        ],
        'description' => '', // описание таксономии
        'public' => true,
        'hierarchical' => true,
        'rewrite' => true,'show_ui' => true,
        //'query_var'             => $taxonomy, // название параметра запроса
        'capabilities' => array(),
        'meta_box_cb' => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
        'show_admin_column' => true, 
        'show_in_rest' => null, // добавить в REST API
        'rest_base' => null, // $taxonomy
        // '_builtin'              => false,
        //'update_count_callback' => '_update_post_term_count',
    ]);
}
/**
 * Register a custom post type called "Courses".
 *
 * @see get_post_type_labels() for label keys.
 */
function course_init()
{
    $labels = array(
        'name' => _x('Учебные центры', 'Post type general name', 'boss'),
        'singular_name' => _x('Учебный центр', 'Post type singular name', 'boss'),
        'menu_name' => _x('Учебные центры', 'Admin Menu text', 'boss'),
        'name_admin_bar' => _x('Учебный центр', 'Add New on Toolbar', 'boss'),
        'add_new' => __('Добавить новый', 'boss'),
        'add_new_item' => __('Добавить новый Учебный центр', 'boss'),
        'new_item' => __('Новый Учебный центр', 'boss'),
        'edit_item' => __('Редактировать Учебный центр', 'boss'),
        'view_item' => __('Посмотреть Учебный центр', 'boss'),
        'all_items' => __('Все Учебные центры', 'boss'),
        'search_items' => __('Найты Учебные центры', 'boss'),
        // 'parent_item_colon'     => __( 'Parent Учебные центры:', 'boss' ),
        'not_found' => __('Учебный центр не найден.', 'boss'),
        'not_found_in_trash' => __('Учебный центр не найден в корзине.', 'boss'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        // 'rewrite'            => array( 'slug' => 'course' ),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => true,
        'menu_position' => null,
        'menu_icon' => 'dashicons-book-alt',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
    );
    register_post_type('course', $args);
}
add_action('init', 'course_init');

// register taxnomy of Courses
add_action('init', 'create_taxonomy_course');
function create_taxonomy_course()
{
    // список параметров: wp-kama.ru/function/get_taxonomy_labels
    register_taxonomy('course_tax', ['course'], [
        'label' => '', // определяется параметром $labels->name
        'labels' => [
            'name' => 'Категории',
            'singular_name' => 'Категория',
            'menu_name' => 'Категория',
        ],
        'description' => '', // описание таксономии
        'public' => true,
        'hierarchical' => true,
        'rewrite' => true,
        'show_ui' => true,
        //'query_var'             => $taxonomy, // название параметра запроса
        'capabilities' => array(),
        'meta_box_cb' => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
        'show_admin_column' => true, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
        'show_in_rest' => null, // добавить в REST API
        'rest_base' => null, // $taxonomy
        // '_builtin'              => false,
        //'update_count_callback' => '_update_post_term_count',
    ]);
}

/**
 * Register a custom post type called "Университет".
 *
 * @see get_post_type_labels() for label keys.
 */
function tutor_init()
{
    $labels = array(
        'name' => _x('Репетиторы', 'Post type general name', 'boss'),
        'singular_name' => _x('Репетитор', 'Post type singular name', 'boss'),
        'menu_name' => _x('Репетиторы', 'Admin Menu text', 'boss'),
        'name_admin_bar' => _x('Репетитор', 'Add New on Toolbar', 'boss'),
        'add_new' => __('Добавить новый', 'boss'),
        'add_new_item' => __('Добавить Репетитор', 'boss'),
        'new_item' => __('Новый Репетиторы', 'boss'),
        // 'edit_item'             => __( 'Edit Репетиторы', 'boss' ),
        // 'view_item'             => __( 'View Университет', 'boss' ),
        // 'all_items'             => __( 'All Университеты', 'boss' ),
        // 'search_items'          => __( 'Search Университеты', 'boss' ),
        // 'parent_item_colon'     => __( 'Parent Университеты:', 'boss' )
        // 'not_found'             => __( 'No Университеты found.', 'boss' ),
        // 'not_found_in_trash'    => __( 'No Университеты found in Trash.', 'boss' ),
        // 'featured_image'        => _x( 'Университет Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'boss' ),
        // 'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'boss' ),
        // 'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'boss' ),
        // 'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'boss' ),
        // 'archives'              => _x( 'Университет archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'boss' ),
        // 'insert_into_item'      => _x( 'Insert into Университет', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'boss' ),
        // 'uploaded_to_this_item' => _x( 'Uploaded to this Университет', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'boss' ),
        // 'filter_items_list'     => _x( 'Filter Университеты list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'boss' ),
        // 'items_list_navigation' => _x( 'Университет list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'boss' 
        // 'items_list'            => _x( 'Университет list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'boss' ),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
    );
    register_post_type('tutor', $args);
}
add_action('init', 'tutor_init');

// register taxnomy of Университет
add_action('init', 'create_taxonomy_tutor');
function create_taxonomy_tutor()
{
    // список параметров: wp-kama.ru/function/get_taxonomy_labels
    register_taxonomy('tutor_tax', ['tutor'], [
        'label' => '', // определяется параметром $labels->name
        'labels' => [
            'name' => 'Категории',
            'singular_name' => 'Категория',
            // 'search_items'      => 'Search Профессии',
            // 'all_items'         => 'All Профессии',
            // 'view_item '        => 'View Профессия',
            // 'parent_item'       => 'Parent Профессия',
            // 'parent_item_colon' => 'Parent Профессия:',
            // 'edit_item'         => 'Edit Профессия',
            // 'update_item'       => 'Update Профессия',
            // 'add_new_item'      => 'Add New Профессия',
            // 'new_item_name'     => 'New Профессия Name',
            'menu_name' => 'Категория',
        ],
        'description' => '', // описание таксономии
        'public' => true,
        'hierarchical' => true,
        'rewrite' => true,'show_ui' => true,
        //'query_var'             => $taxonomy, // название параметра запроса
        'capabilities' => array(),
        'meta_box_cb' => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
        'show_admin_column' => true, 
        'show_in_rest' => null, // добавить в REST API
        'rest_base' => null, // $taxonomy
        // '_builtin'              => false,
        //'update_count_callback' => '_update_post_term_count',
    ]);
}


function shop_register_wp_sidebars()
{
    /* В боковой колонке - первый сайдбар */
    register_sidebar(
        array(
            'id' => 'shop_ads', // уникальный id
            'name' => 'Shop Sidebar ads', // название сайдбара
            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
            'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
            'after_title' => '</h3>',
        )
    );

    register_sidebar(
        array(
            'id' => 'shop_banner_ads', // уникальный id
            'name' => 'Shop banner ads', // название сайдбара
            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
            'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
            'after_title' => '</h3>',
        )
    );
    register_sidebar(
        array(
            'id' => 'shop_category_ads', // уникальный id
            'name' => 'Category sidebar ads', // название сайдбара
            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
            'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
            'after_title' => '</h3>',
        )
    );
    register_sidebar(
        array(
            'id' => 'product_ads', // уникальный id
            'name' => 'Single product sidebar ads', // название сайдбара
            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
            'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
            'after_title' => '</h3>',
        )
    );
    register_sidebar(
        array(
            'id' => 'course_ads', // уникальный id
            'name' => 'Archive course sidebar ads', // название сайдбара
            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
            'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
            'after_title' => '</h3>',
        )
    );

    register_sidebar(
        array(
            'id' => 'university_ads', // уникальный id
            'name' => 'Archive university sidebar ads', // название сайдбара
            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
            'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
            'after_title' => '</h3>',
        )
    );
    register_sidebar(
        array(
            'id' => 'language', // уникальный id
            'name' => 'Language switcher', // название сайдбара
            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
            'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
            'after_title' => '</h3>',
        )
    );
}

add_action('widgets_init', 'shop_register_wp_sidebars');
//Отключить валидацию Contact Form7
add_filter( 'wpcf7_validate_configuration', '__return_false' );

add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);
 
function add_my_currency_symbol( $currency_symbol, $currency ) {
 
     switch( $currency ) {
 
         case 'UZS': $currency_symbol = pll__('sum', 'bokiy'); break;
 
     }
 
     return $currency_symbol;
 
}

add_action('init', function() {
    pll_register_string('bokiy', 'sum');
    pll_register_string('bokiy', 'Yetkazish');
	pll_register_string('bokiy', 'You saved');
	pll_register_string('bokiy', 'Education centers');
	pll_register_string('bokiy', 'Repetitors');
  });
	
function add_file_types_to_uploads($file_types) { 
	$new_filetypes = array(); 
	$new_filetypes['svg'] ='image/svg+xml'; 
	$file_types = array_merge($file_types, $new_filetypes ); 
	return $file_types; 
}
add_action('upload_mimes', 'add_file_types_to_uploads', 1, 1);



add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );

function jk_related_products_args ($args) {
$args['posts_per_page'] = 4 ;
return $args;
}



function partly_payment_new_order( $order_id ) {
  $order = wc_get_order( $order_id );
  $user_id = get_current_user_id();
  $new_order =  esc_html('New order', 'boss');  
  $totals = get_post_meta( $order_id, '_billing_vid', true ); 
  $datas = esc_html('Order', 'boss').' #'.$order->get_order_number();
  if($totals){
  mycred_subtract( $new_order, $user_id, -$totals, $datas );
  }
  
}
add_action( 'woocommerce_thankyou', 'partly_payment_new_order', 10);

add_filter( 'woocommerce_cart_shipping_method_full_label', 'remove_shipping_method_title', 10, 2 ); 
function remove_shipping_method_title( $label, $method ){ 

	$new_label = ''; 

	if ( $method->cost > 0 ) {
		if ( WC()->cart->get_tax_price_display_mode() == 'excl' ) {
			$new_label .= wc_price( $method->cost );
			if ( $method->get_shipping_tax() > 0 && WC()->cart->prices_include_tax ) {
				$new_label .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
			}
		} else {
			$new_label .= wc_price( $method->cost + $method->get_shipping_tax() );
			if ( $method->get_shipping_tax() > 0 && ! WC()->cart->prices_include_tax ) {
				$new_label .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
			}
		}
	}

	return $new_label; 
} // remove_shipping_method_title()

add_action( 'woocommerce_cart_totals_after_order_total', 'bbloomer_show_total_discount_cart_checkout', 9999 );
add_action( 'woocommerce_review_order_after_order_total', 'bbloomer_show_total_discount_cart_checkout', 9999 );
 
function bbloomer_show_total_discount_cart_checkout() {
    
   $discount_total = 0;
    
   foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {         
      $product = $values['data'];
      if ( $product->is_on_sale() ) {
         $regular_price = $product->get_regular_price();
         $sale_price = $product->get_sale_price();
         $discount = ( $regular_price - $sale_price ) * $values['quantity'];
         $discount_total += $discount;
      }
   }
             
    if ( $discount_total > 0 ) {
      echo '<li class="you_saved"><div>'.pll__('You saved').'</div><div data-title="'.pll__('You saved').'">' . wc_price( $discount_total + WC()->cart->get_discount_total() ) .'</div></li>';
    }
  
}

// Outputting the hidden field in checkout page
add_action( 'woocommerce_checkout_after_order_review', 'add_custom_checkout_hidden_field' );
function add_custom_checkout_hidden_field( $checkout ) {

  $discount_total = 0;
    
  foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {         
      $product = $values['data'];
      if ( $product->is_on_sale() ) {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        $discount = ( $regular_price - $sale_price ) * $values['quantity'];
        $discount_total += $discount;
      }
  }
               
  if ( $discount_total > 0 ) {
        $dis_total =  $discount_total;
    // Output the hidden field
    echo '<div id="user_link_hidden_checkout_field">
            <input type="hidden" class="input-hidden" name="billing_vid" id="billing_vid" value="'.$dis_total.'">
    </div>';
	}
}

// Saving the hidden field value in the order metadata
add_action( 'woocommerce_checkout_update_order_meta', 'save_custom_checkout_hidden_field' );
function save_custom_checkout_hidden_field( $order_id ) {
    if ( ! empty( $_POST['billing_vid'] ) ) {
        update_post_meta( $order_id, '_billing_vid', sanitize_text_field( $_POST['billing_vid'] ) );
    }
}

// Displaying "Verification ID" in customer order
add_action( 'woocommerce_order_details_after_customer_details', 'display_verification_id_in_customer_order', 10 );
function display_verification_id_in_customer_order( $order ) {
    // compatibility with WC +3
    $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;

    echo '<p class="verification-id"><strong>'.__('Bonus', 'boss') . ':</strong> ' . get_post_meta( $order_id, '_billing_vid', true ) .'</p>';
}

 // Display "Verification ID" on Admin order edit page
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_verification_id_in_admin_order_meta', 10, 1 );
function display_verification_id_in_admin_order_meta( $order ) {
    // compatibility with WC +3
    $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
    echo '<p><strong>'.__('Bonus', 'boss').':</strong> ' . get_post_meta( $order_id, '_billing_vid', true ) . '</p>';
}




// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_email']);
	unset($fields['billing']['billing_last_name']);
	unset($fields['billing']['billing_state']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_postcode']);
  	unset($fields['billing']['billing_city']);
	return $fields;
}

add_filter( 'woocommerce_billing_fields' , 'custom_override_woocommerce_billing_fields' );
// Our hooked in function - $address_fields is passed via the filter!
function custom_override_woocommerce_billing_fields( $address_fields ) {
	$address_fields['billing_email']['required'] = false;
	return $address_fields;
};

add_filter('woocommerce_checkout_fields', function($fields) {

	$fields['billing']['billing_first_name']['priority'] = 10;
	$fields['billing']['billing_phone']['priority'] = 12;

	return $fields;
});

add_filter('woocommerce_default_address_fields', function($address_fields) {	

  $address_fields['country']['priority'] = 14;
	return $address_fields;
});

add_filter('woocommerce_default_address_fields', function($address_fields) {
	$address_fields['country']['label'] = __('Country', 'boss');
	$address_fields['country']['class'] = ["form-row-first"];
	return $address_fields;
});

add_filter('woocommerce_checkout_fields', function($address_fields) {
	$address_fields['billing']['billing_phone']['class'] = ["form-row-first"];
	return $address_fields;
});

add_filter( 'woocommerce_checkout_fields', 'misha_no_phone_validation' );
 
function misha_no_phone_validation( $woo_checkout_fields_array ) {
	unset( $woo_checkout_fields_array['billing']['billing_phone']['validate'] );
	unset( $woo_checkout_fields_array['billing']['billing_address_1']['validate'] );
	return $woo_checkout_fields_array;
}



function shortcode_my_orders( $atts ) {
  extract( shortcode_atts( array(
      'order_count' => -1
  ), $atts ) );

  ob_start();
  wc_get_template( 'myaccount/my-orders.php', array(
      'current_user'  => get_user_by( 'id', get_current_user_id() ),
      'order_count'   => $order_count
  ) );
  return ob_get_clean();
}
add_shortcode('my_orders', 'shortcode_my_orders');

add_shortcode( 'profession_groups', 'profession_func' );

function profession_func($atts, $content){
  ob_start();

	/**
	 * Подключает файл по пути:
	 * мой_домен/wp-content/themes/моя_тема/templates/shortcodes/4_cards.php
	 */
  get_template_part( 'buddypress/groups/groups-loop-parent', $content );

	return ob_get_clean();
}

function number_child_group() {
	global $groups_template;
	/*
	 * Store the $groups_template global, so that the wrapper group
	 * can be restored after the has_groups() loop is completed.
	 */
	$parent_groups_template = $groups_template;

	/*
	 * For the most accurate results, only show the 'show child groups' toggle
	 * if groups would be shown by a bp_has_groups() loop. Keep the args simple
	 * to avoid unnecessary joins and hopefully hit the BP_Groups_Group::get()
	 * cache.
	 */
	$has_group_args = array(
		'parent_id'          => bp_get_group_id(),
		'orderby'            => 'date_created',
		'update_admin_cache' => false,
		'per_page'           => false,
	);
	if ( bp_has_groups( $has_group_args ) ) :
		global $groups_template;
		$number_children = $groups_template->total_group_count;

		// Put the parent $groups_template back.
    $groups_template = $parent_groups_template;
    echo $number_children;
		?>	
	<?php else :
		$groups_template = $parent_groups_template;
	endif;
}


add_shortcode( 'last_profession', 'profession_last' );

function profession_last($atts, $content){
  ob_start();

	/**
	 * Подключает файл по пути:
	 * мой_домен/wp-content/themes/моя_тема/templates/shortcodes/4_cards.php
	 */
	get_template_part( 'buddypress/groups/last_profession', $content );

	return ob_get_clean();
}

add_filter( 'mycred_ranking_row', 'my_custom_ranking_rows', 10, 4 );
function my_custom_ranking_rows( $layout, $template, $row, $position )
{
	$avatar = get_avatar( $row['ID'], 60 );
	return str_replace( '%avatar%', $avatar, $layout );
}

/*
 * Create a column. And maybe remove some of the default ones
 * @param array $columns Array of all user table columns {column ID} => {column Name} 
 */
add_filter( 'manage_users_columns', 'rudr_modify_user_table' );

function rudr_modify_user_table( $columns ) {
	
	// unset( $columns['posts'] ); // maybe you would like to remove default columns
	$columns['registration_date'] = 'Registration date'; // add new

	return $columns;

}

/*
 * Fill our new column with the registration dates of the users
 * @param string $row_output text/HTML output of a table cell
 * @param string $column_id_attr column ID
 * @param int $user user ID (in fact - table row ID)
 */
add_filter( 'manage_users_custom_column', 'rudr_modify_user_table_row', 10, 3 );

function rudr_modify_user_table_row( $row_output, $column_id_attr, $user ) {
	
	$date_format = 'd-m-y';

	switch ( $column_id_attr ) {
		case 'registration_date' :
			return date( $date_format, strtotime( get_the_author_meta( 'registered', $user ) ) );
			break;
		default:
	}

	return $row_output;

}

/*
 * Make our "Registration date" column sortable
 * @param array $columns Array of all user sortable columns {column ID} => {orderby GET-param} 
 */
add_filter( 'manage_users_sortable_columns', 'rudr_make_registered_column_sortable' );

function rudr_make_registered_column_sortable( $columns ) {
	return wp_parse_args( array( 'registration_date' => 'registered' ), $columns );
}

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function minbazar_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'minbazar_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function minbazar_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'minbazar_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'minbazar_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function minbazar_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'minbazar_woocommerce_wrapper_before' );

if ( ! function_exists( 'minbazar_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function minbazar_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'minbazar_woocommerce_wrapper_after' );


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


remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );



remove_action( 'woocommerce_before_main_content', 'minbazar_woocommerce_wrapper_before', 10);
remove_action( 'woocommerce_after_main_content', 'minbazar_woocommerce_wrapper_before', 10 );


// page wrapper
add_action( 'woocommerce_before_main_content', 'open_container_row_div_classes', 10 );
function open_container_row_div_classes() {
	echo '<div class="page-content header-clear-medium"><div class="container">';
}

add_action( 'woocommerce_after_main_content', 'end_container_row_div_classes', 10 );
function end_container_row_div_classes() {
		echo '</div></div>';
}




           

add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => ' › ',
            'wrap_before' => '<div class="breadcrumbs-holder"><nav class="breadcrumbs-ov"><ol class="breadcrumbs">',
            'wrap_after'  => '</ol></nav></div>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );
}


add_action( 'template_redirect', 'load_template_layout' );

function load_template_layout() {
    if(is_product_category()){
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    }
}


add_filter( 'woocommerce_show_page_title', 'toggle_page_title' );

function toggle_page_title($val) {
    $val = false;
    return $val;
}

// add_action( 'woocommerce_archive_description', 'minbazar_woocommerce_product_title', 10);

// function minbazar_woocommerce_product_title() {
//     if ( is_product_category() ) {
//         global $wp_query;
//         $cat = $wp_query->get_queried_object();
//         $title_array = explode(' ', $cat->name);
//         echo '<div><h1 class="h1-fat"> ';
//         foreach ($title_array as $key => $value) {
//             if( $key == 0 ) {
//                 echo ' ' . $value;
//             } else {
//                 echo ' <span>' . $value . '</span>';
//             }
            
//         }
//         echo '</h1></div>';
//     }
// }

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);


$parentid = get_queried_object_id();


    // Отделяем категории от товаров
    add_action( 'woocommerce_archive_description', 'tutsplus_product_categories', 10 );
    function tutsplus_product_categories( $args = array() ) {

  
        $args = array(
            'exlude' => 23
        );

        $terms = get_terms( 'product_cat');
        
            if ( $terms ) {

                echo '<section class="rax-view content-bottom test"><div class="rax-view item-feed"><div class="cat-slider mb-4 mt-4 owl-carousel">';

                foreach ( $terms as $term ) {

                    if ($term->slug != 'raznoe') {
                        $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
                        $image = wp_get_attachment_url( $thumbnail_id );
                        echo '<div class="sc-crXcEl cCNGhG">';
                        echo '<a href="' . esc_url( get_term_link( $term ) ) .'">';
                        echo '<img src="'. $image .'" alt="'.$term->name.'">';
                        echo '<span>'.$term->name.'</span>';
                        echo '</a>';
                        echo '</div>';
                    }
                
                }

                echo '</div></div></section>';

            }
    }


    // Отделяем Подкатегории от товаров
    add_action( 'woocommerce_archive_description', 'tutsplus_product_subcategories', 50 );
    function tutsplus_product_subcategories( $args = array() ) {

        $parentid = get_queried_object_id();

        $args = array(
        'parent' => $parentid,
           );

        $terms = get_terms( 'product_cat', $args );
        if ( !is_shop() ) {
            if ( $terms ) {

                echo '<section class="rax-view content-bottom"><div class="rax-view item-feed"><div class="cat-slider mb-4 mt-4 owl-carousel">';

                foreach ( $terms as $term ) {
                    if ($term->term_id == 23) {
                        echo '<div class="sc-crXcEl cCNGhG">';
                        $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
                        $image = wp_get_attachment_url( $thumbnail_id );
                        
                        echo '<a href="' . esc_url( get_term_link( $term ) ) .'">';
                        echo '<img src="'. $image .'" alt="'.$term->name.'">';
                        echo '<span>'.$term->name.'</span>';
                        echo '</a></div>';
                    }
                }

                echo '</div></div></section>';

            }
        }
    }


remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action('woocommerce_shop_loop_item_title', 'woocommerce_custom_page_title', 10 );

function woocommerce_custom_page_title() {
    echo '<div class="styles_product__name__71XoP">' . get_the_title() . '</div>';
}



// wrapper для списка продуктов
add_action( 'woocommerce_before_shop_loop', 'open_wrap_products', 10);
function open_wrap_products() {

    global $wp_query;
    $cat = $wp_query->get_queried_object();
    if(is_shop()) {
        $cat->name = 'Товары';
    }
    echo '<section class="rax-view content-bottom">';
    echo '<div class="rax-view item-feed">';
    echo '<div class="rax-view item-feed-header">';
    echo '<h1 class="rax-text-v2 header-title">'. $cat->name .'</h1>';
    echo '</div>';
}

add_action( 'woocommerce_after_shop_loop', 'end_wrap_products', 10);
function end_wrap_products() {
    echo '</div></div>';
}


add_filter('post_class', function($classes, $class, $product_id) {

    $classes = array_merge(['col-md-3', 'mb-4', 'col-6', 'styles_container__3wHdd'], $classes);
    
    return $classes;
},10,3);


// изменение класса изображение товара
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

add_action( 'woocommerce_before_shop_loop_item_title', 'minbazar_template_loop_product_thumbnail', 10);

function minbazar_template_loop_product_thumbnail() {
    echo '<div class="styles_image__6d1qy">';
    echo woocommerce_get_product_thumbnail();
    echo '</div>';
}

// cart page
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


add_filter('manage_edit-shop_order_columns', 'add_custom_order_meta_columns');
function add_custom_order_meta_columns($columns) {
    $columns['custom_ad_data'] = __('Доп. данные');
    return $columns;
}


add_action('manage_shop_order_posts_custom_column', 'display_custom_order_meta_columns');
function display_custom_order_meta_columns($column) {
    global $post, $the_order;
    if (empty($the_order) || $the_order->get_id() != $post->ID) {
        $the_order = wc_get_order($post->ID);
    }

    if ('custom_ad_data' === $column) {
        foreach ($the_order->get_items() as $item_id => $item) {
            $product_id = $item->get_product_id();
            $ad_data = get_post_meta($product_id, 'ad_data', true); // предполагаем, что 'ad_data' ключ мета-поля
            
            if (!empty($ad_data)) {
                echo '<ul class="table-custom-ad-dataa">';
                foreach ($ad_data as $key => $value) {
                    echo '<li><strong>' . esc_html($key) . ':</strong> ' . esc_html($value) . '</li>';
                }
                echo '</ul>';
            }
        }
    }
}

add_action('woocommerce_admin_order_data_after_order_details', 'display_custom_meta_fields_in_order');
function display_custom_meta_fields_in_order($order) {
    foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();
        $ad_data = get_post_meta($product_id, 'ad_data', true); // предполагаем, что 'ad_data' ключ мета-поля

        if (!empty($ad_data)) {
            echo '<h3>' . __('Дополнительные данные для товара') . ' ' . $item->get_name() . '</h3>';
            echo '<table class="wp-list-table widefat fixed striped">';
            foreach ($ad_data as $key => $value) {
                echo '<tr>';
                echo '<th>' . esc_html($key) . '</th>';
                echo '<td>' . esc_html($value) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    }
}

function custom_login_generator_script() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var nameField = document.getElementById('field_523');
            var phoneField = document.getElementById('field_522');
            var loginField = document.getElementById('field_1');
            var hiddenUsernameField = document.getElementById('signup_username');
            var hiddenEmailField = document.getElementById('signup_email');

            function transliterate(text) {
                var cyrillicToLatinMap = {
                    'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i', 
                    'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 
                    'у': 'u', 'ф': 'f', 'х': 'kh', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'shch', 'ы': 'y', 'э': 'e', 
                    'ю': 'yu', 'я': 'ya', 'ь': '', 'ъ': '', 'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 
                    'Ё': 'Yo', 'Ж': 'Zh', 'З': 'Z', 'И': 'I', 'Й': 'Y', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O', 
                    'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'Kh', 'Ц': 'Ts', 'Ч': 'Ch', 'Ш': 'Sh', 
                    'Щ': 'Shch', 'Ы': 'Y', 'Э': 'E', 'Ю': 'Yu', 'Я': 'Ya', 'Ь': '', 'Ъ': ''
                };

                return text.split('').map(function(char) {
                    return cyrillicToLatinMap[char] || char;
                }).join('');
            }

            function generateLogin() {
                var name = nameField.value.trim();
                var phone = phoneField.value.trim();
                var transliteratedName = transliterate(name.toLowerCase().replace(/\s+/g, ''));
                var suggestedLogin = transliteratedName + phone.slice(-4); // Use the last 4 digits of the phone number

                // AJAX call to check if the suggested login is unique
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    method: 'POST',
                    data: {
                        action: 'check_unique_login',
                        suggested_login: suggestedLogin
                    },
                    success: function(response) {
                        if (response.unique) {
                            loginField.value = suggestedLogin;
                            hiddenUsernameField.value = suggestedLogin;
                            hiddenEmailField.value = suggestedLogin + '@boqiy.uz';
                        } else {
                            // If not unique, append a random number
                            var uniqueLogin = suggestedLogin + Math.floor(Math.random() * 100);
                            loginField.value = uniqueLogin;
                            hiddenUsernameField.value = uniqueLogin;
                            hiddenEmailField.value = uniqueLogin + '@boqiy.uz';
                        }
                    }
                });
            }

            nameField.addEventListener('input', generateLogin);
            phoneField.addEventListener('input', generateLogin);
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_login_generator_script');




function check_unique_login() {
    global $wpdb;

    $suggested_login = sanitize_text_field($_POST['suggested_login']);
    $user = get_user_by('login', $suggested_login);

    if ($user) {
        wp_send_json_success(['unique' => false]);
    } else {
        wp_send_json_success(['unique' => true]);
    }

    wp_die();
}
add_action('wp_ajax_check_unique_login', 'check_unique_login');
add_action('wp_ajax_nopriv_check_unique_login', 'check_unique_login');



function custom_registration_validation_script() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('youzify_membership_signup_form');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                var phoneField = document.getElementById('field_522');
                var phone_number = phoneField.value.trim();

                // AJAX call to check phone number limit
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    method: 'POST',
                    data: {
                        action: 'check_phone_number_limit',
                        billing_phone: phone_number
                    },
                    success: function(response) {
                        if (response.success) {
                            // Create a hidden input field to store the success state
                            var hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'phone_validation_passed';
                            hiddenInput.value = '1';
                            form.appendChild(hiddenInput);

                            // Submit the form
                            form.submit();
                        } else {
                            alert(response.data.message);
                        }
                    }
                });
            });
        });
    </script>
    <?php
}
// add_action('wp_footer', 'custom_registration_validation_script');

function check_phone_number_limit() {
    if (isset($_POST['billing_phone'])) {
        global $wpdb;
        $phone_number = sanitize_text_field($_POST['billing_phone']);

        // Count the number of users with the same phone number
        $users = get_users(array(
            'meta_key' => 'billing_phone',
            'meta_value' => $phone_number,
            'number' => -1,
            'count_total' => true
        ));

        if (count($users) >= 2) {
            wp_send_json_error(array('message' => 'На этот номер телефона '. $phone_number  .' можно зарегистрировать не более двух аккаунтов.'));
        } else {
            wp_send_json_success();
        }
    } else {
        wp_send_json_error(array('message' => 'Не указан номер телефона.'));
    }

    wp_die();
}
add_action('wp_ajax_check_phone_number_limit', 'check_phone_number_limit');
add_action('wp_ajax_nopriv_check_phone_number_limit', 'check_phone_number_limit');


function save_custom_user_meta($user_id) {
    if (isset($_POST['billing_phone'])) {
        update_user_meta($user_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
}
add_action('user_register', 'save_custom_user_meta');

