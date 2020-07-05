/**
 *
 *
 * Off-canvas navigation
 *
 * */

const findMenu = function() {
	const container = document.body;
	const toggler = document.querySelector( '.js-find-menu-toggle' );
	const menu = document.querySelector( '.find-menu' );

	function closeMenu() {
		container.classList.remove( 'find-menu-open' );
		menu.classList.remove( 'is-expanded' );
		container.removeEventListener( 'click', bodyClickFn );
	}

	function bodyClickFn( e ) {
		if ( ! hasParentClass( e.target, 'find-menu' ) ) {
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

	toggler && toggler.addEventListener( 'click', function( e ) {
		e.stopPropagation();
		e.preventDefault();

		if ( container.classList.contains( 'find-menu-open' ) ) {
			closeMenu();
		} else {
			container.classList.add( 'find-menu-open' );
			menu.classList.add( 'is-expanded' );
			// Clicking outside closes the menu
			container.addEventListener( 'click', bodyClickFn );
			container.addEventListener( 'touchstart', bodyClickFn );
		}
	} );
};

export default findMenu();

