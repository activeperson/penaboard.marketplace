<?php
/**
 * WooCommerce Widgets and Sidebars.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register a custom Shop sidebar.
 *
 * @since 1.0.0
 */
function vendify_woocommerce_widgets_init() {
	register_sidebar(
		[
			'name'          => esc_html__( 'Shop Sidebar', 'vendify' ),
			'id'            => 'shop',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="%2$s">',
			'after_widget'  => '</section></div>',
			'before_title'  => '<h6 class="find-sidebar__heading">',
			'after_title'   => '</h6><section class="card card--widget widget shop-widget">',
		]
	);
}
add_action( 'widgets_init', 'vendify_woocommerce_widgets_init' );
