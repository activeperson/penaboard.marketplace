/**
 *
 * Product slider on the Standard page
 *
 */
import Flickity from 'flickity';

( function( window, undefined ) {
	const $ = window.jQuery;
	const productItem = $( '.product-item--editable' );

	productItem.on( 'mouseleave', function() {
		const currentDropdown = $( this ).find( '.dropdown' );

		if ( currentDropdown.hasClass( 'show' ) ) {
			setTimeout( () => {
				currentDropdown.dropdown( 'toggle' );
			}, 250 );
		}
	} );
}( window ) );
