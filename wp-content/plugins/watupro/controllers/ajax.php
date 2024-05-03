<?php
function watupro_ajax() {
	global $wpdb;
	
	switch($_POST['do']) {
		case 'mark_review':
			// mark question for review
			WatuPROQuestions :: mark_review();
		break;
		
		case 'select_grades':
			// select grades for a given quiz, return drop-down HTML
			if(!empty($_POST['exam_id'])) {
				$exam = $wpdb->get_row($wpdb->prepare("SELECT ID, reuse_default_grades, grades_by_percent FROM ".WATUPRO_EXAMS." WHERE ID=%d", intval(@$_POST['exam_id'])));
			}
			
			$html = '<option value="">------</option>';
			if(empty($_POST['exam_id'])) die($html); // when no exam, return only the main option
			
			//print_r($exam);
			$grades = WTPGrade :: get_grades($exam);
			
			foreach($grades as $grade) {
				$html .= '<option value="'.$grade->ID.'">'.stripslashes($grade->gtitle).'</option>'."\n";
			}
			
			echo $html;
		break;
		
		// check if this email can take the quiz more times
		case 'takings_by_email':
			$num_taken = $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) FROM ".WATUPRO_TAKEN_EXAMS."
				WHERE exam_id=%d AND email=%s AND in_progress=0", $_POST['exam_id'], $_POST['email']));
				
			if($_POST['allowed_attempts'] <= $num_taken) {
				echo 'ERROR|WATUPRO|';
				printf(__("Sorry, you can take this quiz only %d times.", 'watupro'), $_POST['allowed_attempts']);
			}	
		break;
		
		// calls Intelligence module to filter quizzes
		case 'select_reuse_quizzes':
			echo WatuPROIQuestion :: select_reuse_quizzes();
		break;
		
		case 'reorder_questions':
			WTPQuestion :: reorder_sortable($_POST['exam_id'], $_POST['questions']);
		break;
		
		// return drop-down of question categories available in a quiz
		case 'select_quiz_qcats':
			if(!empty($_POST['quiz_id'])) { 
				$exam = $wpdb->get_row($wpdb->prepare("SELECT ID, reuse_questions_from FROM ".WATUPRO_EXAMS." WHERE ID=%d", intval($_POST['quiz_id'])));				
				
				$q_exam_id = (watupro_intel() and $exam->reuse_questions_from) ? $exam->reuse_questions_from : $exam->ID;
					
				$qcats = $wpdb->get_results($wpdb->prepare("SELECT tC.* FROM " . WATUPRO_QCATS. " tC
						WHERE tC.ID IN (SELECT cat_id FROM ".WATUPRO_QUESTIONS." WHERE exam_id=%d) ", $q_exam_id));
						
				echo $wpdb->prepare("SELECT tC.* FROM " . WATUPRO_QCATS. " tC
						WHERE tC.ID IN (SELECT cat_id FROM ".WATUPRO_QUESTIONS." WHERE exam_id=%d) ", $q_exam_id);
						
				foreach($qcats as $qcat):?>
					<option value="<?php echo $qcat->ID?>"><?php echo stripslashes($qcat->name);?></option>
				<?php endforeach; 		
			}
		break;
	}
	exit;
}