<?php
/**
 * The template for displaying the homepage.
 * 
 * Template name: Shop
 *
 */

?>
<?php get_header('shop'); ?>	


<div id="primary" class="page-content header-clear-medium">
		<div class="container">
		<?php
			while ( have_posts() ) :
				the_post();

				the_content();
			endwhile; // End of the loop.
			?>
		</div>
	</div>

<?php get_footer('shop'); ?>