/**
 *
 * Masonry variant of blog grid.
 *
 */

if ($.fn.masonry) {

	$(document).ready(function(){

		$('.blog-grid').imagesLoaded(function(){
			$('.blog-grid').masonry({
				// options
				itemSelector: '.blog-grid__column',
				horizontal: true,
				animate: true,
				percentPosition: true
			});
		});

		$('.site-footer__nav').imagesLoaded(function(){
			$('.site-footer__nav').masonry({
				// options
				itemSelector: '.site-footer__column',
				horizontal: true,
				animate: true,
				percentPosition: true
			});
		});

	});
}
