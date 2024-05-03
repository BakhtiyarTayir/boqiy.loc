<?php
/**
 * Template Name: University
 * Vikinger Template - Archive
 * 
 * 
 * @package Vikinger
 * @since 1.0.0
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

  get_header(); 

  $year   = get_query_var('year');
  $month  = get_query_var('monthnum');
  $day    = get_query_var('day');

?>

<!-- CONTENT GRID -->
<div class="container mt-5">
<div class="section-banner" style="background: url('<?php echo get_template_directory_uri();?>/images/banner-bg.png') center center / cover no-repeat;">
  <!-- SECTION BANNER ICON -->
  
  <!-- /SECTION BANNER ICON -->
  <!-- SECTION BANNER TITLE -->
  <p class="section-banner-title"><?php echo pll__('Universities', 'boss'); ?></p>
  <!-- /SECTION BANNER TITLE -->
  
</div> 

  <!-- POST PREVIEW FILTERABLE LIST -->
    <div class="row">
        <div class="col-md-9">
          
            <div class="tile-items-list row mt-4">
                        <?php

                        // параметры по умолчанию
                        $posts = get_posts( array(
                            'numberposts' => 999999999999999999999,
                            // 'category'    => $course,
                            'orderby'     => 'date',
                            'order'       => 'DESC',
                            'include'     => array(),
                            'exclude'     => array(),
                            'meta_key'    => '',
                            'meta_value'  =>'',
                            'post_type'   => 'university',
                            'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
                        ) );

                        foreach( $posts as $post ){
                            setup_postdata($post);
                            ?>
                            <article class="col-md-4 tile-item article full">
                                <div>
                                  <div class="cover b-lazy b-loaded" style="background-image: url(&quot;<?php the_post_thumbnail_url(); ?>&quot;);"></div>
                                  <div class="body">
                                    <div class="title">
                                      <a class="nl" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> 
                                    </div>
                                    
                                  </div>
                                </div>
                              </article>
                            <?php
                        }
                        wp_reset_postdata(); // сброс
                        ?>
           
            </div>
        </div>

        <div class="course-sidebar col-md-3">
            <?php dynamic_sidebar('university_ads');?>
        </div>
    </div>
  <!-- /POST PREVIEW FILTERABLE LIST -->
</div>
<!-- /CONTENT GRID -->

<?php get_footer(); ?>