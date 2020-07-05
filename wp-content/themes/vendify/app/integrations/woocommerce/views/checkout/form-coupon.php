<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! wc_coupons_enabled() ) {
	return;
}
?>

<form class="checkout_coupon form-group" method="post" style="display: block !important;">
	<div class="form-group">
		<p class="form-row">
			<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'vendify' ); ?>" id="coupon_code" value="" />
		</p>

		<p class="form-row form-row--submit">
			<button type="submit" class="btn btn-primary btn-block" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'vendify' ); ?>"><?php esc_html_e( 'Apply coupon', 'vendify' ); ?></button>
		</p>
	</div>
</form>
