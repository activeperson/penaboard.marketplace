/**
 * Hero image fade in animation
 *
 * Required `.hero--animatable` modifier
 * The function will preload the image for the current viewport size/dpi before animating.
 */

( function( window, undefined ) {
	const $ = window.jQuery;
	const $hero = $( '.hero--animatable' );
	const $heroImage = $( '.hero__image' );

	if ( $hero.length > 0 && $heroImage.length > 0 ) {
		// Get the background image for the current viewport size (applied to pseudo-element)
		let url = $heroImage.css( 'background-image' );

		// Strip it naked
		url = url.replace( 'url(', '' ).replace( ')', '' ).replace( /\"/gi, '' );

		// Load an image and animate when done
		const proxyImage = new Image();
		proxyImage.src = url;
		proxyImage.addEventListener( 'load', function() {
			$hero.addClass( 'is-animating' );
		} );
	}
}( window ) );
