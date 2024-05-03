<?php
// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Class BD_FBLike_Activities_Filters_Helper
 */
class BD_FBLike_Activities_Filters_Helper {

	public function __construct() {
		$this->setup();
	}

	/**
	 * Setup hooks.
	 */
	public function setup() {
		// fix delete link on mystream activity.
		add_filter( 'bp_activity_delete_link', array( $this, 'fix_delete_link' ), 10, 2 );
		// show post form on the my stream page.
		add_action( 'bp_before_member_activity_post_form', array( $this, 'show_post_form' ) );
	}

	/**
	 * Fix delete link for the activity items no belonging to current user, bp does not honour it by default
	 *
	 * @param string               $del_link delete link for activity.
	 * @param BP_Activity_Activity $activity Activity.
	 *
	 * @return string
	 */
	public function fix_delete_link( $del_link, $activity ) {

		if ( ! bpfblike_is_user_stream() ) {
			return $del_link;
		}

		// let us apply our mod.
		if ( ( is_user_logged_in() && $activity->user_id == bp_loggedin_user_id() ) || is_super_admin() ) {
			return $del_link;
		}

		return '';

	}

	/**
	 * Show post form on the stream page
	 */
	public function show_post_form() {

		if ( is_user_logged_in() && bpfblike_is_user_stream() ) {
			bp_locate_template( array( 'activity/post-form.php' ), true );
		}
	}
}

new BD_FBLike_Activities_Filters_Helper();
