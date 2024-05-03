<?php
class WatuPROBPBridge {
   static function main() {
   	  global $wpdb;
   	 
   	  // select exams
   	  $exams = $wpdb->get_results("SELECT * FROM ".WATUPRO_EXAMS." ORDER BY name");
   	  
   	  // add/edit/delete relation
   	  if(!empty($_POST['add']) and check_admin_referer('watuprobp_rule')) {
				// no duplicates		
				$exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM ".WATUPROBP_RELATIONS."
					WHERE exam_id=%d AND bp_group_id=%d AND grade_id=%d AND action=%s", 
					intval($_POST['exam_id']), intval($_POST['group_id']), intval($_POST['grade_id']), sanitize_text_field($_POST['action'])));   	  	
   	  	
   	  	if(!$exists) {
					$wpdb->query($wpdb->prepare("INSERT INTO ".WATUPROBP_RELATIONS." SET 
						exam_id = %d, bp_group_id=%s, grade_id=%d, action=%s", 
						intval($_POST['exam_id']), intval($_POST['group_id']), intval($_POST['grade_id']), sanitize_text_field($_POST['action'])));
					}   	  
   	  }
   
   		if(!empty($_POST['save']) and check_admin_referer('watuprobp_rule')) {
				$wpdb->query($wpdb->prepare("UPDATE ".WATUPROBP_RELATIONS." SET 
					exam_id = %d, bp_group_id=%s, grade_id=%d, action=%s WHERE id=%d", 
					intval($_POST['exam_id']), intval($_POST['group_id']), intval($_POST['grade_id']), sanitize_text_field($_POST['action']), intval($_POST['id'])));   	  
   	  }
   	  
			if(!empty($_POST['del']) and check_admin_referer('watuprobp_rule')) {
				$wpdb->query($wpdb->prepare("DELETE FROM ".WATUPROBP_RELATIONS." WHERE id=%d", intval($_POST['id'])));
			}   	  
   	  
   	  // select existing relations
   	  $relations = $wpdb->get_results("SELECT * FROM ".WATUPROBP_RELATIONS." ORDER BY id");
   	  
   	  // select all non-category grades and match them to exams and relations
   	  $grades = $wpdb->get_results("SELECT * FROM ".WATUPRO_GRADES." WHERE cat_id=0 ORDER BY gtitle");
   	  
   	  foreach($exams as $cnt=>$exam) {
   	  	  $exam_grades = array();
   	  	  foreach($grades as $grade) {
   	  	  	if($grade->exam_id == $exam->ID) $exam_grades[] = $grade;
			  }
			  
			  $exams[$cnt]->grades = $exam_grades;
   	  }
   	  
   	  foreach($relations as $cnt=>$relation) {
   	  	  $rel_grades = array();
   	  	  foreach($grades as $grade) {
   	  	  	if($grade->exam_id == $relation->exam_id) $rel_grades[] = $grade;
			  }
			  
			  $relations[$cnt]->grades = $rel_grades;
   	  }
   	     	  
   	     	  
   	 // get BP groups
   	 if(function_exists('bp_is_active') and bp_is_active( 'groups' )) {
				// select BP groups
				$bp_groups = BP_Groups_Group::get(array(
									'type'=>'alphabetical',
									'per_page' => 999
									));
				$bp_groups = $bp_groups['groups'];
		}			
	    	     	  
		 include(WATUPROBP_PATH."/views/main.html.php");
   }
   
   // exam settings page
   static function exam_settings($quiz_id = 0) {
   	global $wpdb;
   	
   	$allowed_groups = get_option('watuprobp_allowed_groups');
   	if(isset($allowed_groups[$quiz_id])) $quiz_groups = $allowed_groups[$quiz_id];
   	else $quiz_groups = array();
   	
   	 // get BP groups
   	 if(function_exists('bp_is_active') and bp_is_active( 'groups' )) {
				// select BP groups
				$bp_groups = BP_Groups_Group::get(array(
									'type'=>'alphabetical',
									'per_page' => 999
									));
				$bp_groups = $bp_groups['groups'];
		}		
		else return '';	
		
		include(WATUPROBP_PATH."/views/exam-settings.html.php");
   } // end exam_settings
   
   // saved quiz
   static function exam_saved($quiz_id) {
   	global $wpdb;
   	
   	// save associated BP groups into the grand array
   	$allowed_groups = get_option('watuprobp_allowed_groups');
   	$quiz_groups = empty($_POST['watuprobp_allowed_groups']) ? array() : watupro_int_array($_POST['watuprobp_allowed_groups']);
   	$allowed_groups[$quiz_id] = $quiz_groups;
   	update_option('watuprobp_allowed_groups', $allowed_groups);
   }
   
   // can access quiz?
   static function can_access($access, $quiz_id) {
   	global $user_ID;
		
		// in case user is NOT logged in, normally WatuPRO would ensure the requirement for logged in user is met.
		// so in case the quiz is saved without login requirement but selected groups remained, we should always return true;
		// same about admin
		if(!is_user_logged_in() or current_user_can(WATUPRO_MANAGE_CAPS)) return true;   	
   	
   	$allowed_groups = get_option('watuprobp_allowed_groups');
   	
   	// if no groups for this quiz, just return true
   	if(empty($allowed_groups[$quiz_id]) or !is_array($allowed_groups[$quiz_id])) return true;
   	
   	// if there are groups, the user must be a member of at least one of them
   	foreach($allowed_groups[$quiz_id] as $group) {
   		if(groups_is_user_member( $user_ID, $group )) return true;
   	}
   	
   	// if we are here, means no access
   	printf(__('You need to be a member of selected user groups to access this %s.','watuprobp'), WATUPRO_QUIZ_WORD);
   	WatuPRO::$output_sent = true;
   	return false;
   } // end can_access

	 // actually join or leave the group
	 static function complete_exam($taking_id) {
	 	  global $wpdb;
	 	  
	 	  if(!function_exists('bp_is_active') or !bp_is_active( 'groups' )) return false;

	 	  // select taking		
	 	  $taking = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".WATUPRO_TAKEN_EXAMS." 	
	 	  	WHERE ID=%d", $taking_id));
	 	 
	 	  // if user ID not available, return false
			if(empty($taking->user_id)) return false;
			
	 	  // see if there are any relations for this exam ID
	 	  $relations = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".WATUPROBP_RELATIONS." 
		 	  WHERE exam_id=%d", $taking->exam_id));
		 	  
		 	if(!count($relations)) return false;  
	
	   	// select mailing lists from getresponse
	   	foreach($relations as $relation) {
			   // check grade
				if(!empty($relation->grade_id) and $relation->grade_id != $taking->grade_id) continue;
				
			   // join or leave NYI
			   if($relation->action == 'join') groups_join_group( $relation->bp_group_id, $taking->user_id);
			   else groups_leave_group( $relation->bp_group_id, $taking->user_id);
				
			} // end foreach relation	
   } // end complete exam
   
   // check for free access based on BP group
   static function free_access($advanced_settings) {
   	global $wpdb;
   	$user_id = get_current_user_id();
   	if(empty($advanced_settings['free_access_bp_groups'])) return false;
   	
   	// check if user has any of the free access groups
		// NYI $user_groups = get_user_meta($user_ID, "watupro_groups", true);
		$user_groups = groups_get_user_groups($user_id);		
		$user_groups = $user_groups['groups'];
		if(!is_array($user_groups)) $user_groups = array($user_groups);
		
		foreach($user_groups as $group) {
			if(in_array( $group, $advanced_settings['free_access_bp_groups'])) return true;
		}
		
		return false;
   } // end free access
   
   // display free access options
   static function free_access_options($advanced_settings) {
   	// select all BP groups
   	if(function_exists('bp_is_active') and bp_is_active( 'groups' )) {
				// select BP groups
				$bp_groups = BP_Groups_Group::get(array(
									'type'=>'alphabetical',
									'per_page' => 999
									));
				$bp_groups = $bp_groups['groups'];
		}			
		
		?>
		<p><?php _e('Access remains free to the following BuddyPress groups:', 'watuprobp');
		if(!empty($bp_groups) and count($bp_groups)):
		foreach($bp_groups as $group):?>
				<span style="white-space:none;"><input type="checkbox" name="free_access_bp_groups[]" value="<?php echo $group->id?>" <?php if(@in_array($group->id, @$advanced_settings['free_access_bp_groups'])) echo 'checked'?>> <?php echo stripslashes($group->name)?></span>
			<?php endforeach; 
			else: _e('You have not created any BuddyPress groups yet.', 'watuprobp');
			endif;?></p>
		<?php		
   } // end free access options
}