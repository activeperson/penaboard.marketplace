<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
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
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		[
			'billing'  => esc_html__( 'Billing address', 'vendify' ),
			'shipping' => esc_html__( 'Shipping address', 'vendify' ),
		],
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		[
			'billing' => esc_html__( 'Billing address', 'vendify' ),
		],
		$customer_id
	);
}
?>

<div class="row">
	<div class="col-md-11 col-lg-8 col-xl-7 ml-sm-auto mr-sm-auto dashboard__settings">

		<div class="row woocommerce-Addresses">

		<?php foreach ( $get_addresses as $name => $title ) : ?>

			<div class="woocommerce-Address col-xs-12 
			<?php
			if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) :
				?>
col-sm-6<?php endif; ?>">
				<header class="woocommerce-Address-title title">
					<h3><?php echo $title; ?></h3>
				</header>
				<address>
				<?php
					$address = wc_get_account_formatted_address( $name );
					echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'vendify' );
				?>
				</address>

				<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit btn btn-primary mt-2"><?php _e( 'Edit', 'vendify' ); ?></a>
			</div>

		<?php endforeach; ?>

		</div>

	</div>
</div>
