<?php
/**
 * Affiliate Registration Form
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Affiliates
 * @version 1.0.5
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<div class="yith-wcaf yith-wcaf-registration-form woocommerce">

	<?php
	if ( function_exists( 'wc_print_notices' ) ) {
		wc_print_notices();
	}
	?>

	<?php if ( ! is_user_logged_in() ) : ?>

		<?php if ( 'yes' === $show_login_form ) : ?>
			<div class="u-columns col2-set" id="customer_login">
		<?php endif; ?>

		<?php if ( 'yes' === $show_login_form ) : ?>
			<div class="u-column1 col-1">

				<h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

				<form class="woocomerce-form woocommerce-form-login login" method="post">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>
							<span class="required">*</span></label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php echo ! empty( $_POST['username'] ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"/>
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
						<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password"/>
					</p>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<p class="form-row">
						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>"/>
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"/>
							<span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
						</label>
					</p>
					<p class="woocommerce-LostPassword lost_password">
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
					</p>

					<?php do_action( 'woocommerce_login_form_end' ); ?>

				</form>

			</div>
		<?php endif; ?>

		<?php if ( 'yes' === $show_login_form ) : ?>
		<div class="u-column2 col-2">
	<?php endif; ?>

		<?php if( apply_filters('yith_wcaf_show_register_section', true ) ) :  ?>

			<h2><?php esc_html_e( 'Register', 'yith-woocommerce-affiliates' ); ?></h2>

			<form method="post" class="register">

				<?php do_action( 'woocommerce_register_form_start' ); ?>

				<?php do_action( 'yith_wcaf_register_form_start' ); ?>

				<?php if ( 'yes' === $show_name_field ) : ?>

					<?php
					$label    = apply_filters( 'yith_wcaf_first_name_label', __( 'First name', 'yith-woocommerce-affiliates' ) );
					$required = apply_filters( 'yith_wcaf_first_name_required', false );
					?>

					<p class="form-row form-row-wide">
						<label for="reg_first_name"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?></label>
						<input type="text" class="input-text" name="first_name" id="reg_first_name" value="<?php echo ! empty( $_POST['first_name'] ) ? esc_attr( wp_unslash( $_POST['first_name'] ) ) : ''; ?>"/>
					</p>

				<?php endif; ?>

				<?php if ( 'yes' === $show_surname_field ) : ?>

					<?php
					$label    = apply_filters( 'yith_wcaf_last_name_label', __( 'Last name', 'yith-woocommerce-affiliates' ) );
					$required = apply_filters( 'yith_wcaf_last_name_required', false );
					?>

					<p class="form-row form-row-wide">
						<label for="reg_last_name"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?></label>
						<input type="text" class="input-text" name="last_name" id="reg_last_name" value="<?php echo ! empty( $_POST['last_name'] ) ? esc_attr( wp_unslash( $_POST['last_name'] ) ) : ''; ?>"/>
					</p>

				<?php endif; ?>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

					<p class="form-row form-row-wide">
						<label for="reg_username"><?php esc_html_e( 'Username', 'yith-woocommerce-affiliates' ); ?>
							<span class="required">*</span></label>
						<input type="text" class="input-text" name="username" id="reg_username" value="<?php echo ! empty( $_POST['username'] ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"/>
					</p>

				<?php endif; ?>

				<p class="form-row form-row-wide">
					<label for="reg_email"><?php esc_html_e( 'Email address', 'yith-woocommerce-affiliates' ); ?>
						<span class="required">*</span></label>
					<input type="email" class="input-text" name="email" id="reg_email" value="<?php echo ! empty( $_POST['email'] ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>"/>
				</p>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

					<p class="form-row form-row-wide">
						<label for="reg_password"><?php esc_html_e( 'Password', 'yith-woocommerce-affiliates' ); ?>
							<span class="required">*</span></label>
						<input type="password" class="input-text" name="password" id="reg_password"/>
					</p>

				<?php endif; ?>

				<?php if ( apply_filters( 'yith_wcaf_payment_email_required', true ) ) : ?>
					<p class="form-row form-row-wide">
						<label for="payment_email"><?php esc_html_e( 'Payment email address', 'yith-woocommerce-affiliates' ); ?>
							<span class="required">*</span></label>
						<input type="email" class="input-text" name="payment_email" id="payment_email" value="<?php echo ! empty( $_POST['payment_email'] ) ? esc_attr( wp_unslash( $_POST['payment_email'] ) ) : ''; ?>"/>
					</p>
				<?php endif; ?>

				<?php if ( 'yes' === $show_website_field ) : ?>

					<?php
					$label    = apply_filters( 'yith_wcaf_website_label', __( 'Website', 'yith-woocommerce-affiliates' ) );
					$required = apply_filters( 'yith_wcaf_website_required', true );
					?>

					<p class="form-row form-row-wide">
						<label for="website"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?></label>
						<input type="<?php echo esc_attr( apply_filters( 'yith_wcaf_website_type', 'url' ) ); ?>" class="input-text" name="website" id="website" value="<?php echo ! empty( $_POST['website'] ) ? esc_attr( wp_unslash( $_POST['website'] ) ) : ''; ?>"/>
					</p>

				<?php endif; ?>

				<?php if ( 'yes' === $show_promotional_method_field ) : ?>

					<?php
					$label    = apply_filters( 'yith_wcaf_promotional_methods_label', __( 'How will you promote our site?', 'yith-woocommerce-affiliates' ) );
					$required = apply_filters( 'yith_wcaf_promotional_methods_required', true );
					?>

					<p class="form-row form-row-wide">
						<label for="how_promote"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?></label>
						<select name="how_promote" id="how_promote">
							<?php
							$how_promote_options = yith_wcaf_get_promote_methods();

							if ( ! empty( $how_promote_options ) ) :
								foreach ( $how_promote_options as $id => $label ) :
									?>
									<option value="<?php echo esc_attr( $id ); ?>" <?php selected( isset( $_POST['how_promote'] ) && $_POST['how_promote'] === $id ); ?>><?php echo esc_html( $label ); ?></option>
									<?php
								endforeach;
							endif;
							?>
						</select>
					</p>

					<?php
					$label    = apply_filters( 'yith_wcaf_custom_promote_label', __( 'Specify how will you promote our site', 'yith-woocommerce-affiliates' ) );
					$required = apply_filters( 'yith_wcaf_custom_promote_required', true );
					?>

					<p class="form-row form-row-wide">
						<label for="custom_promote"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?></label>
						<textarea name="custom_promote" id="custom_promote"><?php echo ! empty( $_POST['custom_promote'] ) ? esc_html( wp_unslash( $_POST['custom_promote'] ) ) : ''; ?></textarea>
					</p>
				<?php endif; ?>

				<?php if ( 'yes' === $show_terms_field ) : ?>
					<?php
					$terms_link = sprintf( '<a target="_blank" href="%s">%s</a>', $terms_anchor_url, $terms_anchor_text );
					$label      = apply_filters( 'yith_wcaf_terms_label', str_replace( '%TERMS%', $terms_link, $terms_label ) );
					$required   = apply_filters( 'yith_wcaf_terms_required', true );
					?>
					<p class="form-row form-row-wide">
						<label for="terms">
							<input type="checkbox" name="terms" id="terms" value="yes" <?php checked( isset( $_POST['terms'] ) ); ?> />
							<?php echo wp_kses_post( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?>
						</label>
					</p>
				<?php endif; ?>

				<!-- Spam Trap -->
				<div style="<?php echo( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;">
					<label for="trap"><?php esc_html_e( 'Anti-spam', 'yith-woocommerce-affiliates' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1"/>
				</div>

				<?php do_action( 'yith_wcaf_register_form' ); ?>
				<?php do_action( 'woocommerce_register_form' ); ?>

				<p class="form-row">
					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
					<?php wp_nonce_field( 'yith-wcaf-register-affiliate', 'register_affiliate', false ); ?>

					<input type="submit" class="button" name="register" value="<?php esc_attr_e( 'Register', 'yith-woocommerce-affiliates' ); ?>"/>
				</p>

				<?php do_action( 'woocommerce_register_form_end' ); ?>

			</form>
		<?php endif; ?>

		<?php if ( 'yes' === $show_login_form ) : ?>
		</div>
	<?php endif; ?>

		<?php if ( 'yes' === $show_login_form ) : ?>
			</div>
		<?php endif; ?>

		<?php
	elseif ( YITH_WCAF_Affiliate_Handler_Premium()->is_user_excluded_affiliate() ) :
		// translators: 1. shop contact email.
		echo wp_kses_post( apply_filters( 'yith_wcaf_registration_form_affiliate_excluded_text', sprintf( _x( 'We\'re sorry, but you don\'t have sufficient permissions to enter our affiliation program. Please, contact us at %s to apply for the program', '%s: shop email', 'yith-woocommerce-affiliates' ), get_option( 'woocommerce_email_from_address' ) ) ) );
		?>

	<?php elseif ( ! YITH_WCAF_Affiliate_Handler()->is_user_affiliate() ) : ?>
		<p>
			<?php echo wp_kses_post( apply_filters( 'yith_wcaf_registration_form_become_affiliate_text', __( 'You\'re just one step away from becoming an affiliate!', 'yith-woocommerce-affiliates' ) ) ); ?>
		</p>
		<?php $become_an_affiliate_text = apply_filters( 'yith_wcaf_become_affiliate_button_text', __( 'Become an affiliate', 'yith-woocommerce-affiliates' ) ); ?>

		<form action="<?php echo esc_url( add_query_arg( 'become_an_affiliate', true ) ); ?>" method="POST">

			<?php
			if ( 'yes' === $show_additional_fields ) :
				$user_id = get_current_user_id();
				?>

				<?php if ( 'yes' === $show_name_field ) : ?>

					<?php
					$label    = apply_filters( 'yith_wcaf_first_name_label', __( 'First name', 'yith-woocommerce-affiliates' ) );
					$required = apply_filters( 'yith_wcaf_first_name_required', false );
					$value    = get_user_meta( $user_id, 'first_name', true );
					?>

					<p class="form-row form-row-wide">
						<label for="reg_first_name"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?></label>
						<input type="text" class="input-text" name="first_name" id="reg_first_name" value="<?php echo esc_attr( $value ); ?>"/>
					</p>

				<?php endif; ?>

				<?php if ( 'yes' === $show_surname_field ) : ?>

					<?php
					$label    = apply_filters( 'yith_wcaf_last_name_label', __( 'Last name', 'yith-woocommerce-affiliates' ) );
					$required = apply_filters( 'yith_wcaf_last_name_required', false );
					$value    = get_user_meta( $user_id, 'last_name', true );
					?>

					<p class="form-row form-row-wide">
						<label for="reg_last_name"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?></label>
						<input type="text" class="input-text" name="last_name" id="reg_last_name" value="<?php echo esc_attr( $value ); ?>"/>
					</p>

				<?php endif; ?>

				<?php if ( apply_filters( 'yith_wcaf_payment_email_required', true ) ) : ?>
					<p class="form-row form-row-wide">
						<label for="payment_email"><?php esc_html_e( 'Payment email address', 'yith-woocommerce-affiliates' ); ?>
							<span class="required">*</span></label>
						<input type="email" class="input-text" name="payment_email" id="payment_email" value="<?php echo ! empty( $_POST['payment_email'] ) ? esc_attr( wp_unslash( $_POST['payment_email'] ) ) : ''; ?>"/>
					</p>
				<?php endif; ?>

				<?php if ( 'yes' === $show_website_field ) : ?>

					<?php
					$label    = apply_filters( 'yith_wcaf_website_label', __( 'Website', 'yith-woocommerce-affiliates' ) );
					$required = apply_filters( 'yith_wcaf_website_required', true );
					$value    = get_user_meta( $user_id, '_yith_wcaf_website', true );
					?>

					<p class="form-row form-row-wide">
						<label for="website"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?></label>
						<input type="<?php echo esc_attr( apply_filters( 'yith_wcaf_website_type', 'url' ) ); ?>" class="input-text" name="website" id="website" value="<?php echo esc_attr( $value ); ?>"/>
					</p>

				<?php endif; ?>

				<?php if ( 'yes' === $show_promotional_method_field ) : ?>

					<?php
					$label    = apply_filters( 'yith_wcaf_promotional_methods_label', __( 'How will you promote our site?', 'yith-woocommerce-affiliates' ) );
					$required = apply_filters( 'yith_wcaf_promotional_methods_required', true );
					$value    = get_user_meta( $user_id, '_yith_wcaf_promotional_method', true );
					?>

					<p class="form-row form-row-wide">
						<label for="how_promote"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?></label>
						<select name="how_promote" id="how_promote">
							<?php
							$how_promote_options = yith_wcaf_get_promote_methods();

							if ( ! empty( $how_promote_options ) ) :
								foreach ( $how_promote_options as $id => $label ) :
									?>
									<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id ); ?> ><?php echo esc_html( $label ); ?></option>
									<?php
								endforeach;
							endif;
							?>
						</select>
					</p>

					<?php
					$label    = apply_filters( 'yith_wcaf_custom_promote_label', __( 'Specify how will you promote our site', 'yith-woocommerce-affiliates' ) );
					$required = apply_filters( 'yith_wcaf_custom_promote_required', true );
					$value    = get_user_meta( $user_id, '_yith_wcaf_custom_method', true );
					?>

					<p class="form-row form-row-wide">
						<label for="custom_promote"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?></label>
						<textarea name="custom_promote" id="custom_promote"><?php echo esc_html( $value ); ?></textarea>
					</p>
				<?php endif; ?>

				<?php if ( 'yes' === $show_terms_field ) : ?>
					<?php
					$terms_link = sprintf( '<a target="_blank" href="%s">%s</a>', $terms_anchor_url, $terms_anchor_text );
					$label      = apply_filters( 'yith_wcaf_terms_label', str_replace( '%TERMS%', $terms_link, $terms_label ) );
					$required   = apply_filters( 'yith_wcaf_terms_required', true );
					?>
					<p class="form-row form-row-wide">
						<label for="terms">
							<input type="checkbox" name="terms" id="terms" value="yes" <?php checked( isset( $_POST['terms'] ) ); ?> />
							<?php echo wp_kses_post( $label ); ?><?php echo $required ? ' <span class="required">*</span>' : ''; ?>
						</label>
					</p>
				<?php endif; ?>

			<?php endif; ?>

			<?php do_action( 'yith_wcaf_register_form' ); ?>

			<button class="btn button"><?php echo esc_html( $become_an_affiliate_text ); ?></button>
		</form>
		<?php

	elseif ( YITH_WCAF_Affiliate_Handler()->is_user_enabled_affiliate() ) :
		?>
		<p class="already-an-affiliate woocommerce-info">
			<?php echo wp_kses_post( apply_filters( 'yith_wcaf_registration_form_already_affiliate_text', __( 'You have already affiliated with us. Thank you!', 'yith-woocommerce-affiliates' ) ) ); ?>
		</p>
		<?php
	elseif ( YITH_WCAF_Affiliate_Handler()->is_user_pending_affiliate() ) :
		?>
		<p class="pending-request woocommerce-info">
			<?php echo wp_kses_post( apply_filters( 'yith_wcaf_registration_form_affiliate_pending_text', __( 'Your request has been registered and it is awaiting administrators approval!', 'yith-woocommerce-affiliates' ) ) ); ?>
		</p>
		<?php
	elseif ( YITH_WCAF_Affiliate_Handler()->is_user_rejected_affiliate() ) :
		$reject_message = get_user_meta( get_current_user_id(), '_yith_wcaf_reject_message', true );

		if ( ! $reject_message ) {
			$reject_message = get_option( 'yith_wcaf_ban_reject_global_message', '' );
		}

		if ( ! $reject_message ) {
			$reject_message = __( 'We regretfully inform you that we can\'t accept your request as it doesn\'t match our requirements.', 'yith-woocommerce-affiliates' );
		}

		?>
		<p class="rejected-request woocommerce-info">
			<?php echo wp_kses_post( apply_filters( 'yith_wcaf_registration_form_affiliate_disabled_text', $reject_message ) ); ?>
		</p>
		<?php
	endif;
	?>

</div>
