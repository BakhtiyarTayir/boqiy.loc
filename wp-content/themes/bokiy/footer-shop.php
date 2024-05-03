<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package minbazar
 */

$terms = get_terms( [
    'taxonomy' => 'product_cat',
            'hide_empty' => false,
    ]);
?>

    <footer class="page-footer">
        <div class="container">
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-10">
                        <div class="horizontal">
                            <?php wp_nav_menu( [
                                'theme_location' => 'footer_menu',
                                'items_wrap'     => '<ul class="main-menu social-nav">%3$s</ul>',
                            
                            ] ); ?>
                           
                        </div>
                     
                    </div>
                    <div class="col-md-2">
                        <a href="https://play.google.com/store/apps/details?id=uz.esonuz.boqiyuz">
                            <img style="margin-bottom: -10px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTnr0L-oYL5nkxRylz8hxNYD28RdsotoETx3aJ8FXThN9CvydZupiIOmVZpM7EjoAvcog&usqp=CAU" width="100px" />
                        </a>
                    </div>            
                
                </div>
            </div>

        </div>
    </footer>

    <div id="footer-bar" class="footer-bar footer-bar-detached">
        <a data-bs-toggle="offcanvas" data-bs-target="#categoriesmenu" href="#">
            <svg fill="#000000" width="30px" height="30px" viewBox="0 0 35 35" data-name="Layer 2" id="e73e2821-510d-456e-b3bd-9363037e93e3" xmlns="http://www.w3.org/2000/svg"><path d="M11.933,15.055H3.479A3.232,3.232,0,0,1,.25,11.827V3.478A3.232,3.232,0,0,1,3.479.25h8.454a3.232,3.232,0,0,1,3.228,3.228v8.349A3.232,3.232,0,0,1,11.933,15.055ZM3.479,2.75a.73.73,0,0,0-.729.728v8.349a.73.73,0,0,0,.729.728h8.454a.729.729,0,0,0,.728-.728V3.478a.729.729,0,0,0-.728-.728Z"/><path d="M11.974,34.75H3.52A3.233,3.233,0,0,1,.291,31.521V23.173A3.232,3.232,0,0,1,3.52,19.945h8.454A3.232,3.232,0,0,1,15.2,23.173v8.348A3.232,3.232,0,0,1,11.974,34.75ZM3.52,22.445a.73.73,0,0,0-.729.728v8.348a.73.73,0,0,0,.729.729h8.454a.73.73,0,0,0,.728-.729V23.173a.729.729,0,0,0-.728-.728Z"/><path d="M31.522,34.75H23.068a3.233,3.233,0,0,1-3.229-3.229V23.173a3.232,3.232,0,0,1,3.229-3.228h8.454a3.232,3.232,0,0,1,3.228,3.228v8.348A3.232,3.232,0,0,1,31.522,34.75Zm-8.454-12.3a.73.73,0,0,0-.729.728v8.348a.73.73,0,0,0,.729.729h8.454a.73.73,0,0,0,.728-.729V23.173a.729.729,0,0,0-.728-.728Z"/><path d="M27.3,15.055a7.4,7.4,0,1,1,7.455-7.4A7.437,7.437,0,0,1,27.3,15.055Zm0-12.3a4.9,4.9,0,1,0,4.955,4.9A4.935,4.935,0,0,0,27.3,2.75Z"/></svg>           
        </a>
 
        <a href="<?php echo get_home_url()?>">
            <svg fill="#000000" width="30px" height="30px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20,8h0L14,2.74a3,3,0,0,0-4,0L4,8a3,3,0,0,0-1,2.26V19a3,3,0,0,0,3,3H18a3,3,0,0,0,3-3V10.25A3,3,0,0,0,20,8ZM14,20H10V15a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H16V15a3,3,0,0,0-3-3H11a3,3,0,0,0-3,3v5H6a1,1,0,0,1-1-1V10.25a1,1,0,0,1,.34-.75l6-5.25a1,1,0,0,1,1.32,0l6,5.25a1,1,0,0,1,.34.75Z"/></svg>
            
        </a>
      
        <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
            <svg fill="#000000" width="30px" height="30px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1,1,0,0,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1A10,10,0,0,0,15.71,12.71ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z"/></svg>
            
        </a>
        <a class="link-dropdown position-relative" href="<?php echo wc_get_cart_url(); ?>">
            <svg fill="#000000" width="30px" height="30px" viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"><path d="M8.5,19A1.5,1.5,0,1,0,10,20.5,1.5,1.5,0,0,0,8.5,19ZM19,16H7a1,1,0,0,1,0-2h8.49121A3.0132,3.0132,0,0,0,18.376,11.82422L19.96143,6.2749A1.00009,1.00009,0,0,0,19,5H6.73907A3.00666,3.00666,0,0,0,3.92139,3H3A1,1,0,0,0,3,5h.92139a1.00459,1.00459,0,0,1,.96142.7251l.15552.54474.00024.00506L6.6792,12.01709A3.00006,3.00006,0,0,0,7,18H19a1,1,0,0,0,0-2ZM17.67432,7l-1.2212,4.27441A1.00458,1.00458,0,0,1,15.49121,12H8.75439l-.25494-.89221L7.32642,7ZM16.5,19A1.5,1.5,0,1,0,18,20.5,1.5,1.5,0,0,0,16.5,19Z"/></svg>
            <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>           
        </a>
    </div>

    <div id="menu-main" data-menu-active="nav-homes" class="offcanvas offcanvas-start offcanvas-detached rounded-m">
        <div class="menu-list">
            <div class="card card-style rounded-m p-3 py-2 mb-0 mt-3">
                <?php wp_nav_menu( [
					'theme_location' => 'footer_menu',
					'items_wrap'     => '<ul class="main-menu social-nav">%3$s</ul>',
				] ); ?>
                  <a href="https://play.google.com/store/apps/details?id=uz.esonuz.boqiyuz">
                            <img style="margin-bottom: -10px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTnr0L-oYL5nkxRylz8hxNYD28RdsotoETx3aJ8FXThN9CvydZupiIOmVZpM7EjoAvcog&usqp=CAU" width="100px" />
                        </a>  
                <div class="ec-header-bottons">
                    <div class="top-lang  sm:block">
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
    <div id="mobile-contacts" data-menu-active="nav-homes" class="offcanvas offcanvas-start offcanvas-detached rounded-m">
        <div class="menu-list">        
            <div class="card card-style rounded-m p-3 py-2 mb-0 mt-3">
            <a href="tel:+998909779095">+998 90 977 90 95</a>
            </div>
           
        </div>

    </div>
    <div id="categoriesmenu" data-menu-active="nav-homes" class="offcanvas offcanvas-start offcanvas-detached rounded-m">
        <div class="menu-list">
            <div class="card card-style rounded-m p-3 py-2 mb-0 mt-3">
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

            </div>            
        </div>

    </div>


<?php wp_footer(); ?>
<script>
window.replainSettings = { id: 'e3fc9812-2dc4-4631-aa66-9c4703937e45' };
(function(u){var s=document.createElement('script');s.async=true;s.src=u;
var x=document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);
})('https://widget.replain.cc/dist/client.js');
</script>
</body>
</html>
