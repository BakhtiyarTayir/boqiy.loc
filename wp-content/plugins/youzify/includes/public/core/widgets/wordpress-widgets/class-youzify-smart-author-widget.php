<?php

/**
 * Smart Author Box Widget
 */

class Youzify_Smart_Author_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'youzify_smart_author_widget',
			__( 'Youzify - Smart Author', 'youzify' ),
			array( 'description' => __( 'Smart author widget', 'youzify' ) )
		);
	}

	/**
	 * Back-end widget form.
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		// Default Widget Settings
	    $defaults = array(
	        'default_user_id' => false,
	        'meta_icon' => 'at',
	        'meta_type' => 'user_login',
	        'layout' => 'youzify-author-v1',
	        'show_for_everyone' => 'on',
	        'show_cover_overlay' => false,
	        'show_cover_pattern' => false,
	        'statistics_silver_bg' => false,
	        'show_statistics_borders' => false,
	        'networks_icons_style' => 'circle',
	        'networks_icons_type'  => 'colorful'
	    );

	    // Get Widget Data.
	    $instance = wp_parse_args( (array) $instance, $defaults );

	    // Get Input's Data.
		$meta_types = youzify_get_panel_profile_fields();
		$networks_icons_types = array( 'silver' => __( 'Silver', 'youzify' ), 'colorful' => __( 'Colorful', 'youzify' ), 'transparent' => __( 'Transparent', 'youzify' ), 'no-bg' => __( 'No Background', 'youzify' ) );
		$networks_icons_styles = array( 'flat' => __( 'Flat', 'youzify' ), 'radius' => __( 'Radius', 'youzify' ), 'circle' => __( 'Circle', 'youzify' ) );

		?>

		<!-- Default User ID. -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'default_user_id' ) ); ?>"><?php esc_attr_e( 'Default User ID', 'youzify' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'default_user_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'default_user_id' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['default_user_id'] ); ?>">
		</p>

		<!-- Show Widget For Logged Out Users -->
		<p>
	        <input class="checkbox" type="checkbox" <?php checked( $instance['show_for_everyone'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_for_everyone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_for_everyone' ) ); ?>">
	        <label for="<?php echo $this->get_field_id( 'show_for_everyone' ); ?>"><?php _e( 'Show Widget For Logged Out Users', 'youzify' ); ?></label>
    	</p>

		<!-- Author Display Cover Over-->
		<p>
	        <input class="checkbox" type="checkbox" <?php checked( $instance['show_cover_overlay'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_cover_overlay' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_cover_overlay' ) ); ?>">
	        <label for="<?php echo $this->get_field_id( 'show_cover_overlay' ); ?>"><?php _e( 'Show Cover Overlay', 'youzify' ); ?></label>
    	</p>

		<!-- Author Display Cover Pattern-->
		<p>
	        <input class="checkbox" type="checkbox" <?php checked( $instance['show_cover_pattern'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_cover_pattern' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_cover_pattern' ) ); ?>">
	        <label for="<?php echo $this->get_field_id( 'show_cover_pattern' ); ?>"><?php _e( 'Show Cover Pattern', 'youzify' ); ?></label>
    	</p>

		<!-- Author Box Layout-->
	    <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_attr_e( 'Author Box Layout', 'youzify' ); ?></label>
	        <select id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" class="widefat" style="width:100%;">
	            <?php for ( $i = 1; $i <= 6; $i++ ) {?>
	            	<option <?php selected( $instance['layout'], 'youzify-author-v' . $i ); ?> value="<?php echo 'youzify-author-v' . $i; ?>"><?php echo sprintf( __( 'Layout Version %d', 'youzify' ), $i ); ?></option>
	            <?php } ?>
	        </select>
	    </p>

		<!-- Author Box Layout-->
	    <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_attr_e( 'Author Box Layout', 'youzify' ); ?></label>
	        <select id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" class="widefat" style="width:100%;">
	            <?php for ( $i = 1; $i <= 6; $i++ ) {?>
	            	<option <?php selected( $instance['layout'], 'youzify-author-v' . $i ); ?> value="<?php echo 'youzify-author-v' . $i; ?>"><?php echo sprintf( __( 'Layout Version %d', 'youzify' ), $i ); ?></option>
	            <?php } ?>
	        </select>
	    </p>

		<!-- Author Meta Icon -->
	    <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'meta_icon' ) ); ?>"><?php esc_attr_e( 'Author Meta Icon', 'youzify' ); ?></label>
			<div id="<?php echo $this->get_field_id( 'meta_icon' ); ?>" class="ukai_iconPicker" data-icons-type="web_application">
				<div class="ukai_icon_selector">
					<i class="<?php echo $instance['meta_icon']; ?>"></i>
					<span class="ukai_select_icon">
						<i class="fas fa-sort-down"></i>
					</span>
				</div>
				<input type="hidden" class="ukai-selected-icon" name="<?php echo esc_attr( $this->get_field_name( 'meta_icon' ) ); ?>" value="<?php echo $instance['meta_icon']; ?>">
			</div>
	    </p>

		<!-- Author Networks Background types-->
	    <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'networks_icons_type' ) ); ?>"><?php esc_attr_e( 'Networks Icons Type', 'youzify' ); ?></label>
	        <select id="<?php echo $this->get_field_id( 'networks_icons_type' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'networks_icons_type' ) ); ?>" class="widefat" style="width:100%;">
	            <?php foreach( $networks_icons_types as $bg_id => $by_name ) { ?>
	            	<option <?php selected( $instance['networks_icons_type'], $bg_id ); ?> value="<?php echo $bg_id; ?>"><?php echo $by_name; ?></option>
	            <?php } ?>
	        </select>
	    </p>

		<!-- Author Networks Icons Styles-->
	    <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'networks_icons_style' ) ); ?>"><?php esc_attr_e( 'Networks Icons Style', 'youzify' ); ?></label>
	        <select id="<?php echo $this->get_field_id( 'networks_icons_style' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'networks_icons_style' ) ); ?>" class="widefat" style="width:100%;">
	            <?php foreach( $networks_icons_styles as $style_id => $style_name ) { ?>
	            	<option <?php selected( $instance['networks_icons_style'], $style_id ); ?> value="<?php echo $style_id; ?>"><?php echo $style_name; ?></option>
	            <?php } ?>
	        </select>
	    </p>

		<!-- Author Display Statistics Borders-->
		<p>
	        <input class="checkbox" type="checkbox" <?php checked( $instance['show_statistics_borders'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_statistics_borders' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_statistics_borders' ) ); ?>">
	        <label for="<?php echo $this->get_field_id( 'show_statistics_borders' ); ?>"><?php _e( 'Show Statistics Borders', 'youzify' ); ?></label>
    	</p>


		<!-- Author Display Statistics Silver Background-->
		<p>
	        <input class="checkbox" type="checkbox" <?php checked( $instance['statistics_silver_bg'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'statistics_silver_bg' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'statistics_silver_bg' ) ); ?>">
	        <label for="<?php echo $this->get_field_id( 'statistics_silver_bg' ); ?>"><?php _e( 'Show Statistics Silver Background', 'youzify' ); ?></label>
    	</p>

		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();

		// Update Values.
		$instance['default_user_id'] = ( ! empty( $new_instance['default_user_id'] ) ) ? strip_tags( $new_instance['default_user_id'] ) : '1';
		$instance['layout'] = ( ! empty( $new_instance['layout'] ) ) ? strip_tags( $new_instance['layout'] ) : 'youzify-author-v1';
		$instance['meta_type'] = ( ! empty( $new_instance['meta_type'] ) ) ? strip_tags( $new_instance['meta_type'] ) : 'username';
		$instance['meta_icon'] = $new_instance['meta_icon'];
		$instance['networks_icons_style'] = ( ! empty( $new_instance['networks_icons_style'] ) ) ? strip_tags( $new_instance['networks_icons_style'] ) : 'circle';
		$instance['networks_icons_type'] = ( ! empty( $new_instance['networks_icons_type'] ) ) ? $new_instance['networks_icons_type'] : 'colorful';

		// Save Checkbox Values.
		$instance['show_for_everyone'] = $new_instance['show_for_everyone'];
		$instance['show_cover_overlay'] = $new_instance['show_cover_overlay'];
		$instance['show_cover_pattern'] = $new_instance['show_cover_pattern'];
		$instance['statistics_silver_bg'] = $new_instance['statistics_silver_bg'];
		$instance['show_statistics_borders'] = $new_instance['show_statistics_borders'];

		return $instance;
	}

	/**
	 * Login Widget Content
	 */
	public function widget( $args, $instance ) {

		// Init Vars.
		$show_for_everyone = $instance['show_for_everyone'] ? 'on' : 'off';

		// Check if Widget available for everyone ??
		if ( 'off' == $show_for_everyone && ! is_user_logged_in() ) {
			return false;
		}

		// Get Data.
		$show_cover_overlay = $instance['show_cover_overlay'] ? 'on' : 'off';
		$show_cover_pattern = $instance['show_cover_pattern'] ? 'on' : 'off';
		$statistics_silver_bg = $instance['statistics_silver_bg'] ? 'on' : 'off';
		$show_statistics_borders = $instance['show_statistics_borders'] ? 'on' : 'off';
		$meta_icon = isset( $instance['meta_icon'] ) ? $instance['meta_icon'] : 'fas fa-globe';
		$post_author = is_user_logged_in() ? get_current_user_id() : $instance['default_user_id'];

		// Display Widgets.
		echo '<div class="youzify-wp-author-widget youzify-smart-author-box-widget">';
		echo do_shortcode( "[youzify_author_box user_id='$post_author' layout='{$instance["layout"]}' meta_type='{$instance["meta_type"]}' meta_icon='{$meta_icon}' statistics_bg='$statistics_silver_bg' statistics_border='$show_statistics_borders' networks_type='{$instance["networks_icons_type"]}' networks_format='{$instance["networks_icons_style"]}' cover_overlay='$show_cover_overlay' cover_pattern='$show_cover_pattern']" );
		echo '</div>';

	}

}