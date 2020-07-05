<?php
/**
 * WordPress navigation menus.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Theme
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register navigation menu areas.
 *
 * @see https://codex.wordpress.org/Function_Reference/register_nav_menus
 *
 * @since 1.0.0
 */
function vendify_register_nav_menus() {
	switch ( get_theme_mod( 'header-style', 1 ) ) {
		case 1:
			$navs['primary-left']    = esc_html__( 'Primary', 'vendify' );
			$navs['primary-more']    = esc_html__( 'Primary "&hellip;" Dropdown', 'vendify' );
			$navs['primary-account'] = esc_html__( 'Account Dropdown', 'vendify' );
			break;
		case 2:
			$navs['primary-left']    = esc_html__( 'Primary Dropdown', 'vendify' );
			$navs['primary-account'] = esc_html__( 'Account Dropdown', 'vendify' );
			break;
		case 3:
			$navs['primary-left']  = esc_html__( 'Primary Left', 'vendify' );
			$navs['primary-right'] = esc_html__( 'Primary Right', 'vendify' );
			break;
		case 4:
			$navs['primary-left']    = esc_html__( 'Primary', 'vendify' );
			$navs['primary-more']    = esc_html__( 'Primary "&hellip;" Dropdown', 'vendify' );
			$navs['primary-account'] = esc_html__( 'Account Dropdown', 'vendify' );
			break;
		case 5:
			$navs['primary-left']    = esc_html__( 'Primary', 'vendify' );
			$navs['primary-more']    = esc_html__( 'Primary "&hellip;" Dropdown', 'vendify' );
			$navs['primary-account'] = esc_html__( 'Account Dropdown', 'vendify' );
			break;
	}

	$navs = array_merge(
		$navs,
		[
			'footer'    => esc_html__( 'Footer', 'vendify' ),
			'copyright' => esc_html__( 'Copyright', 'vendify' ),
		]
	);

	$navs = apply_filters( 'vendify_register_nav_menus', $navs );

	register_nav_menus( $navs );
}
add_action( 'after_setup_theme', 'vendify_register_nav_menus' );

/**
 * Add theme-specific CSS classes to HTML `li` output.
 *
 * @since 1.0.0
 *
 * @param array $classes Current menu classes.
 * @return array $classes
 */
function vendify_nav_menu_css_class( $classes ) {
	// Only apply to header menus. Once we reach a loop don't modify anything.
	if ( did_action( 'the_post' ) ) {
		return $classes;
	}

	$classes[] = 'nav-item';

	return $classes;
}
add_filter( 'nav_menu_css_class', 'vendify_nav_menu_css_class' );

/**
 * Search a menu item for a specific CSS class and remove them. They are added
 * back directly to the child element.
 *
 * @since 1.0.0
 *
 * @see vendify_nav_menu_link_attributes()
 *
 * @param array $classes Current classes attached to the menu item.
 * @return array $classes Filtered classes attached to the menu item.
 */
function vendify_nav_menu_item_move_class_to_link( $classes ) {
	$look = [ 'button', 'popup' ];

	foreach ( $look as $class ) {
		$found = array_search( $class, $classes, true );

		if ( false !== $found ) {
			unset( $classes[ $found ] );

			$classes[] = 'nav-item--' . $class;
		}
	}

	return array_filter( $classes, 'strlen' );
}
add_filter( 'nav_menu_css_class', 'vendify_nav_menu_item_move_class_to_link' );

/**
 * Add theme-specific CSS classes to HTML `a` output.
 *
 * @since 1.0.0
 *
 * @param array  $atts Current menu link attributes.
 * @param object $item Current menu item.
 * @return array $atts
 */
function vendify_nav_menu_link_attributes( $atts, $item ) {
	if ( empty( $item->classes ) ) {
		return $atts;
	}

	if ( did_action( 'vendify_header_after' ) ) {
		return $atts;
	}

	$look    = [ 'button', 'popup' ];
	$classes = [ 'nav-link' ];

	// Loop through existing parent item classes and add to link if special.
	foreach ( $item->classes as $class ) {
		$found = array_search( $class, $look, true );

		if ( false !== $found ) {
			$classes[] = 'nav-link--' . $class;
			$classes[] = $class;
		}
	}

	if ( isset( $atts['class'] ) ) {
		$atts['class'] = $atts['class'] . ' ' . implode( ' ', $classes );
	} else {
		$atts['class'] = implode( ' ', $classes );
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'vendify_nav_menu_link_attributes', 10, 2 );
