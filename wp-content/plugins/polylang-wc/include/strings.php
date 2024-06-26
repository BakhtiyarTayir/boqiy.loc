<?php

/**
 * Manage the strings translations
 *
 * @since 0.1
 */
class PLLWC_Strings {

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	public function __construct() {
		// Translate strings in emails
		add_action( 'pllwc_email_language', array( $this, 'translate_emails' ) );

		if ( PLL() instanceof PLL_Frontend ) {
			// Translate strings on frontend
			add_action( 'init', array( $this, 'translate_strings' ) );
		} else {
			if ( PLL() instanceof PLL_Settings ) {
				// Register strings
				// Priority 99 in case gateways are registered in the same hook. See WooCommerce Invoice Gateway.
				add_action( 'init', array( $this, 'register_strings' ), 99 );
				add_filter( 'pll_sanitize_string_translation', array( $this, 'sanitize_strings' ), 10, 3 );
			}

			add_filter( 'woocommerce_attribute_label', array( $this, 'attribute_label' ), 10, 3 );
		}

		// Register strings
		if ( PLL() instanceof PLL_Settings ) {
			add_filter( 'pll_sanitize_string_translation', array( $this, 'sanitize_strings' ), 10, 3 );
		}

		// Translate strings in emails
		add_action( 'pllwc_email_language', array( $this, 'translate_emails' ) );

		// Translate strings on frontend
		if ( PLL() instanceof PLL_Frontend ) {
			add_action( 'init', array( $this, 'translate_strings' ) );
		} else {
			add_filter( 'woocommerce_attribute_label', array( $this, 'attribute_label' ), 10, 3 );
		}
	}

	/**
	 * Returns options to translate
	 * Don't call before 'init' to avoid loading WooCommerce translations sooner than WooCommerce
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	protected static function get_options() {
		return array(
			'email_footer_text'                           => array( 'name' => __( 'Footer text', 'woocommerce' ), 'multiline' => true ),
			'demo_store_notice'                           => array( 'name' => __( 'Store notice text', 'woocommerce' ), 'multiline' => true ),
			'price_display_suffix'                        => array( 'name' => 'price_display_suffix' ),
			'currency_pos'                                => array( 'name' => __( 'Currency position', 'woocommerce' ) ),
			'price_thousand_sep'                          => array( 'name' => __( 'Thousand separator', 'woocommerce' ) ),
			'price_decimal_sep'                           => array( 'name' => __( 'Decimal separator', 'woocommerce' ) ),
			'registration_privacy_policy_text'            => array( 'name' => __( 'Registration privacy policy', 'woocommerce' ), 'multiline' => true ),
			'checkout_privacy_policy_text'                => array( 'name' => __( 'Checkout privacy policy', 'woocommerce' ), 'multiline' => true ),
			'checkout_terms_and_conditions_checkbox_text' => array( 'name' => __( 'Terms and conditions', 'woocommerce' ) ),
		);
	}

	/**
	 * Test whether an email property should be translated
	 *
	 * @since 0.1
	 *
	 * @param string $prop Property name.
	 * @return bool
	 */
	protected function is_translated_email_property( $prop ) {
		return 0 === strpos( $prop, 'subject' ) || 0 === strpos( $prop, 'heading' ) || 0 === strpos( $prop, 'additional_content' );
	}

	/**
	 * Test whether a gateway property should be translated
	 * Verifies that the property has been saved in database
	 *
	 * @since 0.1
	 * @since 0.9 Add $gateway parameter
	 *
	 * @param string $prop    Property name.
	 * @param object $gateway WC_Payment_Gateway object.
	 * @return bool
	 */
	protected function is_translated_gateway_property( $prop, $gateway = null ) {
		if ( empty( $gateway ) ) {
			return in_array( $prop, array( 'title', 'description', 'instructions' ) );
		} else {
			$settings = get_option( 'woocommerce_' . $gateway->id . '_settings' );
			return in_array( $prop, array( 'title', 'description', 'instructions' ) ) && ! empty( $settings[ $prop ] );
		}
	}

	/**
	 * Test whether a shipping property should be translated
	 *
	 * @since 0.1
	 *
	 * @param string $prop Property name.
	 * @return bool
	 */
	protected function is_translated_shipping_property( $prop ) {
		return 'title' === $prop;
	}

	/**
	 * Test whether a gateway property input field should be multiline
	 *
	 * @since 0.1
	 *
	 * @param string $prop Property name.
	 * @return bool
	 */
	protected function is_gateway_property_multiline( $prop ) {
		return 'title' !== $prop;
	}

	/**
	 * Register sub strings
	 *
	 * @since 0.1
	 *
	 * @param array    $objects          Array of objects having properties to translate.
	 * @param callback $is_translated_cb Function testing if a property should be translated.
	 * @param callback $is_multiline_cb  Function testing if the input field should be multiline (default to false).
	 */
	protected function register_sub_options( $objects, $is_translated_cb, $is_multiline_cb = '__return_false' ) {
		foreach ( $objects as $obj ) {
			if ( ! isset( $obj->enabled ) || 'no' !== $obj->enabled ) {
				foreach ( array_keys( $obj->form_fields ) as $prop ) {
					if ( call_user_func( $is_translated_cb, $prop, $obj ) ) {
						if ( ! empty( $obj->settings[ $prop ] ) ) {
							pll_register_string( $prop . '_' . $obj->id, $obj->settings[ $prop ], 'WooCommerce', call_user_func( $is_multiline_cb, $prop ) );
						} elseif ( ! empty( $obj->$prop ) ) {
							pll_register_string( $prop . '_' . $obj->id, $obj->$prop, 'WooCommerce', call_user_func( $is_multiline_cb, $prop ) );
						}
					}
				}
			}
		}
	}

	/**
	 * Register strings
	 *
	 * @since 0.1
	 */
	public function register_strings() {
		global $wpdb;

		// Emails
		$this->register_sub_options(
			WC_Emails::instance()->get_emails(),
			array( $this, 'is_translated_email_property' )
		);

		// Gateways
		$this->register_sub_options(
			WC_Payment_Gateways::instance()->payment_gateways(),
			array( $this, 'is_translated_gateway_property' ),
			array( $this, 'is_gateway_property_multiline' )
		);

		// BACS Account details
		foreach ( get_option( 'woocommerce_bacs_accounts', array() ) as $account ) {
			pll_register_string( __( 'Account name', 'woocommerce' ), $account['account_name'], 'WooCommerce' );
			pll_register_string( __( 'Bank name', 'woocommerce' ), $account['bank_name'], 'WooCommerce' );
		}

		// Shipping methods
		// FIXME backward compatibility with WC < 2.6 (maybe kept in WC 2.6+ for sites not using shipping zones?)
		$this->register_sub_options(
			WC_Shipping::instance()->get_shipping_methods(),
			array( $this, 'is_translated_shipping_property' )
		);

		// Shipping methods in shipping zones
		$zone = new WC_Shipping_Zone( 0 ); // Rest of the the world.
		foreach ( $zone->get_shipping_methods() as $method ) {
			pll_register_string( 'title_0_' . $method->id, $method->title, 'WooCommerce' );
		}

		foreach ( WC_Shipping_Zones::get_zones() as $zone ) {
			foreach ( $zone['shipping_methods'] as $method ) {
				pll_register_string( 'title_' . $zone['zone_id'] . '_' . $method->id, $method->title, 'WooCommerce' );
			}
		}

		// Strings as single option
		foreach ( self::get_options() as $string => $arr ) {
			if ( $option = get_option( 'woocommerce_' . $string ) ) {
				pll_register_string( $arr['name'], $option, 'WooCommerce', ! empty( $arr['multiline'] ) );
			}
		}

		// Attributes labels
		foreach ( wc_get_attribute_taxonomies() as $attr ) {
			pll_register_string( __( 'Attribute', 'woocommerce' ), $attr->attribute_label, 'WooCommerce' );
		}

		// Tax rate labels
		$labels = $wpdb->get_col( "SELECT tax_rate_name FROM {$wpdb->prefix}woocommerce_tax_rates" );

		foreach ( $labels as $label ) {
			pll_register_string( __( 'Tax name', 'woocommerce' ), $label, 'WooCommerce' );
		}
	}

	/**
	 * Translated strings must be sanitized the same way WooCommerce does before they are saved
	 *
	 * @since 0.1
	 *
	 * @param string $translation The string translation.
	 * @param string $name        The name as defined in pll_register_string.
	 * @param string $context     The context as defined in pll_register_string.
	 * @return string sanitized translation
	 */
	public function sanitize_strings( $translation, $name, $context ) {
		if ( 'WooCommerce' === $context ) {
			// Options
			$is_text_field = in_array( $name, wp_list_pluck( self::get_options(), 'name' ) ) ||
				$this->is_translated_email_property( $name ) ||
				$this->is_translated_gateway_property( $name ) ||
				$this->is_translated_shipping_property( $name );

			if ( $is_text_field ) {
				$translation = wp_kses_post( trim( stripslashes( $translation ) ) );
			}

			// Account details
			if ( __( 'Account name', 'woocommerce' ) === $name || __( 'Bank name', 'woocommerce' ) === $name ) {
				$translation = wc_clean( wp_unslash( $translation ) );
			}

			if ( __( 'Currency position', 'woocommerce' ) === $name && ! in_array( $translation, array( 'left', 'right', 'left_space', 'right_space' ) ) ) {
				$translation = get_option( 'woocommerce_currency_pos', 'left' );
			}

			// Attributes labels
			if ( __( 'Attribute', 'woocommerce' ) === $name ) {
				$translation = wc_clean( stripslashes( $translation ) );
			}
		}
		return $translation;
	}

	/**
	 * Actions and filters to translate strings
	 *
	 * @since 0.1
	 */
	public function translate_strings() {
		// Gateway instructions in emails
		add_action( 'woocommerce_email_before_order_table', array( $this, 'translate_instructions' ), 5 ); // Before WooCommerce.

		// Gateways
		add_filter( 'woocommerce_gateway_title', 'pll__' );
		add_filter( 'woocommerce_gateway_description', 'pll__' );

		// Gateway instructions in thankyou page
		add_action( 'woocommerce_thankyou_bacs', array( $this, 'translate_instructions' ), 5 ); // Before WooCommerce.
		add_action( 'woocommerce_thankyou_cheque', array( $this, 'translate_instructions' ), 5 );
		add_action( 'woocommerce_thankyou_cod', array( $this, 'translate_instructions' ), 5 );

		add_filter( 'woocommerce_bacs_accounts', array( $this, 'translate_bacs_accounts' ) );

		// Shipping methods
		add_filter( 'woocommerce_package_rates', array( $this, 'translate_shipping' ) );

		if ( isset( $_COOKIE[ PLL_COOKIE ] ) && pll_current_language() !== $_COOKIE[ PLL_COOKIE ] ) {
			add_action( 'woocommerce_before_calculate_totals', array( $this, 'reset_shipping_language' ) );
		}

		// Shipping methods since WooCommerce 2.6
		add_filter( 'woocommerce_shipping_rate_label', 'pll__' );

		// Options
		foreach ( array_keys( self::get_options() ) as $string ) {
			add_filter( 'option_woocommerce_' . $string, 'pll__' );
		}

		// Attributes
		add_filter( 'woocommerce_attribute_taxonomies', array( $this, 'attribute_taxonomies' ) );
		add_filter( 'woocommerce_attribute_label', 'pll__' );

		// Tax rate labels
		add_filter( 'woocommerce_rate_label', 'pll__' );
		add_filter( 'woocommerce_find_rates', array( $this, 'find_rates' ) );
	}

	/**
	 * Translate emails subject, heading, footer
	 *
	 * @since 0.1
	 */
	public function translate_emails() {
		// FIXME Backward compatibility with WC < 3.1
		if ( version_compare( WC()->version, '3.1', '<' ) ) {
			foreach ( WC_Emails::instance()->get_emails() as $email ) {
				foreach ( $email as $prop => $value ) {
					if ( $this->is_translated_email_property( $prop ) ) {
						$email->$prop = pll__( $value );
					}
				}

				if ( ! empty( $email->settings ) ) {
					foreach ( $email->settings as $prop => $value ) {
						if ( $this->is_translated_email_property( $prop ) ) {
							$email->settings[ $prop ] = pll__( $value );
						}
					}
				}
			}
		} else {
			add_filter( 'woocommerce_email_get_option', array( $this, 'translate_email_option' ), 10, 4 );
		}

		// These filters are added by Polylang but not on admin
		foreach ( array( 'option_blogname', 'option_blogdescription', 'option_date_format', 'option_time_format' ) as $filter ) {
			add_filter( $filter, 'pll__', 1 );
		}

		// Other strings
		$this->translate_strings();
	}

	/**
	 * Translate emails options such as subject and heading
	 *
	 * @since 0.8
	 *
	 * @param string $value  String to translate.
	 * @param object $email  Instance of WC_Email, not used.
	 * @param string $_value Same as $value, not used.
	 * @param string $key    Option name.
	 */
	public function translate_email_option( $value, $email, $_value, $key ) {
		if ( $this->is_translated_email_property( $key ) ) {
			$value = pll__( $value );
		}
		return $value;
	}

	/**
	 * Translate instructions in thankyou page or email
	 *
	 * @since 0.1
	 */
	public function translate_instructions() {
		$gateways = WC_Payment_Gateways::instance()->get_available_payment_gateways();
		foreach ( $gateways as $key => $gateway ) {
			if ( isset( $gateway->instructions ) ) {
				$gateways[ $key ]->instructions = pll__( $gateway->instructions );
			}
		}
	}

	/**
	 * Translate account names and bank names
	 *
	 * @since 1.2
	 *
	 * @param array $accounts Array of account details.
	 * @return array
	 */
	public function translate_bacs_accounts( $accounts ) {
		foreach ( $accounts as $k => $account ) {
			$accounts[ $k ]['account_name'] = pll__( $account['account_name'] );
			$accounts[ $k ]['bank_name'] = pll__( $account['bank_name'] );
		}
		return $accounts;
	}

	/**
	 * Translate the shipping methods titles
	 *
	 * @since 0.1
	 *
	 * @param array $rates Array of WC_Shipping_Rate objects.
	 * @return array
	 */
	public function translate_shipping( $rates ) {
		foreach ( $rates as $key => $rate ) {
			$rates[ $key ]->label = pll__( $rate->label );
		}
		return $rates;
	}

	/**
	 * Reset the shipping in session in case a user switches the language
	 *
	 * @since 0.1
	 *
	 * @param object $cart WC_Cart object.
	 */
	public function reset_shipping_language( $cart ) {
		unset( WC()->session->shipping_for_package ); // Since WooCommerce 2.5.
	}

	/**
	 * Translates attributes labels
	 *
	 * @since 0.1
	 *
	 * @param array $attribute_taxonomies Attribute taxonomies.
	 * @return array
	 */
	public function attribute_taxonomies( $attribute_taxonomies ) {
		foreach ( $attribute_taxonomies as $attr ) {
			$attr->attribute_label = pll__( $attr->attribute_label );
		}
		return $attribute_taxonomies;
	}

	/**
	 * Translates tax rates labels
	 *
	 * @since 1.2
	 *
	 * @param array $rates An array of tax rates.
	 * @return array
	 */
	public function find_rates( $rates ) {
		foreach ( $rates as $k => $rate ) {
			$rates[ $k ]['label'] = pll__( $rate['label'] );
		}
		return $rates;
	}

	/**
	 * Translates an attribute label on admin
	 * Needed for variations titles since WC 2.7
	 *
	 * @since 0.7
	 *
	 * @param string $label   Attribute label.
	 * @param string $name    Taxonomy name, not used.
	 * @param object $product Product data.
	 * @return string
	 */
	public function attribute_label( $label, $name, $product ) {
		// Don't translate the attribute label as it would create new attributes if the file is imported back
		if ( $product && ! doing_action( 'wp_ajax_woocommerce_do_ajax_product_export' ) ) {
			$data_store = PLLWC_Data_Store::load( 'product_language' );

			$lang     = $data_store->get_language( $product->get_id() );
			$language = PLL()->model->get_language( $lang );

			$mo = new PLL_MO();
			$mo->import_from_db( $language );
			return $mo->translate( $label );
		}
		return $label;
	}
}
