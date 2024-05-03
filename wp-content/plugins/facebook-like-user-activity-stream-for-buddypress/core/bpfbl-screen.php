<?php
// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Profile activity stream screen.
 */
class BPFBLike_Activities_Screen_Helper {

	public function __construct() {
		$this->setup();
	}

	/**
	 * Setup hooks.
	 */
	public function setup() {
		if ( bpfblike_is_enabled_for( 'profile' ) ) {
			add_action( 'bp_activity_setup_nav', array( $this, 'add_activity_nav' ) );
			add_action( 'bp_activity_setup_nav', array( $this, 'set_nav_default' ), 5 );
		}
	}

	/**
	 * Add user nav.
	 */
	public function add_activity_nav() {

		if ( ! bp_is_user() || ! is_user_logged_in() || ! bp_is_my_profile() ) {
			return;
		}

		$slug = bp_get_activity_slug();

		$activity_link = bp_core_get_user_domain( bp_loggedin_user_id() ) . $slug . '/';

		$nav_label = bpfblike_get_option( 'user_stream_label', '' );
		if ( ! $nav_label ) {
			$nav_label = __( 'Your Stream', 'facebook-like-user-activity-stream-for-buddypress' );
		}

		// add to user activity subnav if it is logged in users profile.
		bp_core_new_subnav_item( array(
			'name'            => $nav_label,
			'slug'            => bpfblike_get_user_stream_slug(),
			'parent_url'      => $activity_link,
			'parent_slug'     => $slug,
			'screen_function' => array( $this, 'activity_screen' ),
			'position'        => 2,
			'user_has_access' => bp_is_my_profile(),
		) );

		bp_core_remove_subnav_item( 'activity', 'just-me' );

		if ( ! apply_filters( 'fblike_activity_hide_personal_tab', false ) ) {
			$sub_nav = array(
				'name'            => __( 'Personal', 'facebook-like-user-activity-stream-for-buddypress' ),
				'slug'            => 'personal', // did you note this?
				'parent_url'      => $activity_link,
				'parent_slug'     => $slug,
				'screen_function' => 'bp_activity_screen_my_activity',
				'position'        => 10,
			);

			bp_core_new_subnav_item( $sub_nav );
		}
	}

	/**
	 * Make your stream the default nav.
	 */
	public function set_nav_default() {

		if ( ! bp_is_my_profile() ) {
			return;
		}

		bp_core_new_nav_default( array(
			'parent_slug'     => bp_get_activity_slug(),
			'subnav_slug'     => bpfblike_get_user_stream_slug(),
			'screen_function' => array( $this, 'activity_screen' ),
		) );
	}

	/**
	 * Loading the activity stream on your stream tab
	 *
	 * Just load the home page and It will do the rest(since we are using subnav of activity, the activity template will be loaded).
	 */
	public function activity_screen() {
		do_action( 'bp_mystream_activity_screen' );
		bp_core_load_template( apply_filters( 'bp_activity_template_mystream_activity', 'members/single/home' ) );
	}

}

new BPFBLike_Activities_Screen_Helper();
