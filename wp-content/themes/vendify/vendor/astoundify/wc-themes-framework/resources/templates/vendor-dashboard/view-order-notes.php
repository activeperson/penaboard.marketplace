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

// Get customer notes.
$notes = wc_get_order_notes( array(
	'order_id' => $order_id,
) );
?>

<div id="vendors-order-notes" class="vendors-order-section">
	<h3><?php esc_html_e( 'Order Notes', 'astoundify-wc-themes' ); ?></h3>

	<?php if ( ! $notes || ! is_array( $notes ) ) : ?>
		<?php wpautop( esc_html__( 'No notes', 'astoundify-wc-themes' ) ); ?>
	<?php else : ?>
		<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) :
		?>

			<?php astoundify_wc_themes_get_template( 'vendor-dashboard/view-order-note.php', array(
				'note' => $note,
			) ); ?>

		<?php endforeach; ?>
		</ol>
	<?php endif;?>

	<?php astoundify_wc_themes_get_template( 'vendor-dashboard/view-order-add-note.php', array(
		'order_id' => $order_id,
		'order'    => $order,
	) ); ?>

</div><!-- #vendors-order-notes.vendors-order-section -->
