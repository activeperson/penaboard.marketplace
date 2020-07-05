<?php
/**
 * View Order
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

<?php astoundify_wc_themes_get_template( 'vendor-dashboard/view-order-details.php', array(
	'order_id' => $order_id,
	'order'    => $order,
) ); ?>

<?php astoundify_wc_themes_get_template( 'vendor-dashboard/view-order-notes.php', array(
	'order_id' => $order_id,
	'order'    => $order,
) ); ?>

<?php astoundify_wc_themes_get_template( 'vendor-dashboard/view-order-items.php', array(
	'order_id' => $order_id,
	'order'    => $order,
) );
