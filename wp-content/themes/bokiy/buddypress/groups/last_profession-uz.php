<?php
/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter().
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of groups from the groups loop.
 *
 * @since 1.2.0 (BuddyPress)
 */

do_action( 'bp_before_groups_loop' ); 

?>

<?php if ( bp_get_current_group_directory_type() ) : ?>
	<p class="current-group-type"><?php bp_current_group_directory_type_message() ?></p>
<?php endif; ?>


<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<div class="tile-items-list row">

	<?php 
		$x = 1;
		while ( bp_groups() && $x <= 10 ) : bp_the_group(); 

		global $groups_template;
		$group_cover_image_url = bp_attachments_get_attachment('url', array(
			'object_dir' => 'groups',
			'item_id' => bp_get_group_id(),
		));
		if($group_cover_image_url){
			$group_image = $group_cover_image_url;
		} else {
			$group_image = get_template_directory_uri().'/img/cover/default-cover.png';
		}

		$has_children = hgbp_get_parent_group_id( bp_get_group_id() );
		
		$parent_group  = groups_get_group( $has_children );
		$breadcrumbs = bp_get_group_name( $parent_group );

		$grouptype = bp_groups_get_group_type(bp_get_group_id());
	if($grouptype =='kasb'){
		if($has_children){
			

	?>

		<article class="col-md-6 tile-item article full">
 			<a href="<?php bp_group_permalink();?>" style="height: 100%;">
				<div>
					<div class="cover b-lazy b-loaded" style="background-image: url(&quot;<?php echo $group_image; ?>&quot;);"></div>
					<div class="body">
						<div class="title">
							<a class="nl" href="<?php bp_group_permalink();?>" title="<?php bp_group_name(); ?>"><?php bp_group_name(); ?></a> 
						</div>
						<div class="category"><?php echo $breadcrumbs;?></div>
					</div>
				</div>		
 			 </a> 
		</article>

	<?php 
	$x++;
	};
};
	endwhile; 
	
	?>

	</div>




<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no groups found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>