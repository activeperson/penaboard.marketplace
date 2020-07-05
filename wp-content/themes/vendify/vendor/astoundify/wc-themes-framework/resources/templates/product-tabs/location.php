<?php
/**
 * Location tab.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var object $product   WooCommerce Product Object.
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */
?>
<address id="event-location-address">
	<?php if ( $product->get_location_formatted() ) {
		echo wpautop( $product->get_location_formatted(), true ); // WPCS: XSS ok
	} else {
		echo $product->get_location_input(); // WPCS: XSS ok
	} ?>
</address>
