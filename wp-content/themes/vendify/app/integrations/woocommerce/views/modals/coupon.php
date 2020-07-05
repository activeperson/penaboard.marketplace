<?php
/**
 * Coupon
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

<div class="modal fade" id="modal-coupon" tabindex="-1" role="dialog" aria-labelledby="modal-coupon" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<header class="modal-header">
				<h4 class="modal-title text-center"><?php esc_html_e( 'Apply a Discount', 'vendify' ); ?></h4>
				<button type="button" class="btn-icon--close" data-dismiss="modal" aria-label="Close">
					<?php
					svg(
						[
							'icon'    => 'close',
							'classes' => [ 'ico--xs' ],
						]
					);
					?>
				</button>
			</header>

			<div class="modal-body">
				<?php echo woocommerce_checkout_coupon_form(); ?>
			</div>

		</div>
	</div>
</div>
