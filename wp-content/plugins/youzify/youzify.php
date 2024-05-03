<?php
/**
 * Plugin Name: Youzify
 * Plugin URI:  https://youzify.com
 * Description: Youzify is a WordPress Community, Social Network and User Profiles management solution with a Secure Membership System, Front-end Account Settings, Powerful Admin Panel, Many Header Styles, +20 Profile Widgets, 16 Color Schemes, Advanced Author Widgets, Fully Responsive Design, Extremely Customizable and a Bunch of Unlimited Features provided by KaineLabs.
 * Version:     3.0.8
 * Author:      Youssef Kaine
 * Author URI:  https://www.kainelabs.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: youzify
 * Domain Path: /languages/
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Version.
define( 'YOUZIFY_VERSION', '3.0.8' );

// Youzify Basename
define( 'YOUZIFY_BASENAME', plugin_basename( __FILE__ ) );

// Youzify Path.
define( 'YOUZIFY_PATH', plugin_dir_path( __FILE__ ) );

// Youzify Url Path.
define( 'YOUZIFY_URL', plugin_dir_url( __FILE__ ) );

if ( ! class_exists( 'BuddyPress' ) ) {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'Youzify requires BuddyPress to be installed and active. You can download %s here.', 'youzify' ), '<a href="https://wordpress.org/plugins/buddypress/" target="_blank">BuddyPress</a>' ) . '</strong></p></div>';
    } );
    return;
}

// Add Legacy Theme Support.
add_theme_support( 'buddypress-use-legacy' );

// Include Youzify Class.
require YOUZIFY_PATH . 'class-youzify.php';

// Include Youzify Premium Class.
require YOUZIFY_PATH . 'includes/premium/class-youzify-pro.php';

do_action( 'before_youzify_init' );

// Set Globals.
$GLOBALS['Youzify'] = youzify();

do_action( 'after_youzify_init' );

/**
 * The main function responsible for returning the one true Youzify Instance to functions everywhere.
 */
function youzify() {
    return Youzify::instance();
}

/*
 * Youzify Activation Hook.
 */
function youzify_activated_hook() {

    // Include Setup File.
    require_once YOUZIFY_PATH . '/includes/public/core/class-youzify-setup.php';

    // Init Setup Class.
    $Setup = new Youzify_Setup();

    // Install Youzify Options
    $Setup->install_options();

    // Install New Version Options.
    $Setup->install_new_version_options();

    // Build Database.
    $Setup->build_database_tables();

    // Install Pages
    $Setup->install_pages();

    // Install Reset Password E-mail.
    $Setup->register_bp_reset_password_email();

    // Add Rewrite Rule.
    add_rewrite_rule( '^yz-auth/([^/]+)/([^/]+)/?', 'index.php?yz-authentication=$matches[1]&yz-provider=$matches[2]','top' );

    // CHANGE THIS LATER
    add_rewrite_rule( '^youzify-auth/([^/]+)/([^/]+)/?', 'index.php?youzify-authentication=$matches[1]&youzify-provider=$matches[2]','top' );

    // Flush Rewrite Rules.
    flush_rewrite_rules();

    do_action( 'youzify_activated' );

}

register_activation_hook( __FILE__, 'youzify_activated_hook' );

/**
 * On Youzify Deactivation.
 */
function youzify_deactivation() {

    // Delete Youzify Crons.
    $timestamp = wp_next_scheduled( 'youzify_delete_media_temporary_files' );
    wp_unschedule_event( $timestamp, 'youzify_delete_media_temporary_files' );

    // Flush Rewrite Rules.
    flush_rewrite_rules();

}

register_deactivation_hook( __FILE__, 'youzify_deactivation' );