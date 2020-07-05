/**
 * Custom checkout.
 */

( function( window, undefined ) {
	const $ = window.jQuery;
	const $checkout = $( '.checkout__main' );
	const $tabPane = $checkout.find( '.tab-content' );
	const $tabs = $checkout.find( '.nav-tabs' );

	$checkout.on( 'click', '.js-toggle-checkout-step', ( e ) => {
		e.preventDefault();
		const tab = `[target_id="${ $( e.target ).attr( 'target_id' ) }"]`;

		// Hide all tabs.
		$tabPane
			.find( '> div' )
			.removeClass( 'active' )
			.fadeOut( 'fast' ).promise().done( () => {
				// Show active tab.
				$tabPane
					.find( tab )
					.fadeIn( 'fast' );
			} );

		// Inactive all tabs.
		$tabs
			.find( 'button' )
			.removeClass( 'active' )
			.find( 'span' )
			.addClass( 'badge-outline-gray-500' )
			.removeClass( 'badge-secondary' );

		// Active tab.
		$tabs
			.find( `button${ tab }` )
			.addClass( 'active' )
			.find( 'span' )
			.addClass( 'badge-secondary' )
			.removeClass( 'badge-outline-gray-500' );
	} );
}( window ) );
