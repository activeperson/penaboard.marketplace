/**
 *
 *
 * Off-canvas navigation
 *
 * */

const mobileMenu = function() {
	const container = document.body;
	const togglerList = document.getElementsByClassName( 'js-menu-toggle' );

	function closeMenu() {
		container.classList.remove( 'menu-open', 'menu-open--left', 'menu-open--right' );
		container.removeEventListener( 'click', bodyClickFn );
		container.removeEventListener( 'touchstart', bodyClickFn );
	}

	function bodyClickFn( e ) {
		if ( ! hasParentClass( e.target, 'menu' ) ) {
			closeMenu();
		}
	}

	// Recursively check if the element or any of it's parentNodes have given class
	function hasParentClass( element, classname ) {
		if ( element === document ) {
			return false;
		}
		if ( element.classList.contains( classname ) ) {
			return true;
		}
		return element.parentNode && hasParentClass( element.parentNode, classname );
	}

	for ( let i = 0; i < togglerList.length; i++ ) {
		togglerList[ i ].addEventListener( 'click', function( e ) {
			e.stopPropagation();
			e.preventDefault();

			// Get the off-canvas direction from the toggle button
			const directionClass = `menu-open--${ togglerList[ i ].dataset.direction }`;

			if ( container.classList.contains( 'menu-open' ) ) {
				closeMenu();
			} else {
				container.classList.add( directionClass );

				setTimeout( function() {
					container.classList.add( 'menu-open' );
				}, 30 );

				// Clicking outside closes the menu
				container.addEventListener( 'click', bodyClickFn );
				container.addEventListener( 'touchstart', bodyClickFn );
			}
		} );
	}
};

export default mobileMenu();

