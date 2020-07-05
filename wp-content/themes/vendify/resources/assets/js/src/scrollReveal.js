/**
 *
 * Reveal elements when scrolled into viewport
 *
 * Follow the markup below to group each set of elements
 * <div class="js-reveal-container">
 *   <div class=js-reveal>...</div>
 *   <div class=js-reveal>...</div>
 *   <div class=js-reveal>...</div>
 * </div>
 *
 * */

import ScrollReveal from 'scrollreveal';

window.sr = ScrollReveal( {
	origin: 'bottom',
	distance: '60px',
	scale: 1,
	duration: 600,
	easing: 'ease-out',
} );

const revealContainerList = document.querySelectorAll( '.js-reveal-container' );

for ( let i = 0; i < revealContainerList.length; i++ ) {
	sr.reveal( revealContainerList[ i ].querySelectorAll( '.js-reveal' ), 250 );
}
