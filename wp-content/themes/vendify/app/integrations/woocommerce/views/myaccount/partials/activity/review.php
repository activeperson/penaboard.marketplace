<?php
/**
 * Dashboard activity review item.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>

<div class="activity__item activity__item--review">
	<?php
	svg(
		[
			'icon'    => 'star',
			'classes' => [ 'ico--sm' ],
		]
	); ?>
	<span class="activity__thumbnail">
		<?php echo $product_thumbnail; // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</span>

	<div class="activity__item__content">
		<span class="activity__text">
			<?php
			printf(
				__( 'You left a %1$s star review on %2$s', 'vendify' ),
				esc_html( $star_count ),
				sprintf(
					'<a class="link" href="' . esc_url( $product_url ) . '">%s</a>',
					esc_html( $product_name )
				)
			); ?>
		</span>
	</div>

	<span class="activity__date"><?php printf( '%s ago', human_time_diff( $timestamp, current_time( 'timestamp' ) ) ); ?></span>
</div>
