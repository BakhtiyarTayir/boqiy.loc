<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
?>

<div class="post-preview animate-slide-down">

<?php
	$thumb	        = get_post_thumbnail_id();
	if($thumb){
	$image_url	    = buddyboss_resize( $thumb, '', 2.5, null, null, true );
	} else {
		$image_url	    = get_template_directory_uri().'/img/cover/default-cover.png';;
	}

?>
	<a href="<?php the_permalink(); ?>">
		<div class="post-preview-image" style="background: url(&quot;<?php echo $image_url; ?>&quot;) center center / cover no-repeat;"></div>
	</a>
	<div class="post-preview-info fixed-height">
		<div class="post-preview-info-top">		
			<p class="post-preview-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</p>
		</div>
		<div class="post-preview-info-bottom">
			<p class="post-preview-text"></p>
			<a class="post-preview-link" href="<?php the_permalink(); ?>"><?php echo __( 'Read more', 'boss' )?>...</a>
		</div>
	</div>
</div>



	
