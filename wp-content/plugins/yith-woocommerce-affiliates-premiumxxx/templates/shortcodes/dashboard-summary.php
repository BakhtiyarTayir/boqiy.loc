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
				<div class="uap-row">
					<div class="uapcol-md-3 uap-account-overview-tab1">
						<div class="uap-account-no-box uap-account-box-green uap-no-padding">
							<div class="uap-account-no-box-inside">
								<div class="uap-count"> <?php echo wc_price( $referral_stats['paid'] );  ?> </div>
								<div class="uap-detail"><?php esc_html_e( 'Total Paid', 'yith-woocommerce-affiliates' ); ?></div>
								
							</div>
						</div>
					</div>
					<div class="uapcol-md-3 uap-account-overview-tab1">
						<div class="uap-account-no-box uap-account-box-lightblue uap-no-padding">
							<div class="uap-account-no-box-inside">
								<div class="uap-count"><?php echo esc_html( $referral_stats['click'] ); ?></div>
								<div class="uap-detail"><?php esc_html_e( 'Visits', 'yith-woocommerce-affiliates' ); ?></div>
								
							</div>
						</div>
					</div>
					<div class="uapcol-md-3 uap-account-overview-tab1">
						<div class="uap-account-no-box uap-account-box-lightyellow uap-no-padding">
							<div class="uap-account-no-box-inside">
								<div class="uap-count"> <?php echo wc_price( $referral_stats['earnings'] );  ?> </div>
								<div class="uap-detail"><?php esc_html_e( 'Total Earnings', 'yith-woocommerce-affiliates' ); ?></div>
								
							</div>
						</div>
					</div>
				</div>
				<h3><?php esc_html_e( 'Payments', 'yith-woocommerce-affiliates' ); ?></h3>
				<div class="uap-row">				

					<div class="uapcol-md-2 uap-account-overview-tab6">
						<div class="uap-account-no-box uap-account-box-blue">
							<div class="uap-account-no-box-inside">
								<div class="uap-count"> <?php echo wc_price( $referral_stats['balance'] );  ?></div>
								<div class="uap-detail"><?php esc_html_e( 'Your Balance', 'yith-woocommerce-affiliates' ); ?></div>
								<div class="uap-subnote"><?php esc_html_e( 'Bonuses for sales accrued', 'yith-woocommerce-affiliates' ); ?></div>
							</div>
						</div>

					</div>
					<div class="uapcol-md-2 uap-account-overview-tab5">
							<div class="uap-account-no-box uap-account-box-lightgray">
								<div class="uap-account-no-box-inside">
								<?php if( ! $can_withdraw ): ?>
									<?php echo apply_filters( 'yith_wcaf_affiliate_cannot_withdraw_message', __('You already have an active payment request. Please, wait administator approval!','yith-woocommerce-affiliates' ) ) ?>
									<?php else: ?>
										<form method="POST" enctype="multipart/form-data">
											<div class="uap-row">
												
												

												<?php if ( apply_filters( 'yith_wcaf_payment_email_required', true )  ) : ?>
													<div class="second-step uapcol-md-6">
													

														<?php if ( apply_filters( 'yith_wcaf_payment_email_required', true ) ) : ?>
															<p class="form-row">
																<label for="payment_email"><?php esc_html_e( 'Card number', 'yith-woocommerce-affiliates' ); ?></label>
																<input class="width-1" type="number" id="payment_email" name="payment_email" value="<?php echo esc_attr( $payment_email ); ?>" />
															</p>
														<?php endif; ?>
													</div>
												<?php endif; ?>
												<div class="first-step uapcol-md-3">
													<div class="withdraw-amount-container">
														<p class="form-row form-row-wide">
															<label for="withdraw_amount"><?php esc_html_e( 'Amount', 'yith-woocommerce-affiliates' ); ?></label>
															<span class="withdraw-amount">															
																<input class="width-1" type="number" step="<?php echo esc_attr( apply_filters( 'yith_wcaf_withdraw_amount_step', '0.01' ) ); ?>" min="<?php echo esc_attr( $min_withdraw ); ?>" max="<?php echo esc_attr( $max_withdraw ); ?>" id="withdraw_amount" name="withdraw_amount" class="amount" value="<?php echo esc_attr( $current_amount ); ?>" />
															</span>
														</p>
													</div>
													
												</div>

												<?php wp_nonce_field( 'yith_wcaf_withdraw', '_withdraw_nonce' ); ?>

												
											</div>
											<input class="button submit" type="submit" value="<?php echo esc_attr( apply_filters( 'yith_wcaf_withdraw_submit_button', __( 'Withdraw Bonuses', 'yith-woocommerce-affiliates' ) ) ); ?>" />			
										</form>
									<?php endif; ?>

								</div>
							</div>
					</div>

				</div>
				


				<div class="uap-profile-box-wrapper">
					<div class="uap-profile-box-title"><span><?php esc_html_e( 'Balance History', 'yith-woocommerce-affiliates' ); ?></span></div>	
					<div class="uap-profile-box-content">		
						<div class="uap-row ">	
							<div class="uap-col-xs-12">	
								<table class="shop_table">
									<thead>
										<tr>
											<th class="column-id">
												<a rel="nofollow" class="<?php echo ( 'id' === $ordered ) ? 'ordered to-order-' . esc_attr( strtolower( $to_order ) ) : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'ID', 'order' => $to_order ) ) ); ?>"><?php esc_html_e( 'ID', 'yith-woocommerce-affiliates' ); ?></a>
											</th>
											<th class="column-status">
												<a rel="nofollow" class="<?php echo ( 'status' === $ordered ) ? 'ordered to-order-' . esc_attr( strtolower( $to_order ) ) : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'status', 'order' => $to_order ) ) ); ?>"><?php esc_html_e( 'Status', 'yith-woocommerce-affiliates' ); ?></a>
											</th>
											<th class="column-amount">
												<a rel="nofollow" class="<?php echo ( 'amount' === $ordered ) ? 'ordered to-order-' . esc_attr( strtolower( $to_order ) ) : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'amount', 'order' => $to_order ) ) ); ?>"><?php esc_html_e( 'Amount', 'yith-woocommerce-affiliates' ); ?></a>
											</th>
											<th class="column-created_at">
												<a rel="nofollow" class="<?php echo ( 'created_at' === $ordered ) ? 'ordered to-order-' . esc_attr( strtolower( $to_order ) ) : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'created_at', 'order' => $to_order ) ) ); ?>"><?php esc_html_e( 'Created at', 'yith-woocommerce-affiliates' ); ?></a>
											</th>
											<th class="column-completed_at">
												<a rel="nofollow" class="<?php echo ( 'completed_at' === $ordered ) ? 'ordered to-order-' . esc_attr( strtolower( $to_order ) ) : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'completed_at', 'order' => $to_order ) ) ); ?>"><?php esc_html_e( 'Completed at', 'yith-woocommerce-affiliates' ); ?></a>
											</th>										
										</tr>
									</thead>
									<tbody>
									<?php if ( ! empty( $payments ) ) : ?>
										<?php foreach ( $payments as $payment ) : ?>
											<tr>
												<td class="column-id">#<?php echo esc_html( $payment['ID'] ); ?></td>
												<td class="column-status <?php echo esc_attr( $payment['status'] ); ?>"><?php echo esc_html( YITH_WCAF_Payment_Handler()->get_readable_status( $payment['status'] ) ); ?></td>
												<td class="column-amount"><?php echo wc_price( $payment['amount'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
												<td class="column-create_at"><?php echo esc_html( date_i18n( wc_date_format(), strtotime( $payment['created_at'] ) ) ); ?></td>
												<td class="column-completed_at"><?php echo esc_html( date_i18n( wc_date_format(), strtotime( $payment['completed_at'] ) ) ); ?></td>
												
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr>
											<td class="empty-set" colspan="6"><?php esc_html_e( 'Sorry! There are no registered payments yet', 'yith-woocommerce-affiliates' ); ?></td>
										</tr>
									<?php endif; ?>
									</tbody>
								</table>

								<?php if ( ! empty( $page_links ) ) : ?>
								<nav class="woocommerce-pagination">
									<?php echo $page_links; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</nav>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>				
			</div>
		<?php endif; ?>
	</div>

	<?php do_action( 'yith_wcaf_after_dashboard_summary' ); ?>

</div>
