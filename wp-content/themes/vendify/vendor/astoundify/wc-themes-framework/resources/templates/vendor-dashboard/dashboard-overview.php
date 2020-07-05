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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Load Scripts.
wp_enqueue_script( 'astoundify-wc-themes-vendors-dashboard-overview' );
?>

<div id="astoundify-wc-themes-dashboard-overview">
	<h2 class="dashboard-section-title"><?php esc_html_e( 'Overview', 'astoundify-wc-themes' ); ?></h2>

	<ul>
		<li>
			<?php
				// Translators: %s Weekly average amount.
				printf( esc_html__( 'Weekly Earnings Average: %s', 'astoundify-wc-themes' ), '<span id="weekly_average">0</span>' );
			?>
		</li>
		<li>
			<?php
				// Translators: %s Total sales.
				printf( esc_html__( 'Total Sales: %s', 'astoundify-wc-themes' ), '<span id="total_items_sold">0</span>' );
			?>
		</li>
		<li>
			<?php
				// Translators: %s Average rating.
				printf( esc_html__( 'Average Ratings: %s', 'astoundify-wc-themes' ), '<span id="average_ratings">0</span>' ); ?>
		</li>
		<li>
			<?php
				// Translators: %s Total reviews.
				printf( esc_html__( 'Total Reviews: %s', 'astoundify-wc-themes' ), '<span id="total_reviews">0</span>' );
			?>
		</li>
	</ul>

</div>
