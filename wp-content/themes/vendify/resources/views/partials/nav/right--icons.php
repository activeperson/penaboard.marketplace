<?php
/**
 * Nav right icons.
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

if ( is_header_style( 3 ) ) { ?>
	<div class="ml-auto d-flex" style="height: 100%">
<?php }

partial( 'nav/private-messages' );

if ( has_integration( 'woocommerce' ) && display_header_icon( 'header-cart', 'always' ) ) :
	$cart_count = count( WC()->cart->get_cart_contents() ); ?>

	<div class="sh-dropdown d-none d-md-flex ml-fluid">
		<?php if ( is_header_style( [ 1, 3, 4 ] ) ) { ?>

			<button id="js-mini-cart-toggle" class="sh-dropdown__toggle" data-toggle="dropdown">
				<?php svg( 'bag' ); ?>
				<span class="icon-badge wc-cart-count"<?php echo 0 == $cart_count ? ' style="display: none;"' : null; ?>><?php echo absint( $cart_count ); ?></span>
			</button>

			<div class="dropdown-menu dropdown-menu-right">
				<div class="widget_shopping_cart_content"></div>
			</div>

		<?php } else { ?>

			<div class="sh-dropdown sh-dropdown--square sh-dropdown--bag d-none d-md-flex">
				<button class="sh-dropdown__toggle" data-toggle="dropdown">
					<?php svg( 'bag' ); ?>
					<span class="wc-cart-count--string">
					<?php
					// Translators: %d Number of items in the cart.
					printf( esc_attr( _n( '%d item', '%d items', $cart_count, 'vendify' ) ), absint( $cart_count ) ); ?>
					</span>
				</button>

				<div class="dropdown-menu dropdown-menu-right">
					<div class="widget_shopping_cart_content"></div>
				</div>
			</div>

		<?php } ?>
	</div>

<?php
endif;

if ( is_header_style( 3 ) ) { ?>
	</div>
<?php } ?>
