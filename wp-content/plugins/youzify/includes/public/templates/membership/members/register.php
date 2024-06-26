<?php
/**
 * BuddyPress - Members Register
 * array( 'form_type' => 'signup', 'form_action' => 'signup' )
 */

do_action( 'youzify_membership_before_register_form' );

global $Youzify_Membership;

$attributes = $Youzify_Membership->form->get_attributes( 'register' ); ?>

<div class="youzify-membership youzify-membership-page-box youzify-page">

	<div class="<?php echo $Youzify_Membership->form->get_form_class( $attributes ); ?>">

	<?php $Youzify_Membership->form->get_form_header( 'register' ); ?>
	<?php $Youzify_Membership->form->get_form_messages( $attributes ); ?>

	<?php

	/**
	 * Fires at the top of the BuddyPress member registration page template.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_register_page' ); ?>

	<div class="page" id="register-page">

		<?php if ( 'completed-confirmation' == bp_get_current_signup_step() ) : ?>

			<?php

			/**
			 * Fires before the display of the registration confirmed messages.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_before_registration_confirmed' ); ?>

			<div id="template-notices" class="youzify-membership-form-message youzify-membership-success-msg" role="alert" aria-atomic="true">
				<?php if ( bp_registration_needs_activation() ) : ?>
					<p><?php _e( 'You have successfully created your account! To begin using this site you will need to activate your account via the email we have just sent to your address.', 'youzify' ); ?></p>
				<?php else : ?>
					<p><?php _e( 'You have successfully created your account! Please log in using the username and password you have just created.', 'youzify' ); ?></p>
				<?php endif; ?>
			</div>

			<?php

			/**
			 * Fires after the display of the registration confirmed messages.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_after_registration_confirmed' ); ?>

		<?php endif; // completed-confirmation signup step ?>


		<?php if ( 'registration-disabled' == bp_get_current_signup_step() ) : ?>

			<div id="template-notices" role="alert" aria-atomic="true">
				<?php

				/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
				do_action( 'template_notices' ); ?>

			</div>

			<?php

			/**
			 * Fires before the display of the registration disabled message.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_before_registration_disabled' ); ?>

			<div id="template-notices" class="youzify-membership-form-message youzify-membership-info-msg" role="alert" aria-atomic="true">
				<p><?php _e( 'User registration is currently not allowed.', 'youzify' ); ?></p>
			</div>
			<?php

			/**
			 * Fires after the display of the registration disabled message.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_after_registration_disabled' ); ?>
		<?php endif; // registration-disabled signup step ?>

		<form action="<?php echo bp_get_signup_page(); ?>" name="signup_form" id="youzify_membership_signup_form" class="standard-form" method="post" enctype="multipart/form-data">

		<?php if ( 'request-details' == bp_get_current_signup_step() ) : ?>

			<div id="template-notices" role="alert" aria-atomic="true">
				<?php

				/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
				do_action( 'template_notices' ); ?>

			</div>
			<?php /***** Extra Profile Details ******/ ?>

			<?php if ( bp_is_active( 'xprofile' ) ) : ?>

				<?php

				/**
				 * Fires before the display of member registration xprofile fields.
				 *
				 * @since 1.2.4
				 */
				do_action( 'bp_before_signup_profile_fields' ); ?>
			

					

					<?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
					<?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

						<div<?php bp_field_css_class( 'editfield' ); ?>>
							

							<?php
							$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
							$field_type->edit_field_html();

							/**
							 * Fires before the display of the visibility options for xprofile fields.
							 *
							 * @since 1.7.0
							 */
							do_action( 'bp_custom_profile_edit_fields_pre_visibility' );?>

							<?php

							/**
							 * Fires after the display of the visibility options for xprofile fields.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_custom_profile_edit_fields' ); ?>

						
						</div>

					<?php endwhile; ?>

					<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>">

					<?php endwhile; endif; endif; ?>

					<?php

					/**
					 * Fires and displays any extra member registration xprofile fields.
					 *
					 * @since 1.9.0
					 */
					do_action( 'bp_signup_profile_fields' ); ?>

			

				<?php

				/**
				 * Fires after the display of member registration xprofile fields.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_after_signup_profile_fields' ); ?>

				<?php endif; ?>
				
				<input type="hidden" name="signup_username" id="signup_username" value="<?php bp_signup_username_value(); ?>" <?php bp_form_field_attributes( 'username' ); ?>/>

			
				<input type="hidden" name="signup_email" id="signup_email" value="<?php bp_signup_email_value(); ?>" <?php bp_form_field_attributes( 'email' ); ?>/>
				<div class="youzify-membership-form-item">
					<div class="youzify-membership-item-content">
						<label for="signup_password"><?php _e( 'Choose a Password', 'youzify' ); ?> <span class="bp-required-field-label"><?php _e( 'required', 'youzify' ); ?></span></label>
						<?php

						/**
						 * Fires and displays any member registration password errors.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_signup_password_errors' ); ?>
						<input type="password" name="signup_password" id="signup_password" value="" class="password-entry" <?php bp_form_field_attributes( 'password' ); ?>/>
						<div id="pass-strength-result"></div>
					</div>
				</div>
				<div class="youzify-membership-form-item">
					<div class="youzify-membership-item-content">
						<label for="signup_password_confirm"><?php _e( 'Confirm Password', 'youzify' ); ?> <span class="bp-required-field-label"><?php _e( 'required', 'youzify' ); ?></span></label>
						<?php

						/**
						 * Fires and displays any member registration password confirmation errors.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_signup_password_confirm_errors' ); ?>
						<input type="password" name="signup_password_confirm" id="signup_password_confirm" value="" class="password-entry-confirm" <?php bp_form_field_attributes( 'password' ); ?>/>
					</div>
				</div>
				<?php

				/**
				 * Fires and displays any extra member registration details fields.
				 *
				 * @since 1.9.0
				 */
				do_action( 'bp_account_details_fields' ); ?>

			<?php

			/**
			 * Fires before the display of member registration account details fields.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_before_account_details_fields' ); ?>

	

			<?php

			/**
			 * Fires after the display of member registration account details fields.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_after_account_details_fields' ); ?>

			

			<?php if ( bp_get_blog_signup_allowed() ) : ?>

				<?php

				/**
				 * Fires before the display of member registration blog details fields.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_before_blog_details_fields' ); ?>

				<?php /***** Blog Creation Details ******/ ?>

				<div class="register-section" id="blog-details-section">

					<div class="youzify-membership-section-title">
						<span><?php _e( 'Blog Details', 'youzify' ); ?></span>
					</div>

					<p><label for="signup_with_blog"><input type="checkbox" name="signup_with_blog" id="signup_with_blog" value="1"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?> checked="checked"<?php endif; ?>> <?php _e( 'Yes, I\'d like to create a new site', 'youzify' ); ?></label></p>

					<div id="blog-details"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?>class="show"<?php endif; ?>>

						<label for="signup_blog_url"><?php _e( 'Blog URL', 'youzify' ); ?> <span class="bp-required-field-label"><?php _e( 'required', 'youzify' ); ?></span></label>
						<?php

						/**
						 * Fires and displays any member registration blog URL errors.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_signup_blog_url_errors' ); ?>

						<?php if ( is_subdomain_install() ) : ?>
							http:// <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value(); ?>"> .<?php bp_signup_subdomain_base(); ?>
						<?php else : ?>
							<?php echo home_url( '/' ); ?> <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value(); ?>">
						<?php endif; ?>

						<label for="signup_blog_title"><?php _e( 'Site Title', 'youzify' ); ?> <span class="bp-required-field-label"><?php _e( 'required', 'youzify' ); ?></span></label>
						<?php

						/**
						 * Fires and displays any member registration blog title errors.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_signup_blog_title_errors' ); ?>
						<input type="text" name="signup_blog_title" id="signup_blog_title" value="<?php bp_signup_blog_title_value(); ?>">

						<fieldset class="register-site">
							<legend class="label"><?php _e( 'Privacy: I would like my site to appear in search engines, and in public listings around this network.', 'youzify' ); ?></legend>
							<?php

							/**
							 * Fires and displays any member registration blog privacy errors.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_signup_blog_privacy_errors' ); ?>

							<label for="signup_blog_privacy_public"><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_public" value="public"<?php if ( 'public' == bp_get_signup_blog_privacy_value() || !bp_get_signup_blog_privacy_value() ) : ?> checked="checked"<?php endif; ?>> <?php _e( 'Yes', 'youzify' ); ?></label>
							<label for="signup_blog_privacy_private"><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_private" value="private"<?php if ( 'private' == bp_get_signup_blog_privacy_value() ) : ?> checked="checked"<?php endif; ?>> <?php _e( 'No', 'youzify' ); ?></label>
						</fieldset>

						<?php

						/**
						 * Fires and displays any extra member registration blog details fields.
						 *
						 * @since 1.9.0
						 */
						do_action( 'bp_blog_details_fields' ); ?>

					</div>

				</div><!-- #blog-details-section -->

				<?php

				/**
				 * Fires after the display of member registration blog details fields.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_after_blog_details_fields' ); ?>

			<?php endif; ?>

			<?php

			/**
			 * Fires before the display of the registration submit buttons.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_before_registration_submit_buttons' ); ?>

			<?php

			/**
			 * Fires after the display of the registration submit buttons.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_after_registration_submit_buttons' ); ?>

			<?php wp_nonce_field( 'bp_new_signup' ); ?>

		<?php endif; // request-details signup step ?>

		<?php

		/**
		 * Fires and displays any custom signup steps.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_custom_signup_steps' ); ?>

		<?php $elements = $Youzify_Membership->form->get_form_elements( 'register' ); ?>

		<?php do_action( 'youzify_register_form_before_actions' ); ?>

		<?php $Youzify_Membership->form->generate_form_actions( $elements['fields'], $attributes ); ?>
		<?php $Youzify_Membership->form->generate_form_actions( $elements['actions'], $attributes ); ?>

		<?php do_action( 'youzify_membership_after_register_buttons' ); ?>

		</form>

	</div>

	<?php

	/**
	 * Fires at the bottom of the BuddyPress member registration page template.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_register_page' ); ?>

	</div>

</div><!-- .youzify-membership-page -->
