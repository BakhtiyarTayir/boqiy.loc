<?php
class WatuPROCredBridge {
   static function main() {
   	global $wpdb;
   	  
   	if(!empty($_POST['ok'])) {
   	  // save settings
   	  update_option('watuprocred_points_type', $_POST['points_type']);
   	  update_option('watuprocred_transfer_positive', @$_POST['transfer_positive']);
   	  update_option('watuprocred_transfer_negative', @$_POST['transfer_negative']);
   	}
   	 	   	     
   	$point_types = get_option('mycred_types'); 	   
   	$selected_type = get_option('watuprocred_points_type');	     		  
   	include(WATUPROCRED_PATH."/views/main.html.php");
   }

	 // transfer the points
	 static function complete_exam($taking_id) {
	 	global $wpdb, $user_ID;
	 	
	 	if(empty($user_ID)) return false;
	 	
	 	// select taking
	 	$taking = $wpdb->get_row($wpdb->prepare("SELECT points, exam_id FROM ".
		 	WATUPRO_TAKEN_EXAMS." WHERE ID=%d", $taking_id));
		 	
		$quiz_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM ".WATUPRO_EXAMS." WHERE ID=%d", $taking->exam_id));	
		 	
		if($taking->points == 0) return false;
		if($taking->points < 0 ) {
			$transfer_negative = get_option('watuprocred_transfer_negative');
			if(!$transfer_negative) return false;
		}
		
		if($taking->points > 0 ) {
			$transfer_positive = get_option('watuprocred_transfer_positive');
			if(!$transfer_positive) return false;
		}
	 	  
	 	// make sure mycred functions exist
	 	if ( function_exists( 'mycred' ) ) :
	 		$selected_type = get_option('watuprocred_points_type');
	 		
			// Load myCRED
			$mycred = mycred( $selected_type );

			// First make sure the user is not set to be excluded from 
			// using myCRED
			if ( $mycred->exclude_user( $user_ID ) ) return;	 	
	 		   
			// award / deudct
			$mycred->add_creds(
				'wautpro_quiz', // Unique reference that identifies your plugin
				$user_ID,
				$taking->points,
				sprintf(__('Points for completing quiz "%s"', 'watuprocred'),  stripslashes($quiz_name)),
				$taking_id, // Unique refence ID
				'',
				$selected_type
			);
		endif;	
   } // end complete exam
   
     // add reference for myCRED Badges support
   static function add_reference( $references ) {
      // The reference must be the same reference that we award points under.
      $references['wautpro_quiz'] = __( 'Quiz Completion', 'watupromycred' );
      return $references;
   } // end add reference
}