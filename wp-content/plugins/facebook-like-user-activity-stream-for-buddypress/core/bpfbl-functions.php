<?php
/**
 * Short Description
 *
 * @package    bp29_dev
 * @subpackage ${NAMESPACE}
 * @copyright  Copyright (c) 2018, Brajesh Singh
 * @license    https://www.gnu.org/licenses/gpl.html GNU Public License
 * @author     Brajesh Singh
 * @since      1.0.0
 */

/**
 * Get the setting.
 *
 * @param string $option option name.
 * @param mixed  $default default value.
 *
 * @return mixed
 */
function bpfblike_get_option( $option, $default = null ) {

	$options = get_option( 'bpfblike-settings' );

	return isset( $options[ $option ] ) ? $options[ $option ] : $default;
}

/**
 * Check if enabled for the screen.
 *
 * @param string $type possible values 'dir', 'profile'.
 *
 * @return bool
 */
function bpfblike_is_enabled_for( $type ) {
	$options = bpfblike_get_option( 'enabled_for', array(
		'dir',
		'profile',
	) );

	return is_array( $options ) ? in_array( $type, $options, true ) : false;
}

/**
 * Get user stream slug.
 *
 * @return string
 */
function bpfblike_get_user_stream_slug() {
	$slug = trim( bpfblike_get_option( 'user_stream_slug', MYSTREAM_ACTIVITY_SLUG ) );

	return $slug ? $slug : MYSTREAM_ACTIVITY_SLUG;
}

/**
 * Is it user's profile stream page?
 *
 * @return bool
 */
function bpfblike_is_user_stream() {

	if ( bp_is_my_profile() && bp_is_activity_component() && bp_is_current_action(bpfblike_get_user_stream_slug() ) ) {
		return true;
	}

	return false;
}
