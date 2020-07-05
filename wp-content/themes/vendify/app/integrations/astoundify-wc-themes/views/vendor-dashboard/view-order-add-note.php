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
	<p>
		<textarea type="text" name="order_note" id="add_order_note" class="input-text" cols="20" rows="3" placeholder="<?php esc_attr_e( 'Add note', 'vendify' ); ?>"></textarea>
	</p>

	<p class="order-update-add">
		<select name="order_note_type" id="order_note_type" class="custom-select">
			<option value=""><?php esc_html_e( 'Private note', 'vendify' ); ?></option>
			<option value="customer"><?php esc_html_e( 'Note to customer', 'vendify' ); ?></option>
		</select>

		<input type="submit" class="btn btn-sm btn-primary" value="<?php esc_attr_e( 'Add Note', 'vendify' ); ?>">
	</p>

	<?php wp_nonce_field( 'vendors-order-add-note', '_nonce' ); ?>
</form>
