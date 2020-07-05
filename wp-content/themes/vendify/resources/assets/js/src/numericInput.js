import 'cleave.js';

( function( window, undefined ) {
	const $ = window.jQuery;
	const $inputs = $( '.custom-numeric-input' );

	$.each( $inputs, function() {
		const $element = $( this );
		const $numericInput = $element.find( '.form-control-numeric' );
		const $buttons = $element.find( 'button' );

		new Cleave( $numericInput, {
			numeral: true,
			numeralIntegerScale: 4,
			numeralDecimalScale: 0,
			numeralThousandsGroupStyle: 'thousand',
			numeralPositiveOnly: true,
		} );

		function numberHandler( button ) {
			let currentValue = parseInt( $numericInput.val() );

			if ( button.hasClass( 'btn-icon--minus' ) && ( currentValue !== 0 ) ) {
				currentValue = currentValue - 1;
			} else if ( button.hasClass( 'btn-icon--plus' ) ) {
				currentValue = currentValue + 1;
			}

			$numericInput.val( currentValue );

			$( document.body ).trigger( 'vendify_numeric_input_updated', [ currentValue, $numericInput ] );
		}

		$.each( $buttons, function() {
			const $button = $( this );

			$button.on( 'click', function( e ) {
				e.preventDefault();
				numberHandler( $button );
			} );
		} );
	} );
}( window ) );
