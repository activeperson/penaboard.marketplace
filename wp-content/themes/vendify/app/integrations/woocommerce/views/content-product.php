<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

namespace Astoundify\Vendify;

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$args = [
	'product'   => $product,
	'is_vendor' => false,
];

$is_vendor  = is_multiple_vendors() && woocommerce_product_vendors_get_vendor_by_product( get_the_ID() );
$card_style = isset( $card_style ) ? $card_style : absint( get_theme_mod( 'product-catalog-style', 1 ) );

if ( $is_vendor && ! is_tax( WC_PRODUCT_VENDORS_TAXONOMY ) ) {
	$vendor_data = get_vendor_meta( $product->get_id(), 'product_id' );

	$args['is_vendor']   = true;
	$args['vendor_data'] = $vendor_data;
	$args['vendor_logo'] = $vendor_data['logo_image'];
	$args['vendor_link'] = $vendor_data['link'];
	$args['vendor_name'] = $vendor_data['name'];

	$show_vendor = isset( $show_vendor ) ? $show_vendor : true;

	if ( ! $show_vendor ) {
		$args['is_vendor'] = false;
	}
}
?>

<div <?php wc_product_class( 'js-reveal product-item-style--' . $card_style, $product ); ?>>
	<?php wc_get_template( "product-cards/card-$card_style.php", $args ); ?>
</div>
