<?php
/**
 * Checkout step 1: Addresses.
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
}

echo do_shortcode( '[woocommerce_checkout]' );

if ( ! woocommerce_is_order_received() ) : ?>
	<div class="form--checkout-submit-wrap">
		<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="link link-cta text-xs has-icon">
			<?php
			svg(
				[
					'icon'    => 'long-arrow-left',
					'classes' => [ 'ico--xs mr-2' ],
				]
			);

			esc_html_e( 'Back to Store', 'vendify' ); ?>
		</a>

		<button target_id="choose-payment" class="js-toggle-checkout-step btn btn-primary btn--checkout-submit">
			<?php
			esc_html_e( 'Continue', 'vendify' );
			
			svg(
				[
					'icon'    => 'long-arrow-right',
					'classes' => [ 'ico--xs ml-2' ],
				]
			); ?>
		</button>
	</div>
<?php endif;

