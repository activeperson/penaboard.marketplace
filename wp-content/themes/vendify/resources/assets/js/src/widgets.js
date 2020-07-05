/**
 * General widgets.
 */

( function($) {
	const children = '.children';
	const $listItem = $( '.cat-parent' );
	const $current = $( '.current-cat.cat-parent' );

	// Slide down children when you click.
	$listItem.on( 'click', function() {
		const $item = $( this );

		$item
			.find( children )
			.slideToggle();

		$item
			.toggleClass( 'is--expanded' );
	} );
}(jQuery) );
