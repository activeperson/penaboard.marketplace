<?php
/**
 * Reporting tab.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var object $product WooCommerce Product Object.
 * @var array  $reasons Report reasons.
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */
?>

<div id="product-reporting">

	<?php if ( ! is_user_logged_in() ) : ?>

		<p><?php esc_html_e( 'Please login to report this product to site administrator.', 'astoundify-wc-themes' ); ?> <a href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'Login', 'astoundify-wc-themes' ); ?></a></p>

	<?php else : ?>

		<form id="product-reporting-form" method="POST">

			<div class="product-reporting-reason-field">
				<p><label for="product-reporting-reason"><?php esc_html_e( 'Reason', 'astoundify-wc-themes' ); ?></label></p>
				<select id="product-reporting-reason" name="reason">
					<?php foreach( $reasons as $key => $label ) : ?>
						 <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div><!-- .product-reporting-reason-field -->

			<div class="product-reporting-description-field">
				<p><label for="product-reporting-description"><?php esc_html_e( 'Description', 'astoundify-wc-themes' ); ?></label></p>
				<textarea id="product-reporting-description" name="description"></textarea>
			</div><!-- .product-reporting-description-field -->

			<div class="product-reporting-submit-field">
				<p><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_attr( 'Submit', 'astoundify-wc-themes' ); ?>"></p>
				<input type="hidden" name="action" value="product_reporting">
				<input type="hidden" name="product_id" value="<?php echo esc_attr( $product->get_id() ); ?>">
				<?php wp_nonce_field( 'astoundify-wc-themes-vendors-product-reporting', '_nonce' ); ?>
			</div><!-- .product-reporting-submit-field -->

		</form><!-- #product-reporting-form -->

	<?php endif; ?>

</div><!-- #product-reporting -->
