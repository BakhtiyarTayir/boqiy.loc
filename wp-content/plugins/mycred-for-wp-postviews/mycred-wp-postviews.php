<?php
/**
 * Plugin Name: myCRED for WP-PostViews
 * Plugin URI: https://www.mycred.me/store/mycred-for-wp-postviews
 * Description: Allows you to reward authors points for gaining post views.
 * Version: 1.0.5
 * Tags: mycred, points, view, post
 * Author: myCRED
 * Author URI: http://mycred.me
 * Author Email: support@mycred.me
 * Requires at least: WP 4.8
 * Tested up to: WP 6.0
 * Text Domain: mycred_wp_postviews
 * Domain Path: /lang
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
if ( ! class_exists( 'myCRED_WP_PostViews' ) ) :
	final class myCRED_WP_PostViews {

		// Plugin Version
		public $version             = '1.0.5';

		// Instnace
		protected static $_instance = NULL;

		// Current session
		public $session             = NULL;

		public $slug                = '';
		public $domain              = '';
		public $plugin              = NULL;
		public $plugin_name         = '';

		/**
		 * Setup Instance
		 * @since 1.0
		 * @version 1.0.4
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
		 * @version 1.0.4
		 */
		public function __clone() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', '1.0' ); }

		/**
		 * Not allowed
		 * @since 1.0
		 * @version 1.0.4
		 */
		public function __wakeup() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', '1.0' ); }

		/**
		 * Define
		 * @since 1.0
		 * @version 1.0.4
		 */
		private function define( $name, $value, $definable = true ) {
			if ( ! defined( $name ) )
				define( $name, $value );
		}

		/**
		 * Require File
		 * @since 1.0
		 * @version 1.0.4
		 */
		public function file( $required_file ) {
			if ( file_exists( $required_file ) )
				require_once $required_file;
		}

		/**
		 * Construct
		 * @since 1.0
		 * @version 1.0.4
		 */
		public function __construct() {

			$this->slug        = 'mycred-wp-postviews';
			$this->plugin      = plugin_basename( __FILE__ );
			$this->domain      = 'mycred_wp_postviews';
			$this->plugin_name = 'myCRED for WP-PostViews';

			$this->define_constants();

			add_filter( 'mycred_setup_hooks',    array( $this, 'register_hook' ) );
			add_action( 'mycred_init',           array( $this, 'load_textdomain' ) );
			add_action( 'mycred_all_references', array( $this, 'add_badge_support' ) );
			add_action( 'mycred_load_hooks',    'mycred_load_wp_postviews_hook' );

		}

		/**
		 * Define Constants
		 * @since 1.0
		 * @version 1.0.4
		 */
		public function define_constants() {

			$this->define( 'MYCRED_WP_POSTVIEWS_SLUG', $this->slug );
			$this->define( 'MYCRED_DEFAULT_TYPE_KEY',  'mycred_default' );

		}

		/**
		 * Includes
		 * @since 1.0
		 * @version 1.0.4
		 */
		public function includes() { }

		/**
		 * Load Textdomain
		 * @since 1.0
		 * @version 1.0.4
		 */
		public function load_textdomain() {

			// Load Translation
			$locale = apply_filters( 'plugin_locale', get_locale(), $this->domain );

			load_textdomain( $this->domain, WP_LANG_DIR . '/' . $this->slug . '/' . $this->domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $this->domain, false, dirname( $this->plugin ) . '/lang/' );

		}

		/**
		 * Register Hook
		 * @since 1.0
		 * @version 1.0.4
		 */
		public function register_hook( $installed ) {

			if ( ! function_exists( 'wp_postview_cache_count_enqueue' ) ) return $installed;

			$installed['wppostviews'] = array(
				'title'       => __( 'WP-PostViews', $this->domain ),
				'description' => __( 'Allows you to reward authors points for gaining post views.', $this->domain ),
				'callback'    => array( 'myCRED_Hook_WP_Postviews' )
			);

			return $installed;

		}

		/**
		 * Add Badge Support
		 * @since 1.0
		 * @version 1.0.4
		 */
		public function add_badge_support( $references ) {

			if ( ! function_exists( 'wp_postview_cache_count_enqueue' ) ) return $references;

			$references['postview'] = __( 'Post View (WP-PostViews)', $this->domain );

			return $references;

		}

	}
endif;

function mycred_wp_postviews_plugin() {
	return myCRED_WP_PostViews::instance();
}
mycred_wp_postviews_plugin();

/**
 * WP Post Views Hook
 * @since 1.0
 * @version 1.0.4
 */
if ( ! function_exists( 'mycred_load_wp_postviews_hook' ) ) :
	function mycred_load_wp_postviews_hook() {

		if ( class_exists( 'myCRED_Hook_WP_Postviews' ) || ! function_exists( 'wp_postview_cache_count_enqueue' ) ) return;

		class myCRED_Hook_WP_Postviews extends myCRED_Hook {

			/**
			 * Construct
			 */
			function __construct( $hook_prefs, $type = MYCRED_DEFAULT_TYPE_KEY ) {

				parent::__construct( array(
					'id'       => 'wppostviews',
					'defaults' => array(
						'creds'  => 1,
						'log'    => '%plural% for post view',
						'limit'  => '0/x'
					)
				), $hook_prefs, $type );

			}

			/**
			 * Hook into WP Postviews
			 * @since 1.0
			 * @version 1.0.4
			 */
			public function run() {

				add_action( 'postviews_increment_views',      array( $this, 'new_view' ) );
				add_action( 'postviews_increment_views_ajax', array( $this, 'new_view_ajax' ), 1 );

			}

			/**
			 * New View
			 * @since 1.0
			 * @version 1.0.4
			 */
			public function new_view() {

				global $post;

				$this->process_new_view( $post );

			}

			/**
			 * New View Ajax
			 * @since 1.0
			 * @version 1.0.4
			 */
			public function new_view_ajax() {

				$post_id = intval( $_GET['postviews_id'] );

				$post = get_post( $post_id );
				if ( isset( $post->ID ) )
					$this->process_new_view( $post );

			}

			/**
			 * Process View
			 * @since 1.0
			 * @version 1.0.4
			 */
			protected function process_new_view( $post ) {

				// Check for exclusions
				if ( $this->core->exclude_user( $post->post_author ) ) return;

				// Payout if not over limit
				if ( ! $this->over_hook_limit( '', 'postview', $post->post_author ) )
					$this->core->add_creds(
						'postview',
						$post->post_author,
						$this->prefs['creds'],
						$this->prefs['log'],
						$post->ID,
						array( 'ref_type' => 'post' ),
						$this->mycred_type
					);

			}

			/**
			 * Preferences
			 * @since 1.0
			 * @version 1.0.4
			 */
			public function preferences() {

				$prefs = $this->prefs;

?>
<label class="subheader" for="<?php echo $this->field_id( 'creds' ); ?>"><?php _e( 'Receiving Post View', 'mycred_wp_postviews' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( 'creds' ); ?>" id="<?php echo $this->field_id( 'creds' ); ?>" value="<?php echo $this->core->number( $prefs['creds'] ); ?>" size="8" /></div>
	</li>
	<li>
		<label for="<?php echo $this->field_id( 'limit' ); ?>"><?php _e( 'Limit', 'mycred_wp_postviews' ); ?></label>
		<?php echo $this->hook_limit_setting( $this->field_name( 'limit' ), $this->field_id( 'limit' ), $prefs['limit'] ); ?>
	</li>
	<li class="empty">&nbsp;</li>
	<li>
		<label for="<?php echo $this->field_id( 'log' ); ?>"><?php _e( 'Log template', 'mycred_wp_postviews' ); ?></label>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( 'log' ); ?>" id="<?php echo $this->field_id( 'log' ); ?>" value="<?php echo esc_attr( $prefs['log'] ); ?>" class="long" /></div>
		<span class="description"><?php echo $this->core->available_template_tags( array( 'general', 'post' ) ); ?></span>
	</li>
</ol>
<?php

			}

			/**
			 * Sanitise Preferences
			 * @since 1.0
			 * @version 1.0.4
			 */
			public function sanitise_preferences( $data ) {

				if ( isset( $data['limit'] ) && isset( $data['limit_by'] ) ) {
					$limit = sanitize_text_field( $data['limit'] );
					if ( $limit == '' ) $limit = 0;
					$data['limit'] = $limit . '/' . $data['limit_by'];
					unset( $data['limit_by'] );
				}

				return $data;

			}

		}

	}
endif;
