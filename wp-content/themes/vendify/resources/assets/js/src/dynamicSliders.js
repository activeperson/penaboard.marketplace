/**
 *  Dynamic sliders
 *  Each object in `sliders` array will trigger a slider below `sliderBreakpoint`,
 *  and destroy it above that media query.
 *
 *  The styling of each mode is taken care of in CSS.
 */
import Flickity from 'flickity';

( function( window, undefined ) {
	const $ = window.jQuery;
	const slidersList = document.getElementsByClassName( 'js-dynamic-slider' );
	const SliderCount = slidersList.length;

	const sliderOptions = {
		cellAlign: 'center',
		prevNextButtons: false,
		wrapAround: true,
		contain: true,
		dragThreshold: 40,
	};

	const sliderBreakpoint = window.matchMedia( '(max-width: 767px)' );

	function handleSliderChange( breakpoint ) {
		for ( let i = 0; i < SliderCount; i++ ) {
			const element = slidersList[ i ];

			if ( breakpoint.matches ) {
				new Flickity( element, sliderOptions );
			} else {
				const currentSlider = Flickity.data( element );
				currentSlider && currentSlider.destroy();
			}
		}
	}

	if ( SliderCount ) {
		handleSliderChange( sliderBreakpoint );
		sliderBreakpoint.addListener( handleSliderChange );
	}
}( window ) );
