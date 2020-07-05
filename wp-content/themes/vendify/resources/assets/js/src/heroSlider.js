/**
 * Hero slider on Find pages
 */
import Flickity from 'flickity';

( function( window, undefined ) {
	const $ = window.jQuery;
	const heroSliderElement = document.querySelector( '.hero__slider' );

	if ( heroSliderElement ) {
		new Flickity( '.hero__slider', {
			cellAlign: 'left',
			prevNextButtons: true,
			wrapAround: true,
			contain: true,
			dragThreshold: 30,
			arrowShape: 'M55.1,7.53a4.43,4.43,0,0,0,0-6.24,4.36,4.36,0,0,0-6.2,0L.5,50,48.9,98.71a4.36,4.36,0,0,0,6.2,0,4.43,4.43,0,0,0,0-6.24L12.9,50Z',
			setGallerySize: false,
		} );
	}
}( window ) );
