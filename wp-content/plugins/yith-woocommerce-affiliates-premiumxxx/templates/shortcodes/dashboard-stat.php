<?php
/**
 * Affiliate Dashboard Summary
 *
 * @author Your Inspiration Themes
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

<div class="yith-wcaf yith-wcaf-dashboard-summary woocommerce">

	<?php
	if ( function_exists( 'wc_print_notices' ) ) {
		wc_print_notices();
	}
	?>

	<?php do_action( 'yith_wcaf_before_dashboard_summary' ); ?>

	

	<div class="dashboard-content">
		<!--NAVIGATION MENU-->
		<?php
		$atts = array(
			'show_right_column'    => $show_right_column,
			'show_left_column'     => $show_left_column,
			'show_dashboard_links' => $show_dashboard_links,
			'dashboard_links'      => $dashboard_links,
		);
		yith_wcaf_get_template( 'navigation-menu.php', $atts, 'shortcodes' );
		?>
		<?php if ( $show_left_column ) : ?>
			<div class="partner-content <?php echo ( ! $show_right_column ) ? 'full-width' : ''; ?>">
				<!--AFFILIATE STATS-->
				<?php if ( $show_referral_stats ) : ?>
					<div class="dashboard-title">
						<h2><?php esc_html_e( 'Stats', 'yith-woocommerce-affiliates' ); ?></h2>
					</div>

					<table class="shop_table stat_table">
						<tbody>
						<tr>
							<th><?php esc_html_e( 'Affiliate rate', 'yith-woocommerce-affiliates' ); ?></th>
							<td><?php echo sprintf ( apply_filters( 'yith_wcaf_display_format', '%1$s%2$s' ), yith_wcaf_number_format( $referral_stats['rate'], 2 ), esc_html( apply_filters( 'yith_wcaf_display_symbol', '%' ) ) ); ?></td>
						</tr>

						<tr>
							<th><?php esc_html_e( 'Total Earnings', 'yith-woocommerce-affiliates' ); ?></th>
							<td><?php echo wc_price( $referral_stats['earnings'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						</tr>

						<tr>
							<th><?php esc_html_e( 'Total Paid', 'yith-woocommerce-affiliates' ); ?></th>
							<td><?php echo wc_price( $referral_stats['paid'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Balance', 'yith-woocommerce-affiliates' ); ?></th>
							<td><?php echo wc_price( $referral_stats['balance'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						</tr>

						<tr>
							<th><?php esc_html_e( 'Visits', 'yith-woocommerce-affiliates' ); ?></th>
							<td><?php echo esc_html( $referral_stats['click'] ); ?></td>
						</tr>

						<tr>
							<th><?php esc_html_e( 'Conversion rate', 'yith-woocommerce-affiliates' ); ?></th>
							<td><?php echo ! empty( $referral_stats['conv_rate'] ) ? sprintf ( apply_filters( 'yith_wcaf_display_format', '%1$s%2$s' ), yith_wcaf_number_format( $referral_stats['conv_rate'], 2 ), esc_html( apply_filters( 'yith_wcaf_display_symbol', '%' ) ) ) : esc_html__( 'N/A', 'yith-woocommerce-affiliates' ); ?></td>
						</tr>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		

	</div>

	

	<?php do_action( 'yith_wcaf_after_dashboard_summary' ); ?>

</div>
