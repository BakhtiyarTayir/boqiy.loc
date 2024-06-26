<?php
/**
 * BuddyPress - Groups plugins
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires before the display of content for plugins using the BP_Group_Extension.
 *
 * @since 1.2.0
 */
 ?>

<?php

/**
 * Fires and displays content for plugins using the BP_Group_Extension.
 *
 * @since 1.0.0
 */
do_action( 'bp_template_content' ); ?>

<?php

/**
 * Fires after the display of content for plugins using the BP_Group_Extension.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_group_plugin_template' );
