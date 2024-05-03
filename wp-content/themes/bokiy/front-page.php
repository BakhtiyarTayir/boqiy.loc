<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in BuddyBoss consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
get_header();
?>

<?php if ( is_active_sidebar( 'home-right' ) ) : ?>
	<div class="page-right-sidebar">
	<?php else : ?>
		<div class="page-full-width">
		<?php endif; ?>

		<div id="primary" class="site-content">

			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>
					

				<?php endwhile; // end of the loop. ?>

               

			</div><!-- #content -->
		</div><!-- #primary -->

		

	</div><!-- .page-left-sidebar -->

	<?php get_footer(); ?>