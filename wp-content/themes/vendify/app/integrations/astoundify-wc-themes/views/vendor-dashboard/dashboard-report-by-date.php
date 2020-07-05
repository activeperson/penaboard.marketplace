<?php
/**
 * Dashboard Page: Chart Section
 *
 * The overview data is added via JS (REST API).
 * The default view for the chart is current month report.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Load Scripts.
wp_enqueue_script( 'astoundify-wc-themes-vendors-dashboard-report-by-date' );
wp_enqueue_style( 'astoundify-wc-themes-date-picker' );
?>

<section class="row" id="astoundify-wc-themes-dashboard-report-by-date">
	<div class="col-lg-10 mr-auto ml-auto">
		<div class="chart">

			<div class="chart__header">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<span class="nav-link nav-link--metric active">
							<span class="nav-link__metric__value"><span class="total_commission">0</span></span>
							<span class="nav-link__metric__name"><?php esc_html_e( 'Earnings', 'vendify' ); ?></span>
						</span>
					</li>

					<li class="nav-item">
						<span class="nav-link disabled nav-link--metric">
							<span class="nav-link__metric__value"><span class="total_items">0</span></span>
							<span class="nav-link__metric__name"><?php esc_html_e( 'Sales', 'vendify' ); ?></span>
						</span>
					</li>

					<li class="nav-item">
						<span class="nav-link disabled nav-link--metric">
							<span class="nav-link__metric__value"><span class="total_orders">0</span></span>
							<span class="nav-link__metric__name"><?php esc_html_e( 'Purchases', 'vendify' ); ?></span>
						</span>
					</li>

					<li class="nav-item">
						<span class="nav-link disabled nav-link--metric">
							<span class="nav-link__metric__value"><span class="total_reviews">0</span></span>
							<span class="nav-link__metric__name"><?php esc_html_e( 'Reviews', 'vendify' ); ?></span>
						</span>
					</li>

					<li class="nav-item chart__timepicker">
						<form id="dashboard-reports-form" method="GET" action="<?php echo esc_url( astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'dashboard' ) ); ?>">
							<input id="reports-start-date-input" type="text" value="<?php echo esc_attr( date( 'Y-m-d', strtotime( 'First day of this month' ) ) ); ?>" name="start_date" class="form-control form-control-sm" />
							to
							<input id="reports-end-date-input" type="text" value="<?php echo esc_attr( date( 'Y-m-d', strtotime( 'Last day of this month' ) ) ); ?>" name="end_date" class="form-control form-control-sm" />
							<input type="hidden" value="custom" name="range">
						</form>
					</li>
				</ul>
			</div>

			<div class="chart-container chart__body">
				<canvas class="chart-commission-placeholder main"></canvas>
			</div>

		</div>
	</div>
</section><!-- #astoundify-wc-themes-dashboard-report-by-date -->
