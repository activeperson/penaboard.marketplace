<?php
/**
 * Checkout title.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Theme
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>

<header class="checkout__header">
	<div class="checkout__logo">
		<?php partial( 'branding' ); ?>
	</div>

	<h2 class="checkout__title"><?php the_title(); ?></h2>

	<?php if ( ! woocommerce_is_order_received() ) { ?>
		<div class="lead"><?php echo wpautop( strip_shortcodes( get_the_content() ) ); ?></div>

		<div class="checkout__cta">
			<?php if ( ! is_user_logged_in() && 'no' !== get_option( 'woocommerce_enable_checkout_login_reminder' ) ) { ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="link link-cta" data-toggle="modal" data-target="#modal-login"><?php esc_html_e( 'I already have an account', 'vendify' ); ?></a>
			<?php }
			if ( wc_coupons_enabled() ) {
				if ( ! is_user_logged_in() && 'no' !== get_option( 'woocommerce_enable_checkout_login_reminder' ) ) { ?>
					<span>&nbsp;<?php esc_html_e( 'OR', 'vendify' ); ?>&nbsp;</span>
				<?php } ?>

				<a href="#" class="link link-cta" data-toggle="modal" data-target="#modal-coupon"><?php esc_html_e( 'I have a discount code', 'vendify' ); ?></a>
			<?php } ?>
		</div>
	<?php } else { ?>
		<div class="checkout__cta"><?php esc_html_e( 'Thank you for your purchase!', 'vendify' ); ?></div>
	<?php } ?>
</header>

<?php
if ( ! is_user_logged_in() && 'no' !== get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
	wc_get_template( 'modals/login-register.php' );
}

if ( wc_coupons_enabled() ) {
	wc_get_template( 'modals/coupon.php' );
}
