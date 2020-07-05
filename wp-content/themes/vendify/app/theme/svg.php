<?php
/**
 * SVG helpers.
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
 * Echo SVG markup.
 *
 * @since 1.0.0
 *
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 */
function svg( $args = [] ) {
	echo get_svg( $args ); // WPCS: XSS ok.
}

/**
 * Return SVG markup.
 *
 * @since 1.0.0
 *
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 */
function get_svg( $args = [] ) {
	// A string passed is assumed the icon name.
	if ( ! is_array( $args ) ) {
		$icon         = $args;
		$args         = [];
		$args['icon'] = $icon;
	}

	$version = get_theme_version();

	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_html__( 'Please define an SVG icon filename.', 'vendify' );
	}

	// Set defaults.
	$defaults = [
		'icon'     => '',
		'title'    => '',
		'desc'     => '',
		'fallback' => false,
		'classes'  => [],
	];

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Add default classes.
	$args['classes'][] = 'ico';
	$args['classes'][] = 'vendify-icon';
	$args['classes'][] = 'vendify-icon-' . esc_attr( $args['icon'] );

	// Set aria hidden.
	$aria_hidden = ' aria-hidden="true"';

	// Set ARIA.
	$aria_labelledby = '';

	/*
	 * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
	 */
	if ( $args['title'] ) {
		$aria_hidden     = '';
		$unique_id       = uniqid();
		$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

		if ( $args['desc'] ) {
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
		}
	}

	// Begin SVG markup.
	$svg = '<svg class="' . implode( ' ', $args['classes'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

	// Display the title.
	if ( $args['title'] ) {
		$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

		// Display the desc only if the title is already set.
		if ( $args['desc'] ) {
			$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
		}
	}

	/*
	 * Display the icon.
	 *
	 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
	 *
	 * See https://core.trac.wordpress.org/ticket/38387.
	 */
	$svg .= ' <use xlink:href="' . get_template_directory_uri() . '/public/images/icons.svg?v=' . $version . '#' . esc_html( $args['icon'] ) . '"></use> ';

	// Add some markup to use as a fallback for browsers that do not support SVGs.
	if ( $args['fallback'] ) {
		$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
	}

	$svg .= '</svg>';

	return $svg;
}
