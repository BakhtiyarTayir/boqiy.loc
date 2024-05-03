<div class="post-caption 04">

	<?php if ( 'yes' === $settings['show_caption_category'] ) : ?>
		<?php Billey_Post::instance()->the_categories(); ?>
	<?php endif; ?>

	<h3 class="post-title">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h3>

	
	<?php if ( 'yes' === $settings['show_caption_excerpt'] ) : ?>
		<?php
		if ( empty( $settings['excerpt_length'] ) ) {
			$settings['excerpt_length'] = 10;
		}
		?>
		<div class="post-excerpt">
			<?php Billey_Templates::excerpt( array(
				'limit' => $settings['excerpt_length'],
				'type'  => 'word',
			) ); ?>
		</div>
	<?php endif; ?>

	<?php if ( 'yes' === $settings['show_caption_read_more'] ): ?>
		<div class="post-read-more">
			<a href="<?php the_permalink(); ?>" class="tm-button style-flat tm-button-nm">
				<span class="button-text">
					<?php echo esc_html( $settings['read_more_text'] ); ?>
				</span>
			</a>
		</div>
	<?php endif; ?>

</div>
