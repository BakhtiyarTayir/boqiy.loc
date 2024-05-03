<?php
/**
 * Admin settings class
 *
 * @package fb-like-user-activity-stream
 */

use \Press_Themes\PT_Settings\Page;

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Class BD_FBLike_Admin_Settings
 */
class BPFBLike_Admin_Settings {

	/**
	 * What menu slug we will need
	 *
	 * @var string
	 */
	private $menu_slug;

	/**
	 * Used to keep a reference of the Page, It will be used in rendering the view.
	 *
	 * @var \Press_Themes\PT_Settings\Page
	 */
	private $page;

	/**
	 * Branded_Login_Admin constructor.
	 */
	public function __construct() {

		$this->menu_slug = 'bpfbl-settings';

		// Only load when inside the admin and not doing ajax ?
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			add_action( 'admin_init', array( $this, 'init' ) );
			add_action( 'admin_menu', array( $this, 'add_menu' ) );
		}
	}


	/**
	 * Add Menu
	 */
	public function add_menu() {

		$hook = add_options_page(
			_x( 'Facebook Like Activity Settings', 'Admin settings page title', 'facebook-like-user-activity-stream-for-buddypress' ),
			_x( 'Facebook Like Activity Settings', 'Admin settings menu label', 'facebook-like-user-activity-stream-for-buddypress' ),
			'manage_options',
			$this->menu_slug,
			array( $this, 'render' )
		);
	}

	/**
	 * Show/render the setting page
	 */
	public function render() {
		$this->page->render();
	}

	/**
	 * Is it the setting page?
	 *
	 * @return bool
	 */
	private function needs_loading() {

		global $pagenow;

		// We need to load on options.php otherwise settings won't be reistered.
		if ( 'options.php' === $pagenow ) {
			return true;
		}

		if ( isset( $_GET['page'] ) && $_GET['page'] === $this->menu_slug ) {
			return true;
		}

		return false;
	}

	/**
	 * Initialize the admin settings panel and fields
	 */
	public function init() {

		if ( ! $this->needs_loading() ) {
			return;
		}

		$page = new Page( 'bpfblike-settings' );

		$panel = $page->add_panel( 'settings', _x( 'Settings', 'Admin settings panel title', 'facebook-like-user-activity-stream-for-buddypress' ) );

		$section = $panel->add_section( 'settings', _x( 'Settings', 'Admin settings section title', 'facebook-like-user-activity-stream-for-buddypress' ) );

		$section->add_field( array(
			'name'    => 'enabled_for',
			'label'   => _x( 'Enable for', 'Admin settings', 'facebook-like-user-activity-stream-for-buddypress' ),
			'type'    => 'multicheck',
			'options' => array(
				'dir'     => __( 'Activity directory', 'facebook-like-user-activity-stream-for-buddypress' ),
				'profile' => __( 'User profile', 'facebook-like-user-activity-stream-for-buddypress' ),
			),
			'default' => array( 'dir' => 'dir', 'profile' => 'profile' ),
		) );

		$section->add_field( array(
			'name'    => 'user_stream_slug',
			'label'   => _x( 'Slug for user profile stream', 'Admin settings', 'facebook-like-user-activity-stream-for-buddypress' ),
			'type'    => 'text',
			'default' => MYSTREAM_ACTIVITY_SLUG,
		) );

		$section->add_field( array(
			'name'    => 'user_stream_label',
			'label'   => _x( 'Label for profile stream tab', 'Admin settings', 'facebook-like-user-activity-stream-for-buddypress' ),
			'type'    => 'text',
			'default' => __( 'Your Stream', 'facebook-like-user-activity-stream-for-buddypress' ),
		) );


		// Save page for future reference.
		$this->page = $page;

		do_action( 'bpfblike_settings_register', $page );

		// allow enabling options.
		$page->init();
	}
}

new BPFBLike_Admin_Settings();
