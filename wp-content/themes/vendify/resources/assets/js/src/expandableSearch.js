/**
 * Expanabable search form..
 */
( function( window, undefined ) {
	const $ = window.jQuery;

	$( '.site-header .custom-search__label' ).on( 'click touchstart', function() {
		$(this).addClass( 'custom-search__label--active' );
	});

	$( '.custom-search__label .custom-search__close' ).on( 'click touchstart', function(e) {
		e.preventDefault();

		$(this).parent().removeClass( 'custom-search__label--active' );
		const self = this;
		const $button = $(this);

		$button.blur();

		$button.siblings( 'input.form-control-search' ).val('');

		setTimeout( function () {

			$(self).parent().removeClass( 'custom-search__label--active' );

		}, 100 );
	});

	$('.custom-search').on('focusout', '.custom-search__label--active .form-control-search', function(e){
		if ( e.target.value === '' ) {
			$(this).parent().removeClass( 'custom-search__label--active' );
		}
	});

}( window ) );
