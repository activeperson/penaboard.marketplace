<?php
/**
 * Nav right user.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use WC_Product_Vendors_Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! has_nav_menu( 'primary-account' ) || ! display_header_icon( 'header-account', 'always' ) ) {
	return;
} ?>

<div class="dropdown dropdown--user">
	<button class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="shop-dropdown__avatar"><?php echo get_avatar( get_current_user_id(), 34 ); ?></span>

		<?php if ( is_header_style( [ 2, 5 ] ) ) { ?>
			<span class="shop-dropdown__name">
				<?php echo esc_attr( get_the_author_meta( 'display_name', get_current_user_id() ) ); ?>
			</span>
		<?php }

		if ( has_integration( 'woocommerce-product-vendors' ) && WC_Product_Vendors_Utils::is_vendor() && is_header_style( [ 2, 5 ] ) ) {
			$unpaid = astoundify_wc_themes_vendors_get_vendor_total_data(
				[
					'column' => 'total_commission_amount',
					'status' => 'unpaid',
				]
			); ?>
			<span class="badge badge--sm badge--pill <?php echo 'transparent' !== transparent_item_classname() ? 'badge-outline-neutral' : 'badge-outline-secondary'; ?>"><?php echo wc_price( $unpaid ); ?></span>
		<?php } ?>
	</button>

	<?php
	wp_nav_menu(
		[
			'theme_location' => 'primary-account',
			'menu_class'     => 'dropdown-menu dropdown-menu--bordered dropdown-menu-right',
			'container'      => false,
			'fallback_cb'    => false,
			'depth'          => 1,
		]
	); ?>
</div>
