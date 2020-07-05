<?php
/**
 * Gutenberg.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Theme
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use Astoundify_ThemeCustomizer_Output_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Determine if post content has an available "hero" block that can be used first.
 *
 * @since 1.0.0
 */
function gutenberg_content_has_hero_block( $content ) {
	if ( ! has_blocks( $content ) ) {
		return false;
	}

	$whitelist = [ 'core/cover-image', 'vendify/hero', 'coblocks/hero' ];
	$blocks    = parse_blocks( $content );

	if ( empty( $blocks ) ) {
		return false;
	}

	$blocks = wp_list_pluck( $blocks, 'blockName' );

	if ( empty( $blocks ) ) {
		return false;
	}

	return in_array( current( $blocks ), $whitelist, true );
}

/**
 * Set header to transparent if first block is a hero.
 *
 * @since 1.0.0
 *
 * @param bool $transparent Is the header transparent?
 * @return bool
 */
function gutenberg_is_transparent_header( $transparent ) {
	if ( get_post() && is_singular( [ 'post', 'page' ] ) ) {
		the_post();

		$transparent = gutenberg_content_has_hero_block( get_the_content() );

		rewind_posts();
	}

	return $transparent;
}
add_filter( 'vendify_is_transparent_header', 'Astoundify\Vendify\gutenberg_is_transparent_header' );

/**
 * Add theme support.
 *
 * @since 1.0.0
 */
add_action( 'after_setup_theme', function() {
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );

	$colors  = vendify_customize_get_theme_color_controls( 'all' );
	$palette = [];

	unset( $colors['color-body-color'] );
	unset( $colors['color-menu-bg'] );
	unset( $colors['color-menu-color'] );

	foreach ( $colors as $mod => $label ) {
		$palette[] = [
			'name'  => $label,
			'slug'  => str_replace( 'color-', '', $mod ),
			'color' => astoundify_themecustomizer_get_colorscheme_mod( $mod ),
		];
	}

	// We need a neutral color derived from the background color for borders and light backgrounds.
	$neutral = astoundify_themecustomizer_darken_hex( get_theme_mod( 'background_color' ) , -15.5 );
	$palette[] = [
		'name'  => esc_html__( 'Neutral', 'vendify' ),
		'slug'  => 'neutral',
		'color' => '#' . $neutral,
	];

	add_theme_support( 'editor-color-palette', $palette );
	add_theme_support( 'editor-styles' );
});

/**
 * Add theme custom styling for the WordPress editor.
 * Note: We are intentionally ditch `add_editor_style` because it is blocking us from
 * targeting different post types and we can't set our different content width per post type.
 */
add_action( 'admin_enqueue_scripts', function( $hook ){

	if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
		// add_editor_style( 'public/css/gutenberg-editor.min.css' );
		wp_enqueue_style( 'vendify-editor-style', get_asset_src( '/public/css/gutenberg-editor', 'css' ) );
	}

});

/**
 * Register server-side code for individual blocks.
 *
 * @since 1.0.0
 */
add_action( 'after_setup_theme', function() {
	foreach ( glob( get_template_directory() . '/resources/blocks/library/*/index.php' ) as $block_logic ) {
		require_once $block_logic;
	}
}, 20);

/**
 * Enqueue Gutenberg assets.
 *
 * @since 1.0.0
 */
function enqueue_block_editor_assets() {
	$version = get_theme_version();

	wp_enqueue_script(
		'vendify-editor-blocks',
		get_asset_src( '/public/js/editor-blocks', 'js' ),
		[ 'wp-editor', 'wp-blocks', 'wp-element', 'wp-plugins', 'wp-edit-post' ],
		$version
	);

	wp_localize_script(
		'vendify-editor-blocks',
		'vendifyEditorSettings',
		apply_filters(
			'vendify_editor_settings',
			[
				'isVendorDashboard'    => function_exists( 'astoundify_wc_is_vendor_dashboard' ) && astoundify_wc_is_vendor_dashboard(),
				'hasVendorIntegration' => has_integration( 'woocommerce-product-vendors' )
			]
		)
	);

	if ( function_exists( 'astoundify_themecustomizer_get_googlefont_url' ) ) {
		wp_enqueue_style(
			'vendify-editor-fonts',
			astoundify_themecustomizer_get_googlefont_url(),
			[],
			$version
		);
	}
}
add_action( 'enqueue_block_editor_assets', 'Astoundify\Vendify\enqueue_block_editor_assets' );

/**
 * Inline editor settings.
 *
 * @since 1.0.0
 *
 * @param array $settings Editor settings.
 * @return array
 */
function inline_editor_css( $settings ) {
	// Shim dynamic CSS.
	$output = new Astoundify_ThemeCustomizer_Output_Manager();
	$output->load_output();

	$settings['styles'][] = [
		'baseUrl' => null,
		'css'     => astoundify_themecustomizer_get_inline_css( true ),
	];

	return $settings;
}
add_filter( 'block_editor_settings', 'Astoundify\Vendify\inline_editor_css' );

/**
 * Register custom block category.
 *
 * @since 1.0.0
 *
 * @param array $categories Block categories
 * @return array
 */
add_filter( 'block_categories', function( $categories ) {
	return array_merge(
		$categories,
		[
			[
				'slug'  => 'vendify',
				'title' => 'Vendify',
			],
		]
	);
});

/**
 * Register body class meta.
 */

$meta_args = [
	'show_in_rest' => true,
	'single' => true,
	'type' => 'string'
];

register_meta('post', 'vendify_content_width', $meta_args );
register_meta('page', 'vendify_content_width', $meta_args );

add_filter( 'body_class', function ( $classes ) {

	if ( in_array( get_post_type(), [ 'post', 'page' ] ) ) {

		$post_class = get_post_meta( get_the_ID(), 'vendify_content_width', true );

		if ( ! empty( $post_class ) ) {
			$classes[] = 'vendify_content_width_' . $post_class;
		}
	}

	return $classes;
} );

add_filter( 'admin_body_class', function( $classes ){

	if ( in_array( get_post_type(), [ 'post', 'page' ] ) ) {

		$post_class = get_post_meta( get_the_ID(), 'vendify_content_width', true );

		if ( ! empty( $post_class ) ) {
			$classes .= ' vendify_content_width_' . $post_class;
		}
	}

	return $classes;
});
