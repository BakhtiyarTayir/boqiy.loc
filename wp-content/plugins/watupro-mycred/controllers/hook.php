<?php
class WatuPROCredHook extends myCRED_Hook {
	function __construct( $hook_prefs ) {
		global $wpdb;
		
		// select all quiz categories
		$cats = $wpdb->get_results("SELECT ID, name FROM {$wpdb->prefix}watupro_cats	 ORDER BY name");
		
		// watupro prefs	
		$prefs = array();
		foreach($cats as $cat) {
			$prefs['creds' . $cat->ID] = 0;
			$prefs['noquizzes' . $cat->ID] = 0;
			$prefs['log' . $cat->ID] = sprintf(__('%s for completing quizzes from category %s', 'watuprocred'), '%plural%', stripslashes($cat->name));
		}
		
		parent::__construct( array(
			'id'       => 'completed_watupro_cat',
			'defaults' => $prefs
		), $hook_prefs );
	}
	
	/**
	 * Hook into WordPress
	 */
	public function run() {
		add_action( 'watupro_completed_exam',  array( $this, 'completed_exam' ) );		
	}
	
	/**
	 * Check if the user qualifies for points
	 */
	public function completed_exam( $taking_id ) {		
		global $wpdb, $user_ID;
		// Check if user is excluded (required)
		if ( $this->core->exclude_user( $user_ID ) ) return;
		
		// get quiz cat ID. If zero (uncategorized) return
		$taking = $wpdb->get_row($wpdb->prepare("SELECT exam_id FROM ".WATUPRO_TAKEN_EXAMS."
			WHERE ID=%d", $taking_id));
			
		$cat_id = $wpdb->get_var($wpdb->prepare("SELECT cat_id FROM ".WATUPRO_EXAMS." WHERE ID=%d", $taking->exam_id));
		
		// check the points from prefs, if 0 return
		$prefs = $this->prefs;
		if(empty($prefs['creds'.$cat_id])) return false;

		if(empty($prefs['noquizzes'.$cat_id])) {
			// all quizzes from the category are required
			// Check to see if user has submitted all quizzes from the category. Else return
			$any_missing = $wpdb->get_var($wpdb->prepare("SELECT ID FROM ".WATUPRO_EXAMS." tE
				WHERE tE.cat_id=%d AND tE.ID NOT IN (
					SELECT exam_id FROM ".WATUPRO_TAKEN_EXAMS." WHERE in_progress=0 AND user_id=%d
					)", $cat_id, $user_ID));
			if($any_missing) return false;
		}			
		else {
			// specific number of quizzes from the category are required
			$num_quizzes = $wpdb->get_var($wpdb->prepare("SELECT DISTINCT(exam_id) FROM ".WATUPRO_TAKEN_EXAMS." tT
				JOIN ".WATUPRO_EXAMS." tE ON tE.ID = tT.exam_id
				WHERE tE.cat_id=%d AND tT.user_id=%d", $cat_id, $user_ID));
			$num_quizzes = sizeof($num_quizzes);
			if($num_quizzes < $prefs['noquizzes'.$cat_id]) return false;
		}

		// Make sure this is a unique event
		$hook_key = 'completed_watupro_cat_'.$cat_id;
		if ( $this->has_entry( $hook_key, '', $user_ID ) ) return;

		// Execute
		$this->core->add_creds(
			$hook_key,
			$user_ID,
			$this->prefs['creds' . $cat_id],			
			$this->prefs['log' . $cat_id]
		);
	}
	
	/**
	 * Add Settings
	 */
	 public function preferences() {
	 	global $wpdb;
		// Our settings are available under $this->prefs
		$prefs = $this->prefs;
		// select all quiz categories
		$cats = $wpdb->get_results("SELECT ID, name FROM ".WATUPRO_CATS." ORDER BY name");
		
		foreach($cats as $cat):?>
		
		<h2><?php printf(__('Category %s', 'watuprocred'), stripslashes($cat->name))?></h2>
		<p>&nbsp;</p>
		<!-- No. quizzes -->
		<label class="subheader"><?php _e('No. of completed quizzes requred', 'watuprocred')?></label>
		<ol>
			<li>
				<div class="h2"><input type="text" name="<?php echo $this->field_name( 'noquizzes' . $cat->ID ); ?>" id="<?php echo $this->field_id( 'noquizzes' . $cat->ID ); ?>" value="<?php echo empty($prefs['noquizzes'.$cat->ID]) ? 0 : intval($prefs['noquizzes'.$cat->ID]) ; ?>" size="4" /> <?php _e('(Leave blank or 0 to require all quizzes from the category)')?></div>
			</li>
		</ol>

		<!-- Set the amount -->
		<label class="subheader"><?php echo $this->core->plural(); ?></label>
		<ol>
			<li>
				<div class="h2"><input type="text" name="<?php echo $this->field_name( 'creds' . $cat->ID ); ?>" id="<?php echo $this->field_id( 'creds' . $cat->ID ); ?>" value="<?php echo esc_attr( @$prefs['creds'.$cat->ID] ); ?>" size="8" /></div>
			</li>
		</ol>
			
		<!-- Then the log template -->
		<label class="subheader"><?php _e( 'Log template', 'mycred' ); ?></label>
		<ol>
			<li>
				<div class="h2"><input type="text" name="<?php echo $this->field_name( 'log' . $cat->ID); ?>" id="<?php echo $this->field_id( 'log' . $cat->ID); ?>" value="<?php echo (empty($prefs['log' . $cat->ID]) ? sprintf(__('%s  completing quizzes from category %s', 'watuprocred'), '%plural% for ', stripslashes($cat->name)) : $prefs['log' . $cat->ID]); ?>" class="long" /></div>
			</li>
		</ol>
		<?php endforeach;?>
<?php
	}

	/**
	 * Sanitize Preferences
	 */
	public function sanitise_preferences( $data ) {
		global $wpdb;
		$new_data = $data;
		
		// select all quiz categories
		$cats = $wpdb->get_results("SELECT ID, name FROM {$wpdb->prefix}watupro_cats	 ORDER BY name");
		
		foreach($cats as $cat) {
			$new_data['creds' . $cat->ID] = ( !empty( $data['creds' . $cat->ID] ) ) ? $data['creds' . $cat->ID] : $this->defaults['creds' . $cat->ID];
			$new_data['log' . $cat->ID] = ( !empty( $data['log' . $cat->ID] ) ) ? sanitize_text_field( $data['log' . $cat->ID] ) : $this->defaults['log' . $cat->ID];
		}
		
		return $new_data;
	}
	
}