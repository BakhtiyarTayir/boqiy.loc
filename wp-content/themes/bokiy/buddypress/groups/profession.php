<?php
/**
 * BuddyPress - Groups
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires at the top of the groups directory template file.
 *
 * @since 1.5.0
 */
global $hgbp_group_loop_parent_group_id;
global $groups_template;
$sections         = hgbp_get_group_hierarchy_screen_contents_setting();
$current_group_id = bp_get_current_group_id();
$parent_group_id  = hgbp_get_parent_group_id( false, bp_loggedin_user_id(), 'normal' );
$has_group_args = array(
	'parent_id'          => bp_get_group_id(),
	'orderby'            => 'date_created',
	'update_admin_cache' => false,
	'per_page'           => false,
);

$parent_groups_template = $groups_template;
// Add the parent groups breadcrumb links
if ( $sections['ancestors'] ) :

	?>
	<?php bp_get_template_part( 'groups/groups-loop-parent' ); 
	// Put the parent $groups_template back.
    $groups_template = $parent_groups_template;
	?>

	<?php
endif;

// Add the sibling groups list
if ( $sections['siblings'] ) :
	$hgbp_group_loop_parent_group_id = $parent_group_id;
	?>
	<div class="sibling-group-directory">
		<h3><?php _e( 'Sibling Groups', 'hierarchical-groups-for-bp' ); ?></h3>
		<?php bp_get_template_part( 'groups/groups-loop-tree' ); ?>
	</div>
	
	<?php
endif;

