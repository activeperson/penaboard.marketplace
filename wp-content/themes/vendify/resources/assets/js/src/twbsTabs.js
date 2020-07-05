/**
 * @see https://gist.github.com/hanssens/6681908
 */
( function( window, undefined ) {
	const $ = window.jQuery;

	$( function() {
		if ( location.hash !== '' ) {
			$( 'a[href="' + location.hash + '"]' ).tab( 'show' );
		}

		$( 'a[data-toggle="tab"]' ).on( 'shown.bs.tab', function( e ) {
			history.pushState( null, null, $( this ).attr( 'href' ) );
		} );
	} );
}( window ) );
