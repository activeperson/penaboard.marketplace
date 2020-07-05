<?php
/**
 * Setup guide.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Setup
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use Astoundify_Setup_Guide;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Load Astoundify Setup Guide
 *
 * @see https://github.com/astoundify/wp-setup-guide
 *
 * @since 1.0.0
 */
function setup_guide() {
	$lib = get_parent_theme_file_path( 'vendor/astoundify/wp-setup-guide' );

	if ( file_exists( $lib . '/app/class-astoundify-setup-guide.php' ) ) {
		include_once $lib . '/app/class-astoundify-setup-guide.php';

		Astoundify_Setup_Guide::init(
			[
				'steps'          => include_once get_parent_theme_file_path( 'app/nux/setup-guide-steps/_step-list.php' ),
				'steps_dir'      => get_parent_theme_file_path( 'app/nux/setup-guide-steps' ),
				'strings'        => [
					// Translators: %s Theme name.
					'page-title'      => esc_html__( 'Setup %s', 'vendify' ),
					'menu-title'      => esc_html__( 'Getting Started', 'vendify' ),
					'sub-menu-title'  => esc_html__( 'Setup Guide', 'vendify' ),
					// Translators: %s Theme name.
					'intro-title'     => esc_html__( '🎉 Welcome to %s', 'vendify' ),
					'step-complete'   => esc_html__( 'Completed', 'vendify' ),
					'step-incomplete' => esc_html__( 'Not Complete', 'vendify' ),
				],
				'stylesheet_uri' => get_parent_theme_file_uri( 'vendor/astoundify/wp-setup-guide/app/assets/css/style.css' ),
			]
		);
	}
}
add_action( 'after_setup_theme', 'Astoundify\Vendify\setup_guide' );

/**
 * Intro paragraph.
 *
 * @since 1.0.0
 */
function setup_guide_intro() { ?>

<p class="about-text" style="min-height: 0;">
	<?php echo wp_kses_post( __( 'Use the steps below to finish setting up your new website.', 'vendify' ) ); ?>
</p>

<div class="setup-guide-theme-badge">
	<img src="<?php echo esc_url( get_parent_theme_file_uri( 'screenshot.png' ) ); ?>" width="205" alt="<?php esc_attr_e( 'Logo.', 'vendify' ); ?>" />
</div>

<p class="helpful-links">
	<a href="http://vendify.astoundify.com" class="button button-primary js-trigger-documentation" target="_blank"><?php esc_html_e( 'Search Documentation', 'vendify' ); ?></a>&nbsp;
	<a href="https://astoundify.com/go/astoundify-support/" class="button button-secondary" target="_blank"><?php esc_html_e( 'Submit a Support Ticket', 'vendify' ); ?></a>&nbsp;
</p>

	<?php
}
add_action( 'astoundify_setup_guide_intro', 'Astoundify\Vendify\setup_guide_intro' );

/**
 * After the theme is activated, redirect to the setup guide.
 */
function redirect_after_setup() {
	global $pagenow;
	if ( "themes.php" == $pagenow && is_admin() && isset( $_GET['activated'] ) ) {
		wp_safe_redirect( esc_url_raw( add_query_arg( 'page', 'vendify-setup', admin_url( 'admin.php' ) ) ) );
	}
}
add_action( 'admin_init', 'Astoundify\Vendify\redirect_after_setup' );
