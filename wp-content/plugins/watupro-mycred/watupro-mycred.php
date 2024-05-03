<?php
/*
Plugin Name: WatuPRO to MyCRED Bridge 
Plugin URI: 
Description: When quiz is completed, add or subsctract the achieved points from user's mycred balance
Author: Kiboko Labs
Version: 0.9
Author URI: http://calendarscripts.info/
License: GPLv2 or later
*/

define( 'WATUPROCRED_PATH', dirname( __FILE__ ) );
define( 'WATUPROCRED_RELATIVE_PATH', dirname( plugin_basename( __FILE__ )));
define( 'WATUPROCRED_URL', plugin_dir_url( __FILE__ ));

// require controllers and models
require_once(WATUPROCRED_PATH.'/models/basic.php');
require_once(WATUPROCRED_PATH.'/controllers/bridge.php');
if(class_exists('myCRED_Hook')) {
	require_once(WATUPROCRED_PATH.'/controllers/hook.php');
}

add_action('init', array("WatuPROCred", "init"));

register_activation_hook(__FILE__, array("WatuPROCred", "install"));
add_action('watupro_admin_menu', array("WatuPROCred", "menu"));