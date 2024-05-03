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
 ?>



<?php
	// Fire an action outside of the has groups loop, but after the directory type message.
	do_action( 'hgbp_before_groups_loop' );
?>

<?php if (bp_has_groups( 'per_page=100000' )) : ?>

	

	

	<ul id="groups-list" class="item-list list-prof-cat" aria-live="assertive" aria-atomic="true" aria-relevant="all">

	<?php while ( bp_groups() ) : bp_the_group(); 
	global $groups_template;
	$has_children = hgbp_group_has_children( bp_get_group_id(), bp_loggedin_user_id(), 'normal' );
	if ($has_children){
		
	?>

		<li <?php bp_group_class(); ?>>		
			<a href="<?php hgbp_group_hierarchy_permalink(); ?>">
					<?php bp_group_name(); ?>
			</a>
			<span><?php number_child_group();?></span>			
		</li>

	<?php };
endwhile; ?>

	</ul>

	


<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no groups found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

