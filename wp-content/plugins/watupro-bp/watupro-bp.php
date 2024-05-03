<?php
/*
Plugin Name: WatuPRO to BuddyPress Bridge 
Plugin URI: 
Description: Connect quizzes to BuddyPress groups: users join or leave groups based on quiz results.
Author: Kiboko Labs
Version: 0.4.5
Author URI: http://calendarscripts.info/
License: GPLv2 or later
Text-domain: watuprobp
*/

define( 'WATUPROBP_PATH', dirname( __FILE__ ) );
define( 'WATUPROBP_RELATIVE_PATH', dirname( plugin_basename( __FILE__ )));
define( 'WATUPROBP_URL', plugin_dir_url( __FILE__ ));

// require controllers and models
require_once(WATUPROBP_PATH.'/models/basic.php');
require_once(WATUPROBP_PATH.'/controllers/bridge.php');

add_action('init', array("WatuPROBP", "init"));

register_activation_hook(__FILE__, array("WatuPROBP", "install"));
add_action('watupro_admin_menu', array("WatuPROBP", "menu"));