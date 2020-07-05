import noUiSlider from 'nouislider';

( function( window, undefined ) {
	const $ = window.jQuery;
	const rangeSlider = document.querySelectorAll( '.range-slider' );

	for ( let i = 0; i < rangeSlider.length; i++ ) {
		const element = rangeSlider[ i ];

		noUiSlider.create( element, {
			start: [ 30, 75 ],
			connect: true,
			step: 1,
			range: {
				min: 0,
				max: 120,
			},
		} );

		// TODO: Refactor
		element.noUiSlider.on( 'update', function( values, handle ) {
			const minResultField = this.target.parentNode.querySelector( '.js-price-min' );
			const maxResultField = this.target.parentNode.querySelector( '.js-price-max' );
			const minValue = '$' + convertValue( Math.round( values[ 0 ] ) );
			const maxValue = '$' + convertValue( Math.round( values[ 1 ] ) );

			// Change the slider step as it gets larger
			if ( values[ 1 ] >= 1000 && values[ 1 ] < 100000 ) {
				if ( this.options.step !== 100 ) {
					this.updateOptions( {
						step: 100,
					} );
				}
			}

			if ( values[ 1 ] >= 100000 && values[ 1 ] < 1000000 ) {
				if ( this.options.step !== 1000 ) {
					this.updateOptions( {
						step: 1000,
					} );
				}
			}

			// Insert values into price spans
			if ( handle === 0 ) {
				minResultField.innerHTML = minValue;
			} else {
				maxResultField.innerHTML = maxValue;
			}
		} );

		// Shorten large values, 1000 -> 1k
		function convertValue( value ) {
			// x.xk - xx.xk
			if ( value >= 1000 && value < 100000 ) {
				return ( value / 1000 ).toFixed( 1 ) + 'k';
			}

			// xxxk
			else if ( value >= 100000 ) {
				return ( Math.round( value / 1000 ) + 'k' );
			}
			return value;
		}
	}
}( window ) );
