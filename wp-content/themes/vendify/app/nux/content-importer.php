<?php
/**
 * Content importer.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Setup
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use Astoundify_ContentImporter;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Load Astoundify Content Importer.
 *
 * @see https://github.com/astoundify/wp-content-importer
 *
 * @since 1.0.0
 */
function content_importer() {
	$lib = get_template_directory() . '/vendor/astoundify/wp-content-importer';

	if ( file_exists( $lib . '/astoundify-contentimporter.php' ) ) {
		include_once $lib . '/astoundify-contentimporter.php';

		$content_importer_strings = [
			'type_labels' => [
				'childtheme'    => [ esc_html__( 'Child Theme', 'vendify' ), esc_html__( 'Child Theme', 'vendify' ) ],
				'user'          => [ esc_html__( 'User', 'vendify' ), esc_html__( 'Users', 'vendify' ) ],
				'setting'       => [ esc_html__( 'Setting', 'vendify' ), esc_html__( 'Settings', 'vendify' ) ],
				'thememod'      => [ esc_html__( 'Theme Customization', 'vendify' ), esc_html__( 'Theme Customizations', 'vendify' ) ],
				'term'          => [ esc_html__( 'Term', 'vendify' ), esc_html__( 'Terms', 'vendify' ) ],
				'nav-menu'      => [ esc_html__( 'Navigation Menu', 'vendify' ), esc_html__( 'Navigation Menus', 'vendify' ) ],
				'nav-menu-item' => [ esc_html__( 'Navigation Menu Item', 'vendify' ), esc_html__( 'Navigation Menu Items', 'vendify' ) ],
				'object'        => [ esc_html__( 'Content', 'vendify' ), esc_html__( 'Content', 'vendify' ) ],
				'widget'        => [ esc_html__( 'Widget', 'vendify' ), esc_html__( 'Widgets', 'vendify' ) ],
			],
			'import'      => [
				'complete' => esc_html__( 'Import Complete!', 'vendify' ),
			],
			'reset'       => [
				'complete' => esc_html__( 'Reset Complete!', 'vendify' ),
			],
			'errors'      => [
				'process_action' => esc_html__( 'Invalid process action.', 'vendify' ),
				'process_type'   => esc_html__( 'Invalid process type.', 'vendify' ),
				'iterate'        => esc_html__( 'Iteration process failed.', 'vendify' ),
				'cap_check_fail' => esc_html__( 'You do not have permission to manage content.', 'vendify' ),
			],
		];

		// Load and Set Importer.
		Astoundify_ContentImporter::instance();
		Astoundify_ContentImporter::set_strings( $content_importer_strings );
		Astoundify_ContentImporter::set_url( get_template_directory_uri() . '/vendor/astoundify/wp-content-importer/public' );

		// Importer Default Style Files.
		foreach ( [ 'default' ] as $content ) {
			add_filter( 'astoundify_ci_pack_vendify_' . $content, 'Astoundify\Vendify\content_importer_content_' . $content );
		}

		// Importer Royale Style Files.
		foreach ( [ 'royale' ] as $content ) {
			add_filter( 'astoundify_ci_pack_vendify_' . $content, 'Astoundify\Vendify\content_importer_content_' . $content );
		}
	}
}
add_action( 'after_setup_theme', 'Astoundify\Vendify\content_importer', 5 );

/**
 * Required plugins.
 *
 * @since 1.0.0
 *
 * @return array
 */
function content_importer_get_required_plugins() {
	return [
		'woocommerce' => [
			'label'     => '<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=woocommerce&TB_iframe=true&width=772&height=642' ) . '" class="thickbox">WooCommerce</a>',
			'condition' => class_exists( 'WooCommerce' ),
		],
	];
}

/**
 * Recommended plugins.
 *
 * @since 1.0.0
 *
 * @return array
 */
function content_importer_get_recommended_plugins() {
	return [
		'woo-gutenberg-products-block' => [
			'label'     => '<a href="' . esc_url( admin_url( 'plugin-install.php?tab=plugin-information&plugin=woo-gutenberg-products-block&TB_iframe=true&width=772&height=642' ) ) . '" class="thickbox">' . esc_html__( 'Product Blocks', 'vendify' ) . '</a>',
			'condition' => class_exists( '\Automattic\WooCommerce\Blocks\Package' ),
			'pack'      => [ 'default' ],
		],
		'woocommerce-product-vendors' => [
			'label'     => '<a href="https://astoundify.com/go/woocommerce-product-vendors/">'. esc_html__( 'Product Vendors', 'vendify' ) . '</a>',
			'condition' => defined( 'WC_PRODUCT_VENDORS_VERSION' ),
			'pack'      => [ 'default','royale' ],
		],
		'if-menu'         => [
			'label'     => '<a href="' . esc_url( admin_url( 'plugin-install.php?tab=plugin-information&plugin=if-menu&TB_iframe=true&width=772&height=642' ) ) . '" class="thickbox">' . esc_html__( 'If Menu','vendify' ) . '</a>',
			'condition' => class_exists( 'If_Menu' ),
			'pack'      => [ 'default','royale' ],
		],
		'safe-svg'         => [
			'label'     => '<a href="' . esc_url( admin_url( 'plugin-install.php?tab=plugin-information&plugin=safe-svg&TB_iframe=true&width=772&height=642' ) ) . '" class="thickbox">' . esc_html__( 'Safe SVG', 'vendify' ) . '</a>',
			'condition' => class_exists( 'safe_svg' ),
			'pack'      => [ 'default','royale' ],
		],
		'favorites'                   => [
			'label'     => '<a href="' . esc_url( admin_url( 'plugin-install.php?tab=plugin-information&plugin=wp-favorites&TB_iframe=true&width=772&height=642' ) ) . '" class="thickbox">' . esc_html__( 'Favorites', 'vendify'  ) . '</a>',
			'condition' => defined( 'ASTOUNDIFY_FAVORITES_VERSION' ),
			'pack'      => [ 'default','royale' ],
		],
		'private-messages'            => [
			'label'     => '<a href="' . esc_url( admin_url( 'plugin-install.php?tab=plugin-information&plugin=private-messages&TB_iframe=true&width=772&height=642' ) ) . '" class="thickbox">' . esc_html__( 'Private Messages', 'vendify' ) . '</a>',
			'condition' => defined( 'PM_VERSION' ),
			'pack'      => [ 'default', 'another','royale' ],
		],
	];
}

/**
 * Default content files.
 *
 * @since 1.0.0
 *
 * @return array
 */
function content_importer_content_default() {
	return glob( trailingslashit( get_template_directory() ) . 'app/nux/demo-content/default/*.json' );
}

/**
 * Tasti content files.
 *
 * @since 1.0.0
 *
 * @return array
 */
function content_importer_content_tasti() {
	return glob( trailingslashit( get_template_directory() ) . 'app/nux/demo-content/tasti/*.json' );
}

/**
 * Royale content files.
 *
 * @since 1.0.0
 *
 * @return array
 */
function content_importer_content_royale() {
	return glob( trailingslashit( get_template_directory() ) . 'app/nux/demo-content/royale/*.json' );
}

