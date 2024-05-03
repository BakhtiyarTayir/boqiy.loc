<?php
add_filter( 'youzify_wc_enable_my_account_redirect', '__return_false' );
add_filter( 'youzify_woocommerce_enable_redirects', '__return_false' );

/**
 * Disable Profile Woocommerce Tabs.
 */
function yzc_disable_profile_woocommerce_tab( $tabs ) {

    // Add Here the list of pages you want to disable.
    $pages = array( 'checkout', 'cart' );

    foreach ( $pages as $page ) {
        if ( isset( $tabs[ $page ] ) ) {
            unset( $tabs[ $page ] ); 
        }
    }

    return $tabs;
}

add_filter( 'youzify_woocommerce_sub_tabs', 'yzc_disable_profile_woocommerce_tab' );
add_filter( 'youzify_supported_wc_pages', 'yzc_disable_profile_woocommerce_tab' );


/**
 * Disable Woocommerce Tabs Sidebar.
 * Add This css to your site also : .buddypress.shop .yz-horizontal-layout .yz-main-column { width: 100% !important; float: none !important; }
 */
function yzc_disable_woocommerce_tabs_sidebar( $active ) {

    if ( function_exists( 'youzify_is_woocommerce_tab' ) && youzify_is_woocommerce_tab() ) {
        return false;
    }

    return $active;
}

add_filter( 'youzify_display_profile_sidebar', 'yzc_disable_woocommerce_tabs_sidebar' );


add_action( 'wp_loaded', function(){
	remove_action( 'wp_enqueue_scripts', 'youzify_woocommerce_scripts' );
} );
