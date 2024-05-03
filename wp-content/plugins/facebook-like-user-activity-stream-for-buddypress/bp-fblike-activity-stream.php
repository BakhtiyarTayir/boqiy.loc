<?php
/**
 * Plugin Name: Facebook Like User Activity Stream For BuddyPress
 * Author: Brajesh Singh
 * Author URI: https://buddydev.com/members/sbrajesh/
 * Plugin URI: https://buddydev.com/plugins/facebook-user-like-activity-stream-for-bddypress/
 * Version: 1.2.6
 * Description: It shows relevant social stream of a user(includes friends stream as well as users/user groups)
 * License: GPL
*/

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Helper class
 */
class BPFBLike_Activity_Helper {

	/**
	 * Singleton instance.
	 *
	 * @var BPFBLike_Activity_Helper
	 */
	private static $instance;

	/**
	 * Plugin directory absolute path
	 *
	 * @var string
	 */
	private $path;

	/**
	 * BD_FBLike_Activity_Helper constructor.
	 */
	private function __construct() {

		$this->path = plugin_dir_path( __FILE__ );

		add_action( 'bp_include', array( $this, 'load' ) );
		add_action( 'plugins_loaded', array( $this, 'load_admin_files' ), 9996 ); // pt-settings 1.0.4.
		add_action( 'bp_loaded', array( $this, 'load_textdomain' ), 2 );
	}

	/**
	 * Get Singleton Instance.
	 *
	 * @return BPFBLike_Activity_Helper
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Load files.
	 */
	public function load() {

		if ( ! bp_is_active( 'activity' ) ) {
			return;
		}

		// if we are here, we may want to check fro friends/followers?
		if ( ! defined( 'MYSTREAM_ACTIVITY_SLUG' ) ) {
			define( 'MYSTREAM_ACTIVITY_SLUG', 'my-stream-activity' );
		}

		require_once $this->path . 'core/bpfbl-functions.php';
		require_once $this->path . 'core/bpfbl-screen.php';
		require_once $this->path . 'core/bpfbl-hooks.php';
		require_once $this->path . 'core/bpfbl-activity-query-2.php';
	}

	/**
	 * Load admin files
	 */
	public function load_admin_files() {

		if ( ! function_exists( 'buddypress' ) || ! bp_is_active( 'activity' ) ) {
			return;
		}

		require_once $this->path . 'admin/pt-settings/pt-settings-loader.php';
		require_once $this->path . 'admin/bpfbl-admin-settings.php';
	}

	/**
	 * Load translation files
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'facebook-like-user-activity-stream-for-buddypress', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
}
// init.
BPFBLike_Activity_Helper::get_instance();


