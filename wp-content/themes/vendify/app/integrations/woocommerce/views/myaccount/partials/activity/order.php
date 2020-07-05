<?php
/**
 * Dashboard activity order item.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="activity__item activity__item--purchase">
	<?php
	svg(
		[
			'icon'    => $icon,
			'classes' => [ 'ico--sm' ],
		]
	); ?>

	<div class="activity__item__content">

		<span class="activity__text">
			<?php
			printf(
				__( 'You placed a %1$s for %2$s', 'vendify' ),
				sprintf(
					'<a href="%s">%s order</a>',
					esc_url( $link ),
					$price
				),
				sprintf( _n( '%s item', '%s items', $count, 'vendify' ), $count )
			); ?>
		</span>
	</div>

	<span class="activity__date"><?php printf( '%s ago', human_time_diff( $timestamp, current_time( 'timestamp' ) ) ); ?></span>
</div>
