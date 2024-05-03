<?php
// main model containing general config and UI functions
class WatuPROCred {
   static function install() {
   	global $wpdb;	
   	$wpdb -> show_errors();
   	
   	self::init();
	}	   
   
   // main menu
   static function menu() {
   	add_submenu_page('watupro_exams', __('Bridge to MyCred', 'watupromycred'), __('Bridge to MyCred', 'watupromycred'), 'manage_options', 
   		'watuprocred', array('WatuPROCredBridge','main'));	
	}
	
	// CSS and JS
	static function scripts() {   
   	wp_enqueue_script('jquery');
	}
	
	// initialization
	static function init() {
		global $wpdb;
		load_plugin_textdomain( 'watupromycred' );
		
		add_action('watupro_completed_exam', array('WatuPROCredBridge', 'complete_exam'));
		
		// add custom hook
		add_filter( 'mycred_setup_hooks', array(__CLASS__, 'hook') );
		
		// Add support for badges
		add_filter('mycred_all_references', array('WatuPROCredBridge', 'add_reference'));
	}	
	
	// add out custom hook
	static function hook($installed) {
		$installed['completed_watupro_cat'] = array(
			'title'       => __( 'Completed WatuPRO Quiz Category', 'watuprocred' ),
			'description' => __( 'Completed quizzes from a category in WatuPRO', 'watuprocred' ),
			'callback'    => array( 'WatuPROCredHook' )
		);
		return $installed;
	}
}