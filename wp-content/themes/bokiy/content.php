<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
?>

<div class="post-preview animate-slide-down hello">

	<!-- Single blog post -->
	<?php if ( is_single() ) : ?>
		<!-- Title -->
		<header class="entry-header">

			<h1 class="entry-title"><?php the_title(); ?></h1>

		</header><!-- .entry-header -->

	<?php endif; // is_single() ?>

	<!-- Search, Blog index, archives -->
	<?php if ( is_search() || is_archive() || is_home() ) : // Only display Excerpts for Search, Blog index, and archives ?>

		<?php if ( has_post_thumbnail() ) : ?>
			<a class="entry-post-thumbnail" href="<?php the_permalink(); ?>">
				<?php
				$thumb	        = get_post_thumbnail_id();
				$image_url	    = buddyboss_resize( $thumb, '', 2.5, null, null, true );
				?>
				<img src="<?php echo $image_url; ?>" alt="<?php the_title(); ?>"/>

			</a>
		<?php else : ?>
			<div class="whitespace"></div>
		<?php endif; ?>

		<div class="post-wrap">

			<header>
				<h1 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'boss' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h1>
			</header><!-- .entry-header -->

			<div class="entry-meta mobile">
				<?php buddyboss_entry_meta( false ); ?>
			</div>

			<div class="entry-content entry-summary <?php if ( has_post_thumbnail() ) : ?>entry-summary-thumbnail<?php endif; ?>">

				<?php
						//entry-content
						if ( 'excerpt' === boss_get_option( 'boss_entry_content' ) ):
				            the_excerpt();
						else:
				            the_content();
				        endif;
				?>


			</div><!-- .entry-content -->

		</div><!-- .post-wrap -->

		<!-- all other templates -->
	<?php else : ?>

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'boss' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'boss' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<div class="proposal-view-more">
			<div class="share">
				<span class="d-block mr-2"><?php echo __( 'Share with friends', 'boss' )?></span>
				<div class="ya-share2 ya-share2_inited"  data-size="s">
					<div class="ya-share2__container ya-share2__container_size_s ya-share2__container_color-scheme_normal ya-share2__container_shape_normal">
						<ul class="ya-share2__list ya-share2__list_direction_horizontal">
							<li class="ya-share2__item ya-share2__item_service_vkontakte">
								<a class="ya-share2__link" href="https://vk.com/share.php?url=<?php echo rawurlencode( get_permalink() );?>&amp;title=<?php echo rawurlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="ВКонтакте">
									<span class="ya-share2__badge"><i class="fab fa-vk"></i></span>									
								</a>
							</li>
							<li class="ya-share2__item ya-share2__item_service_twitter">
								<a class="ya-share2__link" href="https://twitter.com/intent/tweet?text=<?php echo rawurlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;url=<?php echo rawurlencode( get_permalink() );?>&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="Twitter">
									<span class="ya-share2__badge"><i class="fab fa-twitter"></i></span>								
								</a>
							</li>
							<li class="ya-share2__item ya-share2__item_service_facebook">
								<a class="ya-share2__link" href="https://www.facebook.com/sharer.php?src=sp&amp;u=<?php echo rawurlencode( get_permalink() );?>&amp;title=<?php echo rawurlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="Facebook">
									<span class="ya-share2__badge"><i class="fab fa-facebook"></i></span>								
								</a>
							</li>
							<li class="ya-share2__item ya-share2__item_service_odnoklassniki">
								<a class="ya-share2__link" href="https://connect.ok.ru/offer?url=<?php echo rawurlencode( get_permalink() );?>&amp;title=<?php echo rawurlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="Одноклассники">
									<span class="ya-share2__badge"><i class="fab fa-odnoklassniki"></i></span>								
								</a>
							</li>
							<li class="ya-share2__item ya-share2__item_service_telegram">
								<a class="ya-share2__link" href="https://t.me/share/url?url=<?php echo rawurlencode( get_permalink() );?>&amp;text=<?php echo rawurlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ); ?>&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="Telegram">
									<span class="ya-share2__badge"><i class="fab fa-telegram-plane"></i></span>
									
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

	<?php endif; ?>


</div><!-- #post -->
