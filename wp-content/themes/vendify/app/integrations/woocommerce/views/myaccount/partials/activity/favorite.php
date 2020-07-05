<?php
/**
 * Dashboard activity favorite item.
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

<div class="activity__item activity__item--favorite">
	<?php
	svg(
		[
			'icon'    => $icon,
			'classes' => [ 'ico--sm' ],
		]
	); ?>

	<span class="activity__thumbnail">
		<?php echo $thumbnail; ?>
	</span>

	<div class="activity__item__content">
		<span class="activity__text">
			<?php printf( __( 'You favorited %s', 'vendify' ), '<a href="' . esc_url( $link ) . '">' . $title . '</a>' ); ?>
		</span>
	</div>

	<span class="activity__date"><?php printf( '%s ago', human_time_diff( $timestamp, current_time( 'timestamp' ) ) ); ?></span>
</div>
