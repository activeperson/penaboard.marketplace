/**
 *
 * Remove focus outline on links & buttons on click, but keep them when tabbing through.
 * The method is described in great details here: https://hackernoon.com/removing-that-ugly-focus-ring-and-keeping-it-too-6c8727fefcd2
 *
 */

const tabOutline = function() {
	function handleFirstTab( e ) {
		if ( e.keyCode === 9 ) {
			document.body.classList.add( 'user-is-tabbing' );

			window.removeEventListener( 'keydown', handleFirstTab );
			window.addEventListener( 'mousedown', handleMouseDownOnce );
		}
	}

	function handleMouseDownOnce() {
		document.body.classList.remove( 'user-is-tabbing' );

		window.removeEventListener( 'mousedown', handleMouseDownOnce );
		window.addEventListener( 'keydown', handleFirstTab );
	}

	window.addEventListener( 'keydown', handleFirstTab );
};

export default tabOutline();

