/**
 *
 * Footer dropup on mobile
 *
 */

const mobileFooter = function() {
	const toggle = document.querySelector( '.js-footer-toggle' );
	const toggleLegal = document.querySelector('.js-footer-toggle-legal');
	const dropup = document.querySelector( '.site-footer__dropup' );
	const dropupLegal = document.querySelector('.site-footer__dropup-legal');
	const closeBtn = document.querySelector( '.js-footer-dropup-close' );
	const closeBtnLegal = document.querySelector( '.js-footer-dropup-close-legal' );

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

	if ( toggleLegal ) {
		toggleLegal.addEventListener( 'click', function() {
			dropupLegal.classList.toggle( 'is-active' );
		} );

		if ( closeBtnLegal ) {
			closeBtnLegal.addEventListener( 'click', function() {
				dropupLegal.classList.remove( 'is-active' );
			} );
		}
	}
};

export default mobileFooter();

