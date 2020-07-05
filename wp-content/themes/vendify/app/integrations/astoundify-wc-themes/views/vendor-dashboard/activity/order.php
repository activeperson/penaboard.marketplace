<?php
/**
 * Dashboard Page: Activities Item (Order)
 *
 * @var array $activity
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
} ?>

<div class="activity__item activity__item--purchase">
	<?php
	svg(
		[
			'icon'    => 'sales',
			'classes' => [ 'ico--sm' ],
		]
	); ?>

	<span class="activity__thumbnail">
		<?php echo $product_thumbnail; // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</span>

	<div class="activity__item__content">
		<span class="activity__logo">
			<?php echo $user_avatar; ?>
		</span>

		<span class="activity__text">
			<?php echo esc_html( $user_name ); ?> ordered <a class="link" href="<?php echo esc_url( $product_url ); ?>"><?php echo esc_html( $product_name ); ?></a>
		</span>
	</div>

	<span class="activity__date"><?php printf( '%s ago', human_time_diff( $timestamp, current_time( 'timestamp' ) ) ); ?></span>
</div>
