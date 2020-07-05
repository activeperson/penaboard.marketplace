<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

namespace Astoundify\Vendify;

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<div class="woocommerce-mini-cart cart_list product_list_widget">
		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>

				<div class="order-item woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<?php if ( $thumbnail ) : ?>
						<span class="order-item__img">
							<a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo $thumbnail; ?></a>
						</span>
					<?php endif; ?>

					<div class="order-item__body">
						<span class="order-item__name">
							<a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo esc_attr( $product_name ); ?></a>
						</span>
						<span class="order-item__quantity">
							<?php
							// Translators: %d Quantity of individual item in cart.
							printf( esc_html__( 'Quantity: %d', 'woocommerce' ), $cart_item['quantity'] );
							?>
						</span>
					</div>

					<span class="price ml-auto"><?php echo $product_price; // WPCS: XSS ok. ?></span>

					<?php
					echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						'woocommerce_cart_item_remove_link',
						sprintf(
							'<a href="%s" class="remove remove_from_cart_button btn-icon btn-icon--close" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">%s</a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_html__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() ),
							get_svg(
								[
									'icon'    => 'close',
									'classes' => [ 'ico--xs' ],
								]
							)
						),
						$cart_item_key
					);
					?>
				</div>

				<?php
			}
		endforeach;
		?>

		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn-lg checkout has-light-color has-text-color d-flex">
			<?php _e( 'Checkout', 'woocommerce' ); ?> <span class="badge badge--pill badge--lg badge-outline-light ml-2"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
		</a>
	</div>

<?php else : ?>

	<div class="order-item--empty">
		<?php esc_html_e( 'Ваша корзина пуста', 'woocommerce' ); ?>
	</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
