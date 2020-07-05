<?php
/**
 * Single product vendor policies.
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
}

$vendor = get_queried_object();

if ( ! is_object( $vendor ) || empty( $vendor->term_id ) ) {
	return;
}

$vendor_data = get_vendor_meta( $vendor->term_id );
$shipping    = isset( $vendor_data['shipping_policy'] ) && '' !== $vendor_data['shipping_policy'] ? $vendor_data['shipping_policy'] : false;
$return      = isset( $vendor_data['return_policy'] ) && '' !== $vendor_data['return_policy'] ? $vendor_data['return_policy'] : false;

if ( $shipping ) : ?>

<section class="text">
	<h4><?php esc_html_e( 'Shipping Policy', 'vendify' ); ?></h4>

	<?php echo wp_kses_post( $shipping ); ?>
</section>

<?php endif;

if ( $return ) : ?>

<hr class="hr hr--xl">

<section class="text">
	<h4><?php esc_html_e( 'Return Policy', 'vendify' ); ?></h4>

	<?php echo wp_kses_post( $return ); ?>
</section>

<?php endif; ?>

<hr class="hr hr--xl">

<section class="text">
	<h4><?php esc_html_e( 'Payment Options', 'vendify' ); ?></h4>

	<?php
	$icon = get_svg(
		[
			'icon'    => 'lock',
			'classes' => [ 'ico--xs' ],
		]
	);

	$gateways = WC()->payment_gateways->get_available_payment_gateways();

	echo wpautop( $icon . ' ' . sprintf( esc_html__( '%s keeps your payment information secure. Below are available payment options:', 'vendify' ), esc_html( $vendor_data['name'] ) ) );

	echo '<ul>';

	foreach ( $gateways as $gateway ) {
		echo '<li>' . esc_html( $gateway->description ) . '</li>';
	}

	echo '</ul>';
	?>
</section>
