/**
 * Transparent logo.
 *
 * Update the logo if the header is in transparent mode.
 */
( function( window, undefined ) {
	const $ = window.jQuery;

	$( function( $ ) {
		const $siteHeader = $( '.site-header' );
		const $logo = $siteHeader.find( $( '.custom-logo' ) );
		const $link = $( '.custom-logo-link' );

		const alt = $link.data( 'alt' );
		const org = $link.data( 'org' );

		const transparent = $siteHeader.hasClass( 'site-header--transparent' );

		$logo.attr( 'src', transparent ? alt : org );
	} );
}( window ) );
