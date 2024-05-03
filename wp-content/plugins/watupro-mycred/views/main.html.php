<div class="wrap">
	<h1><?php _e('WatuPRO to MyCred Bridge', 'watupromycred')?></h1>
	
	<p><?php _e('This bridge lets you transfer the points user has earned for completing a quiz to their MyCred points balance.', 'watupromycred')?></p>
	
	<p><?php printf(__('You can also reward points for completing whole quiz category. These settings are available at your <a href="%s">MyCRED Hooks</a> page.', 'watuprocred'), 'admin.php?page=myCRED_page_hooks')?></p>
	
	<form method="post">
		<p><label>Select MyCred Points Type:</label> <select name="points_type">			
			<?php foreach($point_types as $key=>$type):?>
				<option value="<?php echo $key?>"<?php if($key == $selected_type) echo ' selected'?>><?php echo $type?></option>
			<?php endforeach;?>
		</select></p>
		
		<p><input type="checkbox" name="transfer_positive" value="1" <?php if(get_option('watuprocred_transfer_positive')) echo 'checked'?>> Transfer positive points</p>
		<p><input type="checkbox" name="transfer_negative" value="1" <?php if(get_option('watuprocred_transfer_negative')) echo 'checked'?>> Transfer negative points</p>
		
		<p align="center"><input type="submit" name="ok" value="Save Settings">	</p>
	</form>
</div>	