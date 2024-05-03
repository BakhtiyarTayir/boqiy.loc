<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package minbazar
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
</head>
<?php
	$current_lang = pll_current_language();
	if($current_lang == 'en'){
		$action_text = 'en';
	}else if($current_lang == 'uz'){
		$action_text = 'uz';
	}else{
		$action_text = '';
	}
    $options = get_option( 'pu_theme_options' );
    $terms = get_terms( [
        'taxonomy' => 'product_cat',
                'hide_empty' => false,
        ]);

?>

<body class="main theme-light">

    <header class="main-header header-bar header-fixed header-app header-bar-detached">
        <div class="site-nav site-nav-status-logout">
            <div class="container position-relative">
                <div class="row">
                    <div class="ec-flex">
                        <div class="align-self-center">
                            <?php wp_nav_menu( [
                                'theme_location' => 'header_menu',
                                'items_wrap'     => '<ul class="main-menu social-nav">%3$s</ul>',
                            
                            ] ); ?>
                        </div>
                        <div class="align-self-center">
                            <div class="ec-header-bottons">                               
                                <!-- Header User Start -->
                                <div class="ec-header-bottons">
                                    <div class="top-lang sm:block">
                                        <div class="top-lang-item">
                                            <div class="lang-icon"><i class="fa fa-globe"></i></div>
                                            <div class="locales language-menu">
                                                <?php pll_the_languages( array( 'dropdown' => 1 ) ); ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="ec-header-bottom d-none d-lg-block">
            <div class="container position-relative">
                <div class="row">
                    <div class="ec-flex">
                        <!-- Ec Header Logo Start -->
                        <div class="align-self-center first-header">
                            <div class="header-logo">
                                <?php if ( is_user_logged_in() || (!is_user_logged_in() && buddyboss_is_bp_active() ) ) {?>
                                <a href="<?php echo bp_core_get_user_domain( get_current_user_id() ); ?>/activity/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                    <?php } else {?>
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                    <?php }?>
                            
                                    <img class="large" src="<?php echo get_template_directory_uri().'/images/boqiy_logo.png'; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                                </a>
                            </div>
                            <button type="button" class="sc-clsHhM gxEnBn sc-kNMOeM fvooyb">
                                <span class="sc-lcujXC ckFvLy">
                                    <span class="mobile-menu-toggle">
                                        <span class="line-1"></span>
                                        <span class="line-2"></span>
                                        <span class="line-3"></span>
                                    </span>
                                    <?php echo __('Сatalog', 'boss'); ?>
                                </span>
                            </button>
                        </div>
                        <!-- Ec Header Logo End -->
    
                        <!-- Ec Header Search Start -->
                        <div class="align-self-center">
                            <div class="header-search">
                                <form role="search" method="get" id="searchform" action="<?php echo get_home_url() . $action_text ?>" class="ec-btn-group-form" >
									<input autocomplete="off" type="text" class="form-control" name="s" value="<?php echo get_search_query() ?>" placeholder="<?php echo __('Search', 'boss'); ?> ">
									<input type="hidden" name="post_type" value="product">
                                    <button type="submit" class="btn-submit search-box"><span><?php echo __('Search', 'boss'); ?></span></button>
								</form>
                            </div>
                        </div>
                        <!-- Ec Header Search End -->
                        <div class="align-self-center third-header">
                            <a href="<?php echo wp_login_url(); ?>" class="ec-header-btn ec-side-toggle hidden-xs">
                                    <div class="header-icon"><i class="fa fa-user"></i></div>
                            </a>
                            <?php  
                             if ( function_exists( 'minbazar_woocommerce_header_cart' ) ) {
                                minbazar_woocommerce_header_cart();
                                }
                            ?>
                        </div>
                        


                    </div>
                    <div class="sc-gpsAVS XqbgT uZATO">
                        <div class="sc-jNWZdT daPpPm">
                        <section class="sc-hiSbYr sc-dOFTbv drImqd">
                            <div class="maincategories">
                            <?php
                                if( $terms ){
                                    foreach( $terms as $term ){ 
                                        if( $term->name != 'Misc') {
                                            $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
                                            $image = wp_get_attachment_url( $thumbnail_id );
                                            ?>
                                            <a href="<?php echo esc_url( get_term_link( $term ) ) ?>" class="catlist-a icons28">
                                                <img class="iconcat" src="<?php echo $image ?>" width="15" height="15"> 
                                                <?php echo $term->name; ?>
                                            </a>
                                            <?php
                                        }
                                    }
                                }
                             ?>
                            </div>
                        </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sc-LwQvY eNsSPe scrolledf">
            <div class="sc-eYErCu hBspgl">
                <div class="sc-hiola-d iVtAtO">
                    <a data-bs-toggle="offcanvas" data-bs-target="#menu-main" href="#">
                        <span class="mobile-menu-toggle">
                            <span class="line-1"></span>
                            <span class="line-2"></span>
                            <span class="line-3"></span>
                        </span>
                    </a>
                </div>
                <div class="sc-erqdvE eeyqGF">
                <?php if ( is_user_logged_in() || (!is_user_logged_in() && buddyboss_is_bp_active() ) ) {?>
                                <a href="<?php echo bp_core_get_user_domain( get_current_user_id() ); ?>/activity/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                    <?php } else {?>
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                    <?php }?>
                            
                                    <img class="header__logo" src="<?php echo get_template_directory_uri().'/images/boqiy_logo.png'; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                                </a>             
                </div>
                <div class="sc-gacHD ipwmPt">
                    <a data-bs-toggle="offcanvas" data-bs-target="#mobile-contacts" href="#">
                        <i class="fa fa-phone"></i>
                    </a>
                </div>
            </div>
            <div class="mobile-search position-relative d-lg-none pt-2 pb-2">

                <form role="search" method="get" action="<?php echo get_home_url() . $action_text ?>" class="ec-btn-group-form">
                    <input autocomplete="off" type="text" class="form-control" name="s" value="" placeholder="<?php echo __('Search', 'boss'); ?>">
                    <input type="hidden" name="post_type" value="product">
                    <button type="submit" class="btn-submit search-box">
                        <span><?php echo __('Search', 'boss'); ?></span>
                    </button>
                </form>
            </div>
        </div>


    </header>