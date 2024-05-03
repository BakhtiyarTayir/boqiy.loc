<?php
if ( ! defined( 'BP_CHARGES_VERSION' ) ) exit;

/**
 * BP Charges Module
 * @version 1.0
 */
if ( ! class_exists( 'myCRED_BuddyPress_Charges' ) ) :
	class myCRED_BuddyPress_Charges extends myCRED_Module {

		/**
		 * Construct
		 */
		function __construct( $type = MYCRED_DEFAULT_TYPE_KEY ) {

			parent::__construct( 'myCRED_BuddyPress_Charge', array(
				'module_name' => 'bp_charges',
				'option_id'   => 'mycred_pref_buddypress_charges',
				'defaults'    => array(
					'installed'    => array(),
					'active'       => array(),
					'charge_prefs' => array()
				),
				'labels'      => array(
					'menu'        => __( 'BuddyPress Charges', 'bp_charge' ),
					'page_title'  => __( 'BuddyPress Charges', 'bp_charge' ),
					'page_header' => __( 'BuddyPress Charges', 'bp_charge' )
				),
				'screen_id'   => 'myCRED_page_bp_charges',
				'accordion'   => true,
				'menu_pos'    => 30
			), $type );

		}

		/**
		 * Load Addon
		 * @since 1.0
		 * @version 1.0
		 */
		public function load() {

			add_action( 'mycred_add_menu',    array( $this, 'add_menu' ), $this->menu_pos );
			add_action( 'mycred_admin_init',  array( $this, 'set_entries_per_page' ) );
			add_action( 'mycred_admin_init',  array( $this, 'register_settings' ) );

			if ( ! empty( $this->installed ) ) {
				foreach ( $this->installed as $key => $gdata ) {
					if ( $this->is_active( $key ) && isset( $gdata['callback'] ) ) {
						$this->call( 'run', $gdata['callback'] );
					}
				}
			}

		}

		/**
		 * Call
		 * Either runs a given class method or function.
		 * @since 1.0
		 * @version 1.0
		 */
		public function call( $call, $callback, $return = NULL ) {

			// Class
			if ( is_array( $callback ) && class_exists( $callback[0] ) ) {
				$class = $callback[0];
				$methods = get_class_methods( $class );
				if ( in_array( $call, $methods ) ) {
					$new = new $class( ( isset( $this->charge_prefs ) ) ? $this->charge_prefs : array(), $this->mycred_type );
					return $new->$call( $return );
				}
			}

			// Function
			elseif ( ! is_array( $callback ) ) {
				if ( function_exists( $callback ) ) {
					if ( $return !== NULL )
						return call_user_func( $callback, $return, $this );
					else
						return call_user_func( $callback, $this );
				}
			}

		}

		/**
		 * Get Hooks
		 * @since 1.0
		 * @version 1.1
		 */
		public function get( $save = false ) {

			$installed = array();

			// View Profile
			$installed['view_profile'] = array(
				'title'        => __( 'View Profiles', 'bp_charge' ),
				'description'  => __( 'Either sell access to all BuddyPress profile or let your users select to sell access themselves.', 'bp_charge' ),
				'callback'     => array( 'myCRED_BP_Charge_View_Profile' )
			);

			// Messaging (if enabled)
			if ( bp_is_active( 'messages' ) )
				$installed['messaging'] = array(
					'title'        => __( 'Sending Private Messages', 'bp_charge' ),
					'description'  => __( 'Charge users for sending private messages in BuddyPress.', 'bp_charge' ),
					'callback'     => array( 'myCRED_BP_Charge_Messaging' )
				);

			// Messaging (if enabled)
			if ( bp_is_active( 'groups' ) )
				$installed['join_group'] = array(
					'title'        => __( 'Join Group', 'bp_charge' ),
					'description'  => __( 'Charge users for joining groups in BuddyPress.', 'bp_charge' ),
					'callback'     => array( 'myCRED_BP_Charge_Join_Group' )
				);

			$installed = apply_filters( 'mycred_setup_bp_charges', $installed, $this->mycred_type );

			if ( $save === true && $this->core->user_is_point_editor() ) {
				$new_data = array(
					'active'       => $this->active,
					'installed'    => $installed,
					'charge_prefs' => $this->charge_prefs
				);
				mycred_update_option( $this->option_id, $new_data );
			}

			$this->installed = $installed;

			return $installed;

		}

		/**
		 * Page Header
		 * @since 1.0
		 * @version 1.0
		 */
		public function settings_header() {

			$charge_icons = plugins_url( 'assets/images/admin-icons.png', BP_CHARGES );

?>
<style type="text/css">
#myCRED-wrap #accordion h4 .charge-icon { display: block; width: 48px; height: 48px; margin: 0 0 0 0; padding: 0; float: left; line-height: 48px; }
#myCRED-wrap #accordion h4 .charge-icon { background-repeat: no-repeat; background-image: url("<?php echo $charge_icons; ?>"); background-position: 0 0; }
#myCRED-wrap #accordion h4 .charge-icon.active { background-position: -48px 0; }
#myCRED-wrap #accordion h4 .charge-icon.inactive { background-position: -96px 0; }
</style>
<?php

		}

		/**
		 * Admin Page
		 * @since 1.0
		 * @version 1.0
		 */
		public function admin_page() {

			// Security
			if ( ! $this->core->user_is_point_admin() ) wp_die( __( 'Access Denied', 'bp_charge' ) );

			// Get installed
			$installed = $this->get( true );

?>
<div class="wrap" id="myCRED-wrap">
	<h2><?php _e( 'BuddyPress Charges', 'bp_charge' ); ?></h2>

	<?php $this->update_notice(); ?>

	<p><?php echo $this->core->template_tags_general( __( 'Available BuddyPress Charges that you can enforce.', 'bp_charge' ) ); ?></p>
	<form method="post" action="options.php">

		<?php settings_fields( $this->settings_name ); ?>

		<div class="list-items expandable-li" id="accordion">
<?php

			// Installed Services
			if ( ! empty( $installed ) ) {
				foreach ( $installed as $key => $data ) {

?>

			<h4><div class="charge-icon <?php if ( $this->is_active( $key ) ) echo 'active'; else echo 'inactive'; ?>"></div><?php echo $this->core->template_tags_general( $data['title'] ); ?></h4>
			<div class="body" style="display:none;">
				<p><?php echo nl2br( $this->core->template_tags_general( $data['description'] ) ); ?></p>
				<label class="subheader"><?php _e( 'Charge for this', 'bp_charge' ); ?></label>
				<ol>
					<li>
						<input type="checkbox" name="<?php echo $this->option_id; ?>[active][]" id="mycred-bp-charge-<?php echo $key; ?>" value="<?php echo $key; ?>"<?php if ( $this->is_active( $key ) ) echo ' checked="checked"'; ?> />
					</li>
				</ol>
				<?php echo $this->call( 'preferences', $data['callback'] ); ?>

			</div>
<?php			}
			} ?>

			<?php if ( bp_is_active( 'groups' ) ) : ?>

			<h4><div class="charge-icon"></div><?php _e( 'Group Creations', 'bp_charge' ); ?></h4>
			<div class="body" style="display:none;">
				<p><?php _e( 'You can use the BuddyPress: Groups hook to deduct points when a user creates a new group. If the a user does not have enough points, the "Create Group" button will not be available.', 'bp_charge' ); ?></p>
			</div>

			<?php endif; ?>

			<?php if ( bp_is_active( 'friends' ) ) : ?>

			<h4><div class="charge-icon"></div><?php _e( 'Friendships', 'bp_charge' ); ?></h4>
			<div class="body" style="display:none;">
				<p><?php _e( 'You can use the BuddyPress: Member hook to deduct points when a user become friends with someone. If a user does not have enough points, the "Add Friend" button will not be available.', 'bp_charge' ); ?></p>
			</div>

			<?php endif; ?>

		</div>

		<?php submit_button( __( 'Update Changes', 'bp_charge' ), 'primary large', 'submit', false ); ?>

	</form>
</div>
<?php

		}

		/**
		 * Sanititze Settings
		 * @since 1.0
		 * @version 1.0
		 */
		public function sanitize_settings( $post ) {

			// Loop though all installed charges
			$installed = $this->get();

			// Construct new settings
			$new_post['installed'] = $installed;
			if ( empty( $post['active'] ) || ! isset( $post['active'] ) )
				$post['active'] = array();

			$new_post['active'] = $post['active'];

			if ( ! empty( $installed ) ) {
				foreach ( $installed as $key => $data ) {

					if ( isset( $data['callback'] ) && isset( $post['charge_prefs'][ $key ] ) ) {

						// Old settings
						$old_settings = $post['charge_prefs'][ $key ];

						// New settings
						$new_settings = $this->call( 'sanitise_preferences', $data['callback'], $old_settings );

						// If something went wrong use the old settings
						if ( empty( $new_settings ) || $new_settings === NULL || ! is_array( $new_settings ) )
							$new_post['charge_prefs'][ $key ] = $old_settings;

						// Else we got ourselves new settings
						else
							$new_post['charge_prefs'][ $key ] = $new_settings;

						// Handle de-activation
						if ( in_array( $key, (array) $this->active ) && ! in_array( $key, $new_post['active'] ) )
							$this->call( 'deactivate', $data['callback'], $new_post['charge_prefs'][ $key ] );

						// Handle activation
						if ( ! in_array( $key, (array) $this->active ) && in_array( $key, $new_post['active'] ) )
							$this->call( 'activate', $data['callback'], $new_post['charge_prefs'][ $key ] );

						// Next item

					}

				}

			}

			return $new_post;

		}

	}
endif;
