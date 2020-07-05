<?php
/**
 * Dashboard Page: Overview Section
 *
 * The overview data is added via JS (REST API)
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Load Scripts.
wp_enqueue_script( 'astoundify-wc-themes-vendors-dashboard-overview' ); ?>


<section class="row" id="astoundify-wc-themes-dashboard-overview">
	<div class="col-lg-10 mr-auto ml-auto">
		<div class="metric-display">
			<div class="metric">
				<?php
				svg(
					[
						'icon'    => 'sales-average',
						'classes' => [ 'ico--lg' ],
					]
				); ?>
				<span class="metric__value"><span id="weekly_average">0</span></span>
				<span class="metric__name"><?php esc_html_e( 'Weekly Average', 'vendify' ); ?></span>
			</div>

			<div class="metric">
				<?php
				svg(
					[
						'icon'    => 'sales-bag-green',
						'classes' => [ 'ico--lg' ],
					]
				); ?>
				<span class="metric__value"><span id="total_items_sold">0</span></span>
				<span class="metric__name"><?php esc_html_e( 'Items Sold', 'vendify' ); ?></span>
			</div>

			<div class="metric">
				<?php
				svg(
					[
						'icon'    => 'star-rating-outline',
						'classes' => [ 'ico--lg' ],
					]
				); ?>
				<span class="metric__value"><span id="average_ratings">0</span></span>
				<span class="metric__name"><?php esc_html_e( 'Average Rating', 'vendify' ); ?></span>
			</div>

			<div class="metric">
				<?php
				svg(
					[
						'icon'    => 'total-reviews',
						'classes' => [ 'ico--lg' ],
					]
				); ?>
				<span class="metric__value"><span id="total_reviews">0</span></span>
				<span class="metric__name"><?php esc_html_e( 'Total Reviews', 'vendify' ); ?></span>
			</div>
		</div>
	</div>
</section>
