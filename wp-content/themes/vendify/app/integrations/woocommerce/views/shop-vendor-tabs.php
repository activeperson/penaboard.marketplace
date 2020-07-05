<?php
/**
 * Shop vendor tabs.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! has_integration( 'woocommerce-product-vendors' ) ) {
	return;
}

if ( ! get_theme_mod( 'product-catalog-vendors', false ) ) {
	return;
} ?>

<div class="row">
  <div class="col">
	<?php wc_get_template( 'vendors/tabs.php' ); ?>
  </div>
</div>
