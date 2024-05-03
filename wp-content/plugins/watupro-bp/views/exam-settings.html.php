 <fieldset>
  		<legend><b><?php _e('BuddyPress Integration', 'watuprobp')?></b></legend>
  		
  		<p><?php printf(__('This %s will be accessible only to members of the following BP groups:', 'watuprobp'), WATUPRO_QUIZ_WORD);?> &nbsp;
  		<?php foreach($bp_groups as $group):?>
  			<span style="white-space: nowrap;"><input type="checkbox" name="watuprobp_allowed_groups[]" value="<?php echo $group->id?>" <?php if(!empty($quiz_groups) and in_array($group->id, $quiz_groups)) echo 'checked'?>> <?php echo stripslashes($group->name);?></span>
  		<?php endforeach;?></p>
  		<p><?php _e('Note that this limitation will not affect WatuPRO administrators.', 'watuprobp');?></p>
</fieldset>