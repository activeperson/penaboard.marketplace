/**
 * Horizontal navigation
 *
 * Scrolls horizontaly when there's not enough space to fit all elements.
 * Clicking on items brings the navigaton into given focus point.
 */
( function( window, undefined ) {
	const $ = window.jQuery;

	$( '.nav-link' ).click( function( e ) {
		const nav = $( this ).closest( '.nav' );
		const focustPoint = 150;

		const distanceFromScreenEdge = $( this ).offset().left;

		if ( distanceFromScreenEdge > focustPoint ) {
			nav.animate( {
				scrollLeft: nav.scrollLeft() + distanceFromScreenEdge - focustPoint,
			}, 300 );
		} else {
			nav.animate( {
				scrollLeft: nav.scrollLeft() - ( focustPoint - distanceFromScreenEdge ),
			}, 300 );
		}
	} );
}( window ) );
