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
$notes = wc_get_order_notes(
	[
		'order_id' => $order_id,
	]
);
?>

<?php if ( ! $notes || ! is_array( $notes ) ) : ?>

	<?php wpautop( esc_html__( 'No notes', 'vendify' ) ); ?>

<?php else : ?>
	<ol class="order-updates">

	<?php
	foreach ( $notes as $note ) :
		astoundify_wc_themes_get_template(
			'vendor-dashboard/view-order-note.php',
			[
				'note' => $note,
			]
		);
	endforeach;
	?>

	</ol>
<?php endif; ?>

<?php astoundify_wc_themes_get_template(
	'vendor-dashboard/view-order-add-note.php',
	[
		'order_id' => $order_id,
		'order'    => $order,
	]
); ?>
