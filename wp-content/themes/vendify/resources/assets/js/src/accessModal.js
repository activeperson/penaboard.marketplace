import Flickity from 'flickity';
import 'bootstrap/js/dist/modal';

( function( window, undefined ) {
	const $ = window.jQuery;
	const links = Vendify.loginRegisterModalLinks;

	if ( ! links || 0 === links.length ) {
		return;
	}

	const accessModal = $( '#access-modal' );
	const accessModalContent = accessModal.find( '.modal-content' );

	$( document ).on( 'click', links.join(), function( e ) {
		const url = $( this ).attr( 'href' );
		const hash = url.substring( url.indexOf( '#' ) );

		let chosenScreen = 'sign-in';

		if ( -1 !== url.indexOf( '#' ) ) {
			chosenScreen = hash.substring( 1 )
		}

		accessModalContent.addClass( chosenScreen );

		setTimeout( function() {
			accessModal.modal( 'show' );
			prepareForm( '.access__column--' + chosenScreen );
		}, 30 );

		e.preventDefault();
	} );

	// Clear the screen class
	accessModal.on( 'hidden.bs.modal', function( e ) {
		accessModalContent.removeClass( 'sign-up sign-in' );
	} );

	// Switch between screens
	$( '.js-switch-access-screen' ).click( function( e ) {
		const targetScreen = $( this ).data( 'screen' );
		const targetSelector = '.access__column--' + targetScreen;

		prepareForm( targetSelector );

		if ( targetScreen === 'sign-up' ) {
			accessModalContent.removeClass( 'sign-in' ).addClass( 'sign-up' );
		} else if ( targetScreen === 'sign-in' ) {
			accessModalContent.removeClass( 'sign-up' ).addClass( 'sign-in' );
		}

		e.preventDefault();
	} );

	// Scrolls up the form column and sets focus to the first input
	function prepareForm( targetSelector ) {
		// Scroll to top before switching the screen
		$( targetSelector ).scrollTop( 0 );
	}

	// Initialize Access Slider
	const accessSliderEl = $( '.access__slider' );

	if ( accessSliderEl.length > 0 ) {
		const accessSlider = new Flickity( '.access__slider', {
			cellAlign: 'left',
			prevNextButtons: false,
			wrapAround: true,
			contain: true,
			dragThreshold: 30,
			setGallerySize: false,
			autoPlay: Vendify.woocommerce.loginRegisterModalAutoplay,
		} );

		// Reinitialize the slider when modal is shown
		accessModal.on( 'shown.bs.modal', function( e ) {
			accessSlider.resize();
		} );
	}
}( window ) );
