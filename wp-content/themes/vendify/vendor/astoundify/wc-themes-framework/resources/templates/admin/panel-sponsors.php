<?php
/**
 * Sponsors tab panel.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category View
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Product object.
global $product_object;

// Add JS Data.
add_filter( 'astoundify_wc_themes_events_product_data_js', function( $data ) use ( $product_object ) {
	$data['sponsors'] = array(
		'data' => astoundify_wc_themes_events_get_sponsors_js( $product_object ),
		'i18n' => array(
			'uploadTitle' => esc_html__( 'Choose an image', 'astoundify-wc-themes' ),
			'insertImageButtonText' => esc_html__( 'Set sponsor image', 'astoundify-wc-themes' ),
		),
	);

	return $data;
} );

// Add Underscore Templates.
add_action( 'admin_footer', function() {
	astoundify_wc_themes_get_template( 'admin/tmpl-sponsors.php' );
} );

// Placeholder HTML.
echo '<div id="wc_themes_sponsors_options_inner"></div>';
