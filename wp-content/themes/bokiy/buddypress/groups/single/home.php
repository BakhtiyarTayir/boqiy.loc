<?php
/**
 * Vikinger Template - BuddyPress Groups Home
 * 
 * Determines group template to display
 * 
 * @package Vikinger
 * @since 1.0.0
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

  if (bp_has_groups()) {
    while (bp_groups()) {
      bp_the_group();



      /**
       * Get groups page header
       */
      bp_get_template_part('groups/single/group-header');

      /**
       * Get members page current template
       */ 
      if (bp_is_group_home()) {
        if (bp_group_is_visible()) {
          bp_get_template_part('groups/single/frontpage');

				} else {
          // private group
        }
      } elseif (bp_is_group_admin_page()) {
        bp_get_template_part('groups/single/admin');

      } elseif (bp_is_group_activity()) {
        bp_get_template_part('groups/single/activity');

      } elseif (bp_is_group_members()) {
        bp_get_template_part('groups/single/members');

      } elseif (bp_is_group_invites()) {
        bp_get_template_part('groups/single/send-invites');

      } elseif (bp_is_group_membership_request()) {
        bp_get_template_part('groups/single/request-membership');

      } else {
        bp_get_template_part('groups/single/plugins');

      }
    }
  }

?>


<!-- /CONTENT GRID -->