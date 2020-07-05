<?php
/**
 * Vendor Registration block.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Block
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Only register if plugin exists.
if ( ! has_integration( 'woocommerce-product-vendors' ) ) {
	return;
}

/**
 * Output a vendor registration form.
 *
 * @since 1.0.0
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function gutenberg_vendor_registration( $attributes ) {
	ob_start(); ?>

	<div class="row">
		<div class="col-md-8 col-lg-7 col-xl-5 ml-sm-auto mr-sm-auto">
			<?php echo vendor_registration_form(); ?>
		</div>
	</div>

	<?php
	return ob_get_clean();
}

// Register block.
register_block_type(
	'vendify/vendor-registration',
	[
		'render_callback' => 'Astoundify\Vendify\gutenberg_vendor_registration',
	]
);
