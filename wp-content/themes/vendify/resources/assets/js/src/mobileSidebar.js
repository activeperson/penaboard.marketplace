/**
 *
 * Sidebar dropup on mobile
 *
 */

const mobileSidebar = function() {
	const toggle = document.querySelector( '.js-sidebar-toggle' );
	const dropup = document.querySelector( '.menu__nav-more' );
	const closeBtn = document.querySelector( '.js-footer-dropup-close' );

	if ( toggle ) {
		toggle.addEventListener( 'click', function() {
			dropup.classList.toggle( 'is-active' );
		} );

		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', function() {
				dropup.classList.remove( 'is-active' );
			} );
		}
	}
};

export default mobileSidebar();

