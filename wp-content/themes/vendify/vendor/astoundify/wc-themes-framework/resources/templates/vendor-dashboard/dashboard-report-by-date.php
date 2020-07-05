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
?>

<div id="astoundify-wc-themes-dashboard-report-by-date">
	<h2 class="dashboard-section-title"><?php esc_html_e( 'Reports By Date', 'astoundify-wc-themes' ); ?></h2>

		<form id="dashboard-reports-form" method="GET" action="<?php echo esc_url( astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'dashboard' ) ); ?>">
			<input id="reports-start-date-input" type="text" value="<?php echo esc_attr( date( 'Y-m-d', strtotime( 'First day of this month' ) ) ); ?>" name="start_date">
			<input id="reports-end-date-input" type="text" value="<?php echo esc_attr( date( 'Y-m-d', strtotime( 'Last day of this month' ) ) ); ?>" name="end_date">
			<input type="hidden" value="custom" name="range">
		</form>

		<ul class="dashboard-reports">
			<li>
				<strong><?php printf( esc_html__( 'Earnings: %s', 'astoundify-wc-themes' ), '<span class="total_commission">0</span>' ); ?></strong>
			</li>
			<li>
				<?php printf( esc_html__( 'Sales: %s', 'astoundify-wc-themes' ), '<span class="total_items">0</span>' ); ?>
			</li>
			<li>
				<?php printf( esc_html__( 'Orders: %s', 'astoundify-wc-themes' ), '<span class="total_orders">0</span>' ); ?>
			</li>
			<li>
				<?php printf( esc_html__( 'Reviews: %s', 'astoundify-wc-themes' ), '<span class="total_reviews">0</span>' ); ?>
			</li>
		</ul>

		<div class="chart-container">
			<canvas class="chart-commission-placeholder main"></canvas>
		</div>

</div><!-- #astoundify-wc-themes-dashboard-report-by-date -->
