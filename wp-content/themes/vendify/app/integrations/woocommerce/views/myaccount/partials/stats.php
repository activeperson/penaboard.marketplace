<?php
/**
 * Dashboard stats.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Theme
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>

<section class="metric-display">
	<div class="metric">
		<?php
		svg(
			[
				'icon'    => 'sales-average',
				'classes' => [ 'ico--lg' ],
			]
		); ?>
		<span class="metric__value">1,974</span>
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
		<span class="metric__value">5,972</span>
		<span class="metric__name"><?php esc_html_e( 'Total Sales', 'vendify' ); ?></span>
	</div>

	<div class="metric">
		<?php
		svg(
			[
				'icon'    => 'star-rating-outline',
				'classes' => [ 'ico--lg' ],
			]
		); ?>
		<span class="metric__value">4.7</span>
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
		<span class="metric__value">4,378</span>
		<span class="metric__name"><?php esc_html_e( 'Total Reviews','vendify' ); ?></span>
	</div>
</section>
