<?php
/**
 * Dashboard reports.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Theme
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<section class="chart">
	<header class="chart__header">
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a href="" class="nav-link nav-link--metric active">
					<span class="nav-link__metric__value">$8,827</span>
					<span class="nav-link__metric__name">Earnings</span>
				</a>
			</li>

			<li class="nav-item">
				<a href="" class="nav-link nav-link--metric">
					<span class="nav-link__metric__value">347</span>
					<span class="nav-link__metric__name">Sales</span>
				</a>
			</li>

			<li class="nav-item">
				<a href="" class="nav-link nav-link--metric">
					<span class="nav-link__metric__value">229</span>
					<span class="nav-link__metric__name">Customers</span>
				</a>
			</li>

			<li class="nav-item">
				<a href="" class="nav-link nav-link--metric">
					<span class="nav-link__metric__value">107</span>
					<span class="nav-link__metric__name">Reviews</span>
				</a>
			</li>

			<li class="nav-item chart__timepicker">
				<input class="form-control form-control-sm" type="text" placeholder="01/15">
				to
				<input class="form-control form-control-sm" type="text" placeholder="01/15">
			</li>
		</ul>
	</header>

	<div class="chart__body" style="height: auto;"> <!-- The inline style is for holding the dummy image. Remove. -->

		<picture class="img-fluid">
			<source srcset="/assets/images/tmp/chart@2x.png" media="(min-width: 576px)">
			<img class="img-fluid" src="/assets/images/tmp/chart-small@2x.png">
		</picture>
	</div>
</section>
