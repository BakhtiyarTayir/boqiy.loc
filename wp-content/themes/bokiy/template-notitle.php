<?php
/**
 * The template for displaying the homepage.
 * 
 * Template name: No title
 *
 */

?>
<?php get_header(); ?>	
<div class="container mt-5">

        <div id="primary" class="site-content">

            <div id="content" role="main">

                <?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
                <?php endwhile; // end of the loop. ?>

            </div><!-- #content -->
        </div><!-- #primary -->

  
    </div>
<?php get_footer(); ?>