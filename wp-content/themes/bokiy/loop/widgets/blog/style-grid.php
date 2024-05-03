<?php
while ( $billey_query->have_posts() ) :
	$billey_query->the_post();
	$classes = array( 'grid-item', 'post-item');
	?>
	
	<a href="<?php the_permalink(); ?>" <?php post_class( implode( ' ', $classes ) ); ?>>	
		<div class="style-scope ytd-rich-grid-media">
			<div class="article-gridlet-card__image" style="background-image:url(<?php echo the_post_thumbnail_url()?>);"></div>
			<div class="article-gridlet-card__color"></div>
		</div>
		<div class="article-gridlet-card__info">
			<p class="article-gridlet-card__title"><?php echo the_title();?></p>
			
		</div>		
	</a>
<?php endwhile;
