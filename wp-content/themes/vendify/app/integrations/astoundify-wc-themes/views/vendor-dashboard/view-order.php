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

astoundify_wc_themes_get_template(
	'vendor-dashboard/view-order-details.php',
	[
		'order_id' => $order_id,
		'order'    => $order,
	]
);
