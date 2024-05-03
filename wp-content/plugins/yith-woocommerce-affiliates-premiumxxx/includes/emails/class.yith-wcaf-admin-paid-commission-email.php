<?php
/**
 * Paid Commission class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Affiliates
 * @version 1.0.0
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

if ( ! class_exists( 'YITH_WCAF_Admin_Paid_Commission_Email' ) ) {
	/**
	 * New affiliate email
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Admin_Paid_Commission_Email extends WC_Email {

		/**
		 * Constructor method, used to return object of the class to WC
		 *
		 * @return \YITH_WCAF_Admin_Paid_Commission_Email
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->id          = 'payment_sent';
			$this->title       = __( 'Payment Sent', 'yith-woocommerce-affiliates' );
			$this->description = __( 'This email is sent to admins each time a payment to an affiliate is issued', 'yith-woocommerce-affiliates' );

			$this->heading = __( 'Payment Sent', 'yith-woocommerce-affiliates' );
			$this->subject = __( '[{site_title}] New affiliate payment sent', 'yith-woocommerce-affiliates' );

			$this->content_html = $this->get_option( 'content_html' );
			$this->content_text = $this->get_option( 'content_text' );

			$this->template_html  = 'emails/admin-paid-commission-email.php';
			$this->template_plain = 'emails/plain/admin-paid-commission-email.php';


			// Triggers for this email
			add_action( 'yith_wcaf_payments_sent_notification', array( $this, 'trigger' ), 10, 1 );

			// Call parent constructor
			parent::__construct();

			// Other settings
			$this->recipient = $this->get_option( 'recipient' );

			if ( ! $this->recipient ) {
				$this->recipient = get_option( 'admin_email' );
			}
		}

		/**
		 * Method triggered to send email
		 *
		 * @param $affiliate_id int New affiliate id
		 *
		 * @return void
		 */
		public function trigger( $payment_instances ) {
			$this->object = array();

			if ( ! empty( $payment_instances ) ) {
				foreach ( $payment_instances as $payment_id ) {
					$this->object[ $payment_id ] = YITH_WCAF_Payment_Handler()->get_payment( $payment_id );
				}
			}

			if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
				return;
			}

			$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
		}

		/**
		 * Check if mail is enabled
		 *
		 * @return bool Whether email notification is enabled or not
		 * @since 1.0.0
		 */
		public function is_enabled() {
			$notify_admin = get_option( 'yith_wcaf_payment_pending_notify_admin' );

			return $notify_admin == 'yes';
		}

		/**
		 * Get HTML content for the mail
		 *
		 * @return string HTML content of the mail
		 * @since 1.0.0
		 */
		public function get_content_html() {
			ob_start();
			yith_wcaf_get_template( $this->template_html, array(
				'payments'      => $this->object,
				'currency'      => apply_filters( 'yith_wcaf_email_currency', get_woocommerce_currency(), $this ),
				'email_heading' => $this->get_heading(),
				'email'         => $this,
				'sent_to_admin' => true,
				'plain_text'    => false
			) );

			return ob_get_clean();
		}

		/**
		 * Get plain text content of the mail
		 *
		 * @return string Plain text content of the mail
		 * @since 1.0.0
		 */
		public function get_content_plain() {
			ob_start();
			yith_wcaf_get_template( $this->template_plain, array(
				'payments'      => $this->object,
				'currency'      => apply_filters( 'yith_wcaf_email_currency', get_woocommerce_currency(), $this ),
				'email_heading' => $this->get_heading(),
				'email'         => $this,
				'sent_to_admin' => true,
				'plain_text'    => true
			) );

			return ob_get_clean();
		}

		/**
		 * Init form fields to display in WC admin pages
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function init_form_fields() {
			$this->form_fields = array(
				'recipient'  => array(
					'title'       => __( 'Recipient(s)', 'woocommerce' ),
					'type'        => 'text',
					'description' => sprintf( __( 'Enter recipients (comma separated) for this email. Defaults to <code>%s</code>.', 'woocommerce' ), esc_attr( get_option( 'admin_email' ) ) ),
					'placeholder' => '',
					'default'     => ''
				),
				'subject'    => array(
					'title'       => __( 'Subject', 'woocommerce' ),
					'type'        => 'text',
					'description' => sprintf( __( 'This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', 'woocommerce' ), $this->subject ),
					'placeholder' => '',
					'default'     => ''
				),
				'heading'    => array(
					'title'       => __( 'Email Heading', 'woocommerce' ),
					'type'        => 'text',
					'description' => sprintf( __( 'This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.', 'woocommerce' ), $this->heading ),
					'placeholder' => '',
					'default'     => ''
				),
				'email_type' => array(
					'title'       => __( 'Email type', 'woocommerce' ),
					'type'        => 'select',
					'description' => __( 'Choose which format of email to send.', 'woocommerce' ),
					'default'     => 'html',
					'class'       => 'email_type wc-enhanced-select',
					'options'     => $this->get_email_type_options()
				)
			);
		}
	}
}

return new YITH_WCAF_Admin_Paid_Commission_Email();