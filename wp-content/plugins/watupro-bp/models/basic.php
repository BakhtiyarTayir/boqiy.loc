<?php
// main model containing general config and UI functions
class WatuPROBP {
   static function install() {
   	global $wpdb;	
   	$wpdb -> show_errors();
   	
   	self::init();
	   
    // relations bewteen completed exams and mailing lists. 
    // For now not depending on exam result but place the field for later use
    if($wpdb->get_var("SHOW TABLES LIKE '".WATUPROBP_RELATIONS."'") != WATUPROBP_RELATIONS) {  
        $sql = "CREATE TABLE `".WATUPROBP_RELATIONS."` (
				id int(11) unsigned NOT NULL auto_increment PRIMARY KEY,
				exam_id int(11) unsigned NOT NULL default '0',
				grade_id int(11) unsigned NOT NULL default '0',
				bp_group_id int(11) unsigned NOT NULL default '0',
				action VARCHAR(100) NOT NULL DEFAULT 'join' /* join or leave */
			) CHARACTER SET utf8;";
        $wpdb->query($sql);         
    	}
	}	   
   
   // main menu
   static function menu() {
   	add_submenu_page('watupro_exams', __('Bridge to BuddyPress', 'watuprobp'), __('Bridge to BuddyPress', 'watuprobp'), 'manage_options', 
   		'watuprobp', array('WatuPROBPBridge','main'));	
	}
	
	// CSS and JS
	static function scripts() {   
   	wp_enqueue_script('jquery');
	}
	
	// initialization
	static function init() {
		global $wpdb;
		load_plugin_textdomain( 'watuprobp' );
		define('WATUPROBP_RELATIONS', $wpdb->prefix.'watuprobp_relations');
		
		add_action('watupro_completed_exam', array('WatuPROBPBridge', 'complete_exam'));
		add_action('watupro-user-email-settings', array('WatuPROBPBridge', 'exam_settings'));
		add_action('watupro_exam_saved', array('WatuPROBPBridge', 'exam_saved'));
		
		add_filter('watupro-access-exam', array('WatuPROBPBridge', 'can_access'), 10, 2);
	}	
}