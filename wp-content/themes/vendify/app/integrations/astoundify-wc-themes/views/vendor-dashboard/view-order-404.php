<?php
/**
 * Orders
 *
 * Shows the first intro screen on the account dashboard.
 * For Sales Summary, Links, etc.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var $current_page
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="woocommerce-message woocommerce-message--error woocommerce-Message woocommerce-Message--error woocommerce-error">
	<?php esc_html_e( 'Order not found.', 'vendify' ); ?>
</div>
