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
do_action( 'bp_before_groups_loop' ); ?>

<?php if ( bp_get_current_group_directory_type() ) : ?>
	<p class="current-group-type"><?php bp_current_group_directory_type_message() ?></p>
<?php endif; ?>

<?php
	// Fire an action outside of the has groups loop, but after the directory type message.
	do_action( 'hgbp_before_groups_loop' );
?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<?php

	/**
	 * Fires before the listing of the groups tree.
	 * Specific to the Hierarchical Groups for BP plugin.
	 *
	 * @since 1.0.0
	 */
	do_action( 'hgbp_before_directory_groups_list_tree' ); ?>

	<?php

	/**
	 * Fires before the listing of the groups list.
	 *
	 * @since 1.1.0 (BuddyPress)
	 */
	do_action( 'bp_before_directory_groups_list' );

	?>

	<div class="tile-items-list row">

	<?php while ( bp_groups() ) : bp_the_group(); 
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

	$has_children = hgbp_get_parent_group_id( bp_get_group_id(), bp_loggedin_user_id(), 'directory' );
	
	$parent_group  = groups_get_group( $has_children );
	$breadcrumbs = bp_get_group_name( $parent_group );


	?>

		<article class="col-sm-12 col-md-12 col-lg-4 col-xl-3 tile-item article full ">
			<div>
				<div class="cover b-lazy b-loaded" style="background-image: url(&quot;<?php echo $group_image; ?>&quot;);"></div>
				<div class="body">
					<a style="height:100%;" href="<?php bp_group_permalink();?>">
						<div class="title">
						<a class="nl" href="<?php bp_group_permalink();?>" title="<?php bp_group_name(); ?>"><?php bp_group_name(); ?></a> 
					</div>
					<div class="category"><?php echo $breadcrumbs;?></div>
					</a>
					
				</div>
			</div>		
		</article>

	<?php 
endwhile; ?>

	</div>

	<?php

	/**
	 * Fires after the listing of the groups list.
	 *
	 * @since 1.1.0 (BuddyPress)
	 */
	do_action( 'bp_after_directory_groups_list' ); ?>


<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no groups found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>


