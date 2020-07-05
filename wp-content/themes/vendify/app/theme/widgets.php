<?php
/**
 * WordPress widget areas.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Widget
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register widgetized areas.
 *
 * @since 1.0.0
 */
function register_sidebars() {
	// Footer widgets.
	register_sidebar(
		[
			// Translators: Widget column number.
			'name'          => esc_html__( 'Footer Widgets', 'vendify' ),
			'id'            => 'footer-sidebar',
			'description'   => esc_html__( 'Widgets assigned to the footer area.', 'vendify'  ),
			'before_widget' => '<div id="%1$s" class="site-footer__column %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="site-footer__heading">',
			'after_title'   => '</h5>',
		]
	);
}
add_action( 'widgets_init', 'Astoundify\Vendify\register_sidebars' );
