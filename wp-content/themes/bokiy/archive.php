<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Boss already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
get_header();
?>

<?php
if ( is_active_sidebar( 'sidebar' ) ) :
	echo '<div class="page-right-sidebar">';
else :
	echo '<div class="page-full-width">';
endif;
?>

<section id="primary" class="site-content">
	<div id="content" role="main">

		<header class="archive-header page-header">
			<?php
			the_archive_title( '<h1 class="archive-title main-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header>

		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content', 'blog' );

			endwhile;

			buddyboss_pagination();
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- #content -->
</section><!-- #primary -->

<?php


// page-left-sidebar
echo '</div>';

get_footer();
