<?php
/**
 * View Order Notes Section
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var int    $order_id
 * @var object $order
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<form id="vendor-order-add-note" method="post">
	<h4><?php esc_html_e( 'Add Note', 'astoundify-wc-themes' ); ?></h4>
	<p>
		<textarea type="text" name="order_note" id="add_order_note" class="input-text" cols="20" rows="5"></textarea>
	</p>
	<p>
		<select name="order_note_type" id="order_note_type">
			<option value=""><?php esc_html_e( 'Private note', 'astoundify-wc-themes' ); ?></option>
			<option value="customer"><?php esc_html_e( 'Note to customer', 'astoundify-wc-themes' ); ?></option>
		</select>
		<input type="submit" class="button" value="<?php esc_attr_e( 'Add', 'astoundify-wc-themes' );?>">
	</p>
	<?php wp_nonce_field( 'vendors-order-add-note', '_nonce' ); ?>
</form>
