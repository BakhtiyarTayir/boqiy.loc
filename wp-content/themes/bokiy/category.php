<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */

get_header(); ?>
<?php if ( is_active_sidebar('sidebar') ) : ?>
	<div class="container mt-5">
<?php else : ?>
	<div class="page-full-width">
<?php endif; ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
       
        <header class="archive-header page-header">
            <h1 class="archive-title main-title"> <?php single_cat_title( '', true ) ; ?></h1>
           
        </header><!-- .archive-header -->

        <div class="clear"></div>

		<?php if ( have_posts() ) : ?>
		
			<div class="grid grid-4-4-4 centered-on-mobile">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'blog' ); ?>
				<?php endwhile; ?>
			</div>
			<div class="pagination-below">
				<?php buddyboss_pagination(); ?>
			</div>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

    </div>
<?php get_footer(); ?>
