/* global Vendify, $ */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

domReady( () => {
	// Toggle dropdown when a product is added to the cart.
	if ( ! Vendify.woocommerce ) {
		return;
	}

	if ( ! Vendify.woocommerce.showCart ) {
		return;
	}

	$( document.body ).on( 'wc_fragments_refreshed', () => {
		$( '#js-mini-cart-toggle' ).dropdown( 'toggle' );
	} );
} );
