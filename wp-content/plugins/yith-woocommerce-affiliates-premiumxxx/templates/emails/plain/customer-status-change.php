<?php
/**
 * Affiliate status change
 *
 * @author Your Inspiration Themes
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

echo "= " . $email_heading . " =\n\n";
echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

printf( __( 'Hi %s,', 'yith-woocommerce-affiliates' ), $display_name );
echo "\n\n";
echo __( 'An administrator just reviewed your affiliate account, and updated its status', 'yith-woocommerce-affiliates' );
echo "\n";
printf( __( 'Now your affiliate account is: %s.', 'yith-woocommerce-affiliates' ), $new_status );
echo "\n";

echo "\n==========\n\n";

echo "{message_text}\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";
echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
