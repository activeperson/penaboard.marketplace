/**
 * Comments
 */

( function( window, undefined ) {
	const $ = window.jQuery;
	const $button = $( '.comment__toggle-replies' );

	$button.on( 'click', function() {
		const $this = $( this );
		$this.parents( '.comment__item' ).siblings( '.comment__item--reply' ).toggle();
		$this.toggleClass( 'is-active' );
	} );
}( window ) );
