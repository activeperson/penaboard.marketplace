<?php
/**
 * Checkout terms and conditions checkbox
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) :
	?>

<div class="woocommerce-terms-and-conditions-wrap">

	<?php
		do_action( 'woocommerce_checkout_before_terms_and_conditions' );

			/**
			* Terms and conditions hook used to inject content.
			*
			* @since 3.4.0.
			* @hooked wc_privacy_policy_text() Shows custom privacy policy text. Priority 20.
			* @hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
			*/
			do_action( 'woocommerce_checkout_terms_and_conditions' );
	?>

			<?php if ( wc_terms_and_conditions_checkbox_enabled() ) : ?>

				<p class="form-row terms wc-terms-and-conditions validate-required">
					<label class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?> id="terms" />
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description"><?php printf( __( 'I&rsquo;ve read and accept the <a href="%s" target="_blank" class="woocommerce-terms-and-conditions-link">terms &amp; conditions</a>', 'vendify' ), esc_url( wc_get_page_permalink( 'terms' ) ) ); ?></span>
					</label>
					<input type="hidden" name="terms-field" value="1" />
				</p>

			<?php endif; ?>

		<?php do_action( 'woocommerce_checkout_after_terms_and_conditions' ); ?>

</div>

<?php endif; ?>
