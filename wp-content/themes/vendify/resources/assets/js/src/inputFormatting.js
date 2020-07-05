( function( window, undefined ) {
	const $ = window.jQuery;

	$( function( $ ) {
		if ( $().selectWoo ) {
			$( 'select:not(.custom-select)' ).selectWoo();
		}
	} );
}( window ) );
