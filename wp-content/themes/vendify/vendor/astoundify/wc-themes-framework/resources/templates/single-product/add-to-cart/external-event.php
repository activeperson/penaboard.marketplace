<?php
/**
 * External Event Add To Cart
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var WC_Product $product     Product Object.
 * @var string     $html_class  Wrapper Class.
 * @var string     $ticket_url  Ticket URL.
 * @var string     $button_text Ticket URL.
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

do_action( 'woocommerce_before_add_to_cart_button' ); ?>

<p class="<?php echo esc_attr( $html_class ); ?>">
	<a href="<?php echo esc_url( $ticket_url ); ?>" rel="nofollow" class="single_add_to_cart_button button alt"><?php echo esc_html( $button_text ); ?></a>
</p>

<?php do_action( 'woocommerce_after_add_to_cart_button' );