<?php
/**
 * Affiliate Dashboard Summary
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Affiliates
 * @version 1.0.5
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<div class="yith-wcaf yith-wcaf-dashboard-summary woocommerce">

	<?php
	if ( function_exists( 'wc_print_notices' ) ) {
		wc_print_notices();
	}

	function cq_pagination($pages = '', $range = 4)
    {
        $showitems = ($range * 2)+1;
        global $paged;
        if(empty($paged)) $paged = 1;
        if($pages == '')
        {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if(!$pages)
            {
                $pages = 1;
            }
        }
        if(1 != $pages)
        {
            echo "<nav aria-label='Page navigation example'>  <ul class='pagination'> <span>Page ".$paged." of ".$pages."</span>";
            if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
            if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
            for ($i=1; $i <= $pages; $i++)
            {
                if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                {
                    echo ($paged == $i)? "<li class=\"page-item active\"><a class='page-link'>".$i."</a></li>":"<li class='page-item'> <a href='".get_pagenum_link($i)."' class=\"page-link\">".$i."</a></li>";
                }
            }
            if ($paged < $pages && $showitems < $pages) echo " <li class='page-item'><a class='page-link' href=\"".get_pagenum_link($paged + 1)."\">i class='flaticon flaticon-back'></i></a></li>";
            if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo " <li class='page-item'><a class='page-link' href='".get_pagenum_link($pages)."'><i class='flaticon flaticon-arrow'></i></a></li>";
            echo "</ul></nav>\n";
        }
  }

	?>

	<?php do_action( 'yith_wcaf_before_dashboard_summary' ); ?>

	

	<div class="dashboard-content">
		<!--NAVIGATION MENU-->
		<?php
		$atts = array(
			'show_right_column'    => $show_right_column,
			'show_left_column'     => $show_left_column,
			'show_dashboard_links' => $show_dashboard_links,
			'dashboard_links'      => $dashboard_links,
		);
		yith_wcaf_get_template( 'navigation-menu.php', $atts, 'shortcodes' );
		?>
	
			<div class="partner-content <?php echo ( ! $show_right_column ) ? 'full-width' : ''; ?>">
			
				
				<div class="columns-4 products col_wrap_fourth rh-flex-eq-height woogridrev">
					
				<?php
					$defaultLanguage = pll_default_language();
					$currLang = substr(get_bloginfo('language'), 0, 2);
					$pagenum_link = html_entity_decode($_SERVER['REQUEST_URI']); /*Часть url: /test/page/2/ */
					if($defaultLanguage === $currLang){
						$pagenum_link = substr($pagenum_link, 2, -1); /*Часть url: test/page/2 (обрезаем первый и последний слэши)*/
						$query_argss = array();
						$url_parts = explode( '/', $pagenum_link ); /*Массив: [0]=>'test, [1]=>page', [2]=>номер страницы*/
						$posts_perr_page = 12; //Постов на странице
						
						if ( isset( $url_parts[2] ) ) {
							$current_page = $url_parts[3];
							$posts_to_skip = ($url_parts[3] - 1)*$posts_perr_page; // Считаем сколько постов пропустить
						} else {
							$posts_to_skip = 0;
							$current_page = max( 1, get_query_var( 'payments' ) );
						}
					} else {
						$pagenum_link = substr($pagenum_link, 2, -1); /*Часть url: test/page/2 (обрезаем первый и последний слэши)*/
						$query_argss = array();
						$url_parts = explode( '/', $pagenum_link ); /*Массив: [0]=>'test, [1]=>page', [2]=>номер страницы*/
						$posts_perr_page = 12; //Постов на странице
						
						if ( isset( $url_parts[3] ) ) {
							$current_page = $url_parts[4];
							$posts_to_skip = ($url_parts[4] - 1)*$posts_perr_page; // Считаем сколько постов пропустить
						} else {
							$posts_to_skip = 0;
							$current_page = max( 1, get_query_var( 'payments' ) );
						}
					}
					

					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$query_args = array( 
						'post_type' => 'product',
						'tax_query' => array(
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'term_id',
								'terms'    => array(8231),
								),
						),
						'orderby' => 'date', 
						'order' => 'DESC', 
						'posts_per_page' => $posts_perr_page, 
						'paged' => $paged, 
						'offset' => $posts_to_skip 
					);

					
				
					$custom_post_type = new WP_Query( $query_args );
					$wp_query = $custom_post_type;	
								
					if ( $custom_post_type->have_posts() ) :
						while ( $custom_post_type->have_posts() ) :
							$custom_post_type->the_post(); 							
							include( YITH_WCAF_SHORT.'woogridimage.php' );
							
						
						endwhile;	
						
						
					endif;
			
					
					wp_reset_postdata();
					

					?>
					<nav class="woocommerce-pagination">
					<?php

					$big = 999999999; // need an unlikely integer
					echo paginate_links( array(
						'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'             => '?paged=%#%',
						'current'            => $current_page,
						'total'              => $custom_post_type->max_num_pages,
						'screen_reader_text' => __( 'To view more, click the links below' ),
						'mid_size'           => 2,
						'type'         => 'list',
						'prev_text'          => __( '←'),
						'next_text'          => __( '→' ),
					) );
					?>
					</nav>
				
					

				</div><!--/.products-->
				
				
				
			</div>
		

		

	</div>

	

	<?php do_action( 'yith_wcaf_after_dashboard_summary' ); ?>

</div>
