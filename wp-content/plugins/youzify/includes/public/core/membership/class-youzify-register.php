<?php

class Youzify_Membership_Register {

	/**
	 * Init Registration Actions & Filters.
	 */
	public function __construct() {

        if ( apply_filters( 'youzify_enable_registration_hooks', true ) ) {

	    	// Init Captcha.
			add_action( 'bp_before_registration_submit_buttons', array( $this, 'add_extra_fields' ) );

			// Verify Captcha.
			add_action( 'bp_signup_pre_validate', array( $this, 'verify_recaptcha' ) );

			// Stop Converting Spaces to '-'.
			remove_action( 'pre_user_login', 'bp_core_strip_username_spaces' );

			// Prevent Username Spaces.
			add_filter( 'validate_username', array( $this, 'restrict_space_in_username' ), 10, 2 );

			// Redirect On Sign Up.
	        add_action( 'bp_core_screen_signup', array( $this, 'redirect_on_signup' ) );

	        // Display Errors.
	        add_action( 'bp_init', array( $this, 'process_signup_errors' ) );

	        // Reference Registration Page
	        add_action( 'youzify_membership_after_register_buttons', array( $this, 'registration_page_reference' ) );

        }

	}

	/**
	 * Add Registration Extra Fields Actions
	 */
	function add_extra_fields() {

		// Get Captcha
		$this->add_captcha();

		// Get Terms and Conditions.
		$this->add_registration_form_terms();

	}

	/**
	 * add a filter to invalidate a username with spaces
	 *
	 */
	function restrict_space_in_username( $valid, $user_name ) {

		// Check if there is an space
		if ( preg_match( '/\s/', $user_name ) ) {
			//if yes, then we say it is an error
			return false;
	  	}

		//otherwise return the actual validity
	 	return $valid;

	}

	/**
	 * Checks that the reCAPTCHA parameter sent with the registration request is valid.
	 */
	public function verify_recaptcha() {

		// Get Captcha Response
		if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset ( $_POST['g-recaptcha-response'] ) ) {
			return false;
		}

		// This field is set by the recaptcha widget if check is successful
		$captcha_response = sanitize_text_field( $_POST['g-recaptcha-response'] );

		// Verify the captcha response from Google
		$response = wp_remote_post(
			'https://www.google.com/recaptcha/api/siteverify',
			array(
				'body' => array(
					'secret' 	=> youzify_option( 'youzify_signup_recaptcha_secret_key' ),
					'response' 	=> $captcha_response
				)
			)
		);

		$success = false;

		if ( $response && is_array( $response ) ) {
			$decoded_response = json_decode( $response['body'] );
			$success = $decoded_response->success;
		}

		// Verify Captcha Response.
		if ( ! $success ) {
			$this->redirect( 'wrong_captcha' );
		}

	}

	/**
	 * Add Captcha
	 */
	function add_captcha() {

	    if ( 'off' == youzify_option( 'youzify_enable_signup_recaptcha', 'on' ) )  {
	        return;
	    }

	    // Get Captcha Key.
	    $captcha_key = youzify_option( 'youzify_signup_recaptcha_site_key' ) ;

	    // Check Captcha Options.
	    if ( empty( $captcha_key ) || empty( youzify_option( 'youzify_signup_recaptcha_secret_key' ) ) ) {
	        return;
	    }

		?>

		<div class="youzify-membership-recaptcha-container">
			<div class="g-recaptcha"<?php do_action( 'youzify_recaptcha_attributes' ); ?> data-sitekey="<?php echo $captcha_key; ?>"></div>
		</div>

		<?php

		// Get Captcha Language !
		$language = apply_filters( 'youzify_captcha_language' , 'en' );

		echo apply_filters( 'youzify_signup_captcha', "<script src='https://www.google.com/recaptcha/api.js?hl=$language'></script>" );

	}

	/**
	 * Attributes
	 */
	function attributes() {
		return $this->messages_attributes();
	}

	/**
	 * Messages Attributes
	 */
	function messages_attributes() {

		// Retrieve possible errors from request parameters
		$attributes['errors'] = array();

		if ( isset( $_REQUEST['register-errors'] ) ) {
			$error_codes = explode( ',', sanitize_text_field( $_REQUEST['register-errors'] ) );
			foreach ( $error_codes as $error_code ) {
				$attributes['errors'] []= $this->get_error_message( $error_code );
			}
		}

		return $attributes;
	}

    /**
     * If the signup form is being processed, Redirect to the page where the signup form is
     *
     */
    function redirect_on_signup() {

        if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
            return;
        }

        if ( isset( $_POST['youzify_registration_page'] ) ) {
        	return;
        }

        // Init Buddypress variable.
        $bp = buddypress();

        // Only if bp signup object is set
        if ( ! empty( $bp->signup ) ) {
        	// Set Sessions.
            $_SESSION['youzify_signup'] = $bp->signup;
            $_SESSION['youzify_signup_fields'] = $_POST;
        }

        // Redirect To Same Page.
        bp_core_redirect( wp_get_referer() );

    }

    /**
     * Process Sign Up Errors.
     */
    function process_signup_errors() {

        if ( is_user_logged_in() ) {
            return;
        }

        // Init Session.
        if ( ! session_id() ) {
            session_start();
        }

        // Check if the current request
        if ( ! empty( $_SESSION['youzify_signup'] ) ) {

            // Init Variables.
            $bp = buddypress();

            // Restore the old signup object.
            $bp->signup = $_SESSION['youzify_signup'];

            // We need to restore so that the signup form can show the old data.
            if ( isset( $bp->signup->errors ) && ! empty( $bp->signup->errors ) ) {
                $_POST = $_SESSION['youzify_signup_fields'];
            }

            // Init Array.
            $errors = array();

            // Get Errors.
            if ( isset( $bp->signup->errors ) ) {
                $errors = (array) $bp->signup->errors;
            }

            // Print Errors.
            foreach ( $errors as $fieldname => $error_message ) {

                add_action(
                	'bp_' . $fieldname . '_errors',
                	create_function( '', 'echo apply_filters(\'bp_members_signup_error_message\', "<div class=\"error\">" . stripslashes( \'' . addslashes( $error_message ) . '\' ) . "</div>" );' )
                );
            }

            // Reset Sessions.
            $_SESSION['youzify_signup']        = null;
            $_SESSION['youzify_signup_fields'] = null;
        }
    }

	/**
	 * Redirect User To Specific Page..
	 */
	public function redirect( $code, $redirect_to = null, $type = null ) {

		// Init Erros.
		$messages = array();

		// Get Redirect Url.
		$redirect_url = ! empty( $redirect_to ) ? $redirect_to : youzify_membership_page_url( 'register' );

		// Get Message.
		$messages[] = youzify_membership_get_message( __( 'The CAPTCHA check failed. Try again!', 'youzify' ), $type );

		// Get Messages.
		youzify_membership_add_message( $messages, $type );

		// Redirect User.
		wp_redirect( $redirect_url );

		// Exit.
		exit;

	}

	/**
	 * Custom Field for registration page form
	 */
	function registration_page_reference() {

		if ( ! bp_is_register_page() ) {
			return false;
		}

		?>

		<input type="hidden" name="youzify_registration_page" value="true">

		<?php
	}


	/**
	 * Add Terms description to the register  form
	 */
	function add_registration_form_terms() {

	    // Display terms and conditions & privacy policy.
	    if ( 'off' == youzify_option( 'youzify_membership_show_terms_privacy_note', 'on' ) ) {
	        return false;
	    }

	    // Get Data
	    $terms_url = youzify_option( 'youzify_membership_terms_url' );
	    $privacy_url = youzify_option( 'youzify_membership_privacy_url' );

	    ?>

	    <div class="youzify-membership-form-note youzify-membership-terms-note">
	        <?php echo sprintf( __( 'By creating an account you agree to our <a href="%1s" target="_blank">Terms and Conditions</a> and our <a href="%2s" target="_blank">Privacy Policy</a>.', 'youzify' ), $terms_url, $privacy_url ); ?>
	    </div>

	    <?php

	}

}