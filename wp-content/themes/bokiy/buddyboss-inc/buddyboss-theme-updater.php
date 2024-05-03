<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

add_filter( 'bboss_licensed_packages', 'bosstheme_register_licensed_package' );
function bosstheme_register_licensed_package( $packages=array() ){
    $this_package = array(
        'id'        => 'boss',
        'name'      => __( 'Boss Theme', 'buddyboss-inbox' ),
        'products'  => array(
            //key should be unique for every individual buddyboss product
            //and if product X is included in 2 different packages, key for product X must be same in both packages.
            'BOSS' => array(
                'software_ids'  => array( 'BOSS_1S', 'BOSS_5S', 'BOSS_20S' ),
                'name'          => 'Boss Theme',
            ),
        ),
    );
    $packages['boss'] = $this_package;
    return $packages;
}

add_filter( 'bboss_updatable_products', 'bosstheme_register_updatable_product' );
function bosstheme_register_updatable_product( $products ){
    //key should be exactly the same as product key above
    $products['BOSS'] = array(
        //'path'  => plugin_basename(__FILE__),
        //@todo: this needs to be updated for all products
        'path'      => basename( get_template_directory() ),
        'id'        => 44,
        'software_ids'  => array( 'BOSS_1S', 'BOSS_5S', 'BOSS_20S' ),
        'type'      => 'theme',
        'releases_link' => 'https://www.buddyboss.com/release-notes/boss-theme-',
    );
    return $products;
}

if( !function_exists( 'bboss_notice_install_updater' ) ) {
    add_action( 'admin_notices', 'bboss_notice_install_updater' );
    function bboss_notice_install_updater(){
       
    }
}