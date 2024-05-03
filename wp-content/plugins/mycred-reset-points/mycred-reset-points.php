<?php
/**
 * Plugin Name: myCred Reset Points
 * Version: 1.0
 * Description: Ability to reset myCred Points.
 * Author: myCred
 * Author URI: https://mycred.me
 * Text Domain: mycredrp
 */
if ( ! class_exists( 'mycred_reset_points' ) ) :
	final class mycred_reset_points {

		// Plugin Version
		public $version             = '1.0'; 

		public $slug                = 'mycred-reset-points';

		// Instnace
		protected static $_instance = NULL;

		// Plugin name
		public $plugin_name         = 'myCred Reset Points';

		// Plugin ID
		public $id                  = 220;

		// Current session
		public $session             = NULL;

		public $domain              = 'mycredrp';
		public $update_url          = 'https://mycred.me/api/plugins/';

		/**
		 * Setup Instance
		 * @since 1.0
		 * @version 1.0
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Not allowed
		 * @since 1.0
		 * @version 1.0
		 */
		public function __clone() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', $this->version ); }

		/**
		 * Not allowed
		 * @since 1.0
		 * @version 1.0
		 */
		public function __wakeup() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', $this->version ); }

		/**
		 * Define
		 * @since 1.0
		 * @version 1.0
		 */
		private function define( $name, $value, $definable = true ) {
			if ( ! defined( $name ) )
				define( $name, $value );
			elseif ( ! $definable && defined( $name ) )
				_doing_it_wrong( 'mycred_reset_points->define()', 'Could not define: ' . $name . ' as it is already defined somewhere else!', $this->version );
		}

		/**
		 * Require File
		 * @since 1.0
		 * @version 1.0
		 */
		public function file( $required_file ) {
			if ( file_exists( $required_file ) )
				require_once $required_file;
			else
				_doing_it_wrong( 'mycred_reset_points->file()', 'Requested file ' . $required_file . ' not found.', $this->version );
		}

		/**
		 * Construct
		 * @since 1.0
		 * @version 1.0
		 */
		public function __construct() {

			$this->define_constants();
			$this->load();
			$this->load_module();
			//$this->enqueue_scripts();

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ),20 );
			register_activation_hook( MYCRED_PR_THIS,       array( __CLASS__, 'activate_plugin' ) );

		}

		/**
		 * Load Module
		 * @since 1.0
		 * @version 1.0
		 */
		public function load_module() {
			$this->file( MYCRED_PR_ROOT_DIR . 'licensing/license.php' );
		}
		
		/**
		 * Define Constants
		 * First, we start with defining all requires constants if they are not defined already.
		 * @since 1.0
		 * @version 1.0
		 */
		private function define_constants() {

			$this->define( 'MYCRED_PR_VERSION',       $this->version );
			$this->define( 'MYCRED_PR_SLUG',          $this->slug );

			$this->define( 'MYCRED_PR_THIS',          __FILE__ );
			$this->define( 'MYCRED_PR_ROOT_DIR',      plugin_dir_path( MYCRED_PR_THIS ) );
			$this->define( 'MYCRED_PR_INCLUDES_DIR',  MYCRED_PR_ROOT_DIR . 'include/' );
		}

		/**
		 * Load
		 * @version 1.0.2
		 */
		public function load() {
			add_action( 'mycred_after_core_prefs',     array( $this, 'after_general_settings' ) );
			add_action( 'edit_user_profile',           array( $this, 'extra_user_profile_fields' ) );
			add_action( 'show_user_profile',           array( $this, 'extra_user_profile_fields' ) );
			
			add_action( 'wp_ajax_reset_points',        array( $this,'resetpointofuser' ));
			add_action( 'wp_ajax_nopriv_reset_points', array( $this, 'resetpointofuser' ));

		}

		public  static function enqueue_scripts() {

			wp_register_script(
				'custom-mycred-reset',
				plugins_url( 'assets/js/custom.js', MYCRED_PR_THIS ),
				array( 'jquery' ),
				MYCRED_PR_VERSION,
				true
			);

			wp_enqueue_script( 'custom-mycred-reset' );

		}


		public function after_general_settings( $mycred = NULL ) { ?>
			<h4><span class="dashicons dashicons-admin-plugins static"></span><strong>Reset</strong> Points</h4>
			<div class="body" style="display:none;">
				<div class="row">
    				<div class="col-lg-6">
        				<h2>User Roles</h2>
        		
        			   <?php 
        			        $r = '';
        				    $editable_roles = array_reverse( get_editable_roles() );
        		
        		    		foreach ( $editable_roles as $role => $details ) {
        					    $name = translate_user_role($details['name'] );
        						$r .= "\n\t<input type='checkbox' name='roles' value='" . esc_attr( $role ) . "'>$name<br>";
        				    }
        				    echo $r; 
        				?>
        			</div>
        			<div class="col-lg-6">
        				<h2>Point Types</h2>
        			    <?php 
        			        $r = '';
        				    $pointtypes = mycred_get_types();
            				foreach ( $pointtypes as $point => $type ) {
            					$r .= "\n\t<input type='checkbox' name='pointtypes' class='pointname' value='" . esc_attr( $point ) . "'>$type<br>";
            				}
        				    echo $r; 
        				?>
        			</div>
			    </div>
			    <button name="reset_point" id="reset_points" data-role="1" class="button">Reset</button><br />
			</div>
			<?php 
			}

			function extra_user_profile_fields( $user ) { ?>
			    <hr />
				<h2><?php _e("Reset Points", "mycredpR"); ?></h2>

				<table class="form-table">
    				<tr>
        				<th><label for="address"><?php _e("Point Types"); ?></label></th>
        				<td>
            				<?php 
            				    $r = '';
            					$pointtypes = mycred_get_types();
            					foreach ( $pointtypes as $point => $type ) {
            							$r .= "\n\t<input type='checkbox' name='pointtypes' class='pointname' value='" . esc_attr( $point ) . "'>$type<br>";
            					}
            					echo $r; 
            				?>
        				</td>
    				</tr>
    				<tr>
    				    <th></th>
        				<td>
        				    <button name="reset_point" class="button" id="reset_points" data-user="<?php echo  $user->ID ; ?>" data-role="0">Reset</button><br />
        				    <span class="description"><?php _e("Reset selected point types."); ?></span>
        				</td>
    				</tr>
				</table>
				<hr />
				<?php 
			}



			function resetpointofuser() {
	        
				$response = array('code' => 0, 'data' => '');
				
				if ((int)$_POST['roleCheck'] == 1) {
					# code...
					
	
					foreach ($_POST['roles'] as $single => $role) {
						# code...
					foreach (get_users(['role'=>$role]) as $user) {
						
						foreach ($_POST['pointtypes'] as $key => $value) {
								# code...
								$mycred        = mycred($value);
								$myCRED_Settings = new myCRED_Settings();
								$mycred->set_users_balance( $user->ID, 0 );
							
							global	$wpdb;
							$table = $wpdb->prefix.'mycred_log';
							$wpdb->query(
							  'DELETE  FROM '.$myCRED_Settings->log_table.'
							   WHERE user_id = "'.$user->ID.'" && ctype="'.$value.'"'
							);
						}
					}
					}
				}else{
					
					foreach ($_POST['pointtypes'] as $key => $value) {
						# code...
						$mycred        = mycred($value);
						$myCRED_Settings = new myCRED_Settings();
						$mycred->set_users_balance( (int)$_POST['userID'], 0 );
						global	$wpdb;
						$table = $wpdb->prefix.'mycred_log';
						$wpdb->query(
						  'DELETE  FROM '.$myCRED_Settings->log_table.'
						   WHERE user_id = "'.(int)$_POST['userID'].'" && ctype="'.$value.'"'
						);
					}
					 $response['code'] = 1;
				}
	
				wp_die(json_encode($response));
			}




		/**
		 * Load Textdomain
		 * @since 1.0
		 * @version 1.0
		 */
		public function load_textdomain() {

			// Load Translation
			$locale = apply_filters( 'plugin_locale', get_locale(), $this->domain );

			load_textdomain( $this->domain, WP_LANG_DIR . '/' . $this->slug . '/' . $this->domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $this->domain, false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

		}

		/**
		 * Activate
		 * @since 1.0
		 * @version 1.0
		 */
		public static function activate_plugin() {

			global $wpdb;

			$message = array();

			// WordPress check
			$wp_version = $GLOBALS['wp_version'];
			if ( version_compare( $wp_version, '4.5', '<' ) )
				$message[] = __( 'This myCRED Add-on requires WordPress 4.5 or higher. Version detected:', 'mycredpR' ) . ' ' . $wp_version;

			// PHP check
			$php_version = phpversion();
			if ( version_compare( $php_version, '5.6', '<' ) )
				$message[] = __( 'This myCRED Add-on requires PHP 5.6 or higher. Version detected: ', 'mycredpR' ) . ' ' . $php_version;

			// SQL check
			$sql_version = $wpdb->db_version();
			if ( version_compare( $sql_version, '5.0', '<' ) )
				$message[] = __( 'This myCRED Add-on requires SQL 5.0 or higher. Version detected: ', 'mycredpR' ) . ' ' . $sql_version;

			// myCred check
			if ( ! class_exists( 'myCRED_Core' ) )
				$message[] = __( 'This myCRED Add-on requires myCred plugin', 'mycredpR' );


			// Not empty $message means there are issues
			if ( ! empty( $message ) ) {

				$error_message = implode( "\n", $message );
				die( __( 'Sorry but your WordPress installation does not reach the minimum requirements for running this add-on. The following errors were given:', 'mycredpartwoo' ) . "\n" . $error_message );

			}

		}

	}
endif;


function mycred_reset_points() {
	return mycred_reset_points::instance();
}
mycred_reset_points();