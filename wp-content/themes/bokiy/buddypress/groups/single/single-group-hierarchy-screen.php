<?php
/**
 * HierarchicalGroupsForBP - Single group hierarchy screen
 *
 * This template is used to create the single group hierarchy screen,
 * which can contain several sections, chosen by the site admin via the
 * plugin options form.
 *
 * @package HierarchicalGroupsForBP
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
	<div class="parent-group-breadcrumbs">
		<h1><?php hgbp_group_permalink_breadcrumbs(); ?></h1>
		
	</div>

	<?php
endif;

// Add the sibling groups list
if ( $sections['siblings'] ) :
	$hgbp_group_loop_parent_group_id = $parent_group_id;
	?>
	<div class="sibling-group-directory">
		<h3><?php _e( 'Sibling Groups', 'hierarchical-groups-for-bp' ); ?></h3>
		<?php bp_get_template_part( 'groups/groups-loop' ); ?>
	</div>
	<hr />
	<?php
endif;

// Add the child group section
if ( $sections['children'] ) :
	global $bp;
	$group = groups_get_group( $current_group_id);	
	$hgbp_group_loop_parent_group_id = $current_group_id;
	if(hgbp_get_child_groups()){
	?>
	<div class="child-groups-directory">
		
		<?php bp_get_template_part( 'groups/groups-loop-child' ); ?>
		
	</div>
	<?php
	}
	
endif;
