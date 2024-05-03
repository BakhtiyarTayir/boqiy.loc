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

	<ul id="groups-list" class="item-list" aria-live="assertive" aria-atomic="true" aria-relevant="all">

	<?php while ( bp_groups() ) : bp_the_group(); 
	global $groups_template;
	$number_children = $groups_template->total_group_count;
	?>

		<li <?php bp_group_class(); ?>>	

			<div class="item">
				<a href="<?php 
				if($number_children>0) {
					 hgbp_group_hierarchy_permalink(); 
				} else {
					bp_group_permalink(); 
				}
				
				?>">
					<?php bp_group_avatar( 'type=thumb&width=50&height=50' ); ?>
					<div class="item-title"><?php bp_group_name(); ?></div>

					<?php

					/**
					 * Fires inside the listing of an individual group listing item.
					 *
					 * @since 1.1.0 (BuddyPress)
					 */
								
						do_action( 'bp_directory_groups_item' );	
					 ?>
				</a>
			</div>

			

		

			<div class="clear"></div>
		</li>

	<?php endwhile; ?>

	</ul>

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

<?php

/**
 * Fires after the display of groups from the groups loop.
 *
 * @since 1.2.0 (BuddyPress)
 */
do_action( 'bp_after_groups_loop' ); ?>
