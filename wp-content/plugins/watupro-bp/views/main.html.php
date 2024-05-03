<div class="wrap">
	<h1><?php _e('WatuPRO to BuddyPress Bridge', 'watuprobp')?></h1>
	
	<p><?php _e('This bridge lets you automatically make users join or leave BP groups.', 'watuprobp')?></p>
	
	<p><?php _e('This will work only for registered and logged in users.','watuprobp')?> </p>
	
	<?php if(!count($bp_groups)):?>
		<p><b><?php _e('You have not created any groups in BuddyPress yet.','watuprobp');?></b></p>
	<?php return false;
	endif;?>
	
	   
   <h2><?php _e('Add New Rule', 'watuprobp')?></h2>	  
	  
	 <form method="post" onsubmit="return validateRule(this);">
	 	<div class="wrap">
	 			<?php _e('When user completes', 'watuprobp')?> <select name="exam_id" onchange="wcChangeQuiz(this.value, 'wbbGradeSelector');">
	 			<option value=""><?php _e('- Select quiz -');?></option>
	 			<?php foreach($exams as $exam):?>
	 				<option value="<?php echo $exam->ID?>"><?php echo stripslashes($exam->name)?></option>
	 			<?php endforeach;?>
	 			</select> 
				
				<?php _e('achieving the following grade:', 'watuprobp')?>
				<span id="wbbGradeSelector">
					<select name="grade_id">
					   <option value="0"><?php _e('- Any grade -', 'watuprobp');?></option>
					   <?php foreach($exams[0]->grades as $grade):?>
					   	<option value="<?php echo $grade->ID?>"><?php echo stripslashes($grade->gtitle);?></option>
					   <?php endforeach;?>
					</select>
				</span>				
				 			
				<select name="action">
					<option value="join"><?php _e('join group:', 'watuprobp');?></option>
					<option value="leave"><?php _e('leave group:', 'watuprobp');?></option>
				</select>	 			
	 			
	 			<select name="group_id">
	 				<option value=""><?php _e('- Select group -');?></option>
	 				<?php foreach($bp_groups as $group):?>
	 					<option value="<?php echo $group->id?>"><?php echo stripslashes($group->name)?></option>
	 				<?php endforeach;?>
	 			</select>
	 			<input type="submit" name="add" value="<?php _e('Add Rule', 'watuprobp')?>">
	 	</div>
	 	<?php wp_nonce_field('watuprobp_rule');?>
	 </form> 
	 
	 <h2><?php _e('Manage Existing Rules', 'watuprobp')?></h2>
	 <?php if(count($relations)):?>
	 	<?php foreach($relations as $relation):?>
	 	<form method="post"  onsubmit="return validateRule(this);">
	 	<input type="hidden" name="id" value="<?php echo $relation->id?>">
	 	<input type="hidden" name="del" value="0">
	 	<div class="wrap">
	 			<?php _e('When user completes', 'watuprobp')?> <select name="exam_id" onchange="wcChangeQuiz(this.value, 'wbbGradeSelector');">
	 			<option value=""><?php _e('- Select quiz -');?></option>
	 			<?php foreach($exams as $exam):?>
	 				<option value="<?php echo $exam->ID?>" <?php if($exam->ID == $relation->exam_id) echo 'selected'?>><?php echo stripslashes($exam->name)?></option>
	 			<?php endforeach;?>
	 			</select> 
				
				<?php _e('achieving the following grade:', 'watuprobp')?>
				<span id="wbbGradeSelector">
					<select name="grade_id">
					   <option value="0"><?php _e('- Any grade -', 'watuprobp');?></option>
					   <?php foreach($exams[0]->grades as $grade):?>
					   	<option value="<?php echo $grade->ID?>" <?php if($grade->ID == $relation->grade_id) echo 'selected'?>><?php echo stripslashes($grade->gtitle);?></option>
					   <?php endforeach;?>
					</select>
				</span>				
				 			
				<select name="action">
					<option value="join" <?php if('join' == $relation->action) echo 'selected'?>><?php _e('join group:', 'watuprobp');?></option>
					<option value="leave" <?php if('leave' == $relation->action) echo 'selected'?>><?php _e('leave group:', 'watuprobp');?></option>
				</select>	 			
	 			
	 			<select name="group_id">
	 				<option value=""><?php _e('- Select group -');?></option>
	 				<?php foreach($bp_groups as $group):?>
	 					<option value="<?php echo $group->id?>" <?php if($group->id == $relation->bp_group_id) echo 'selected'?>><?php echo stripslashes($group->name)?></option>
	 				<?php endforeach;?>
	 			</select>
	 			<input type="submit" name="save" value="<?php _e('Save Rule', 'watuprobp')?>">
	 			<input type="button" value="<?php _e('Delete Rule', 'watuprobp')?>" onclick="WCConfirmDelete(this.form);">
	 	</div>
	 	<?php wp_nonce_field('watuprobp_rule');?>
	 </form> 
	 	<?php endforeach;?>
	 <?php else:?>
	 <p><?php _e('You have not created any rules yet.', 'watuprobp');?></p>	
	 <?php endif;?>
</div>

<script type="text/javascript" >
function validateRule(frm) {
	if(frm.exam_id.value == '') {
		alert("<?php _e('Please select quiz', 'watuprobp');?>");
		frm.exam_id.focus();
		return false;
	}
	
	if(frm.group_id.value == '') {
		alert("<?php _e('Please select group', 'watuprobp');?>");
		frm.group_id.focus();
		return false;
	}
	
	return true;
}

function WCConfirmDelete(frm) {
		if(confirm("<?php _e('Are you sure?', 'watuprobp')?>")) {
			frm.del.value=1;
			frm.submit();
		}
}

function wcChangeQuiz(quizID, selectorID) {
	// array containing all grades by exams
	var grades = {<?php foreach($exams as $exam): echo $exam->ID.' : {';
			foreach($exam->grades as $grade):
				echo $grade->ID .' : "'.$grade->gtitle.'",';
			endforeach;
		echo '},';
	endforeach;?>};
	
	// construct the new HTML
	var newHTML = '<select name="grade_id">';
	newHTML += "<option value='0'><?php _e('- Any grade -', 'watuprobp');?></option>";
	jQuery.each(grades, function(i, obj){
		if(i == quizID) {
			jQuery.each(obj, function(j, grade) {
				newHTML += "<option value=" + j + ">" + grade + "</option>\n";
			}); // end each grade
		}
	});
	newHTML += '</select>'; 
	
	jQuery('#'+selectorID).html(newHTML);
}
</script>