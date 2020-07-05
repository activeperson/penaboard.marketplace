<?php
/**
 * Template loader helpers.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Locate a piece of template.
 *
 * @since 1.0.0
 *
 * @param string|array $templates The name of the template.
 * @param array        $args Variables to pass to the template.
 */
function view( $templates, $args = [] ) {
	if ( ! is_array( $templates ) ) {
		$templates = [ $templates ];
	}

	$_templates = [];

	foreach ( $templates as $key => $template_name ) {
		$_templates[] = $template_name . '.php';
		$_templates[] = 'resources/views/' . $template_name . '.php';
	}

	$template = locate_template( $_templates );

	if ( $template ) {
		// Extract variable to use in template file.
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args ); // @codingStandardsIgnoreLine
		}

		include $template;
	}
}

/**
 * Output a partial.
 *
 * @since 1.0.0
 *
 * @param string $partial The file name of the partial to load.
 * @param array  $args Variables to pass to the template.
 */
function partial( $partial, $args = [] ) {
	echo get_partial( $partial, $args ); // XSS: ok.
}

/**
 * Load a template partial in to the output buffer.
 *
 * This serves mainly as an alias for `vendify_view()` but always looks
 * in the `/partials` directory.
 *
 * @since 1.0.0
 *
 * @param string $partial The file name of the partial to load.
 * @param array  $args Variables to pass to the template.
 * @return string
 */
function get_partial( $partial, $args = [] ) {
	ob_start();

	view( 'partials/' . $partial, $args );

	return ob_get_clean();
}
