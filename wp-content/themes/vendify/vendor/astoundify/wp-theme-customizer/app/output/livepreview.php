<?php
/**
 * Manage live reloading of the preview iframe.
 *
 * @package Astoundify
 * @subpackage ThemeCustomizer
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customize Preview
 *
 * @since 1.0.0
 */
class Astoundify_ThemeCustomizer_Output_LivePreview extends Astoundify_ModuleLoader_Module {

	/**
	 * Hook in to WordPress
	 *
	 * @since 1.1.0
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		add_action( 'customize_preview_init', array( $this, 'customizer_scripts_preview' ), 99 );

		add_action( 'wp_ajax_astoundify-themecustomizer-css', array( $this, 'rebuild_css' ) );
		add_action( 'wp_ajax_astoundify-themecustomizer-webfont', array( $this, 'rebuild_webfont' ) );

		add_action( 'astoundify_themecustomizer_output_customizer_preview_css', array( $this, 'preview_thememods' ) );

		$this->is_hooked = true;
	}

	/**
	 * Preview Scripts and styles
	 *
	 * @since 1.0.0
	 *
	 * @param object $wp_customize Customize API
	 */
	public function customizer_scripts_preview( $wp_customize ) {
		$install_url = trailingslashit( astoundify_themecustomizer_get_option( 'install_url' ) );

		wp_enqueue_script( 'webfontloader', esc_url( $install_url . '/assets/js/vendor/webfontloader.js' ), array(), '1.6.26' );
		wp_enqueue_script( 'astoundify-themecustomizer-preview', astoundify_themecustomizer_get_option( 'install_url' ) . '/assets/js/customizer-preview.js', array( 'jquery', 'underscore', 'webfontloader' ), time(), true );

		wp_localize_script(
			'astoundify-themecustomizer-preview', 'astoundifyThemeCustomizerPreview', array(
				'stylesheet' => astoundify_themecustomizer_get_option( 'stylesheet' ),
			)
		);
	}

	/**
	 * Rebuild and return generated CSS based on the current customizer settings.
	 *
	 * @see preview_thememods()
	 *
	 * @since 1.0.0
	 */
	public function rebuild_css() {
		// let things know we are in a live preview
		do_action( 'astoundify_themecustomizer_output_customizer_preview_css' );

		// load output files
		do_action( 'astoundify_themecustomizer_load_output_css' );

		$css = astoundify_themecustomizer_get_inline_css();

		if ( ! $css ) {
			wp_send_json_error();
		}

		wp_send_json_success( $css );
	}

	/**
	 * Rebuild and return a JSON for Webfont Loader.
	 *
	 * This currently assumes you are using the `googlefonts` AssetSource.
	 *
	 * @see https://github.com/typekit/webfontloader
	 * @since 1.0.0
	 *
	 * @return string JSON response.
	 */
	public function rebuild_webfont() {
		// let things know we are in a live preview
		do_action( 'astoundify_themecustomizer_output_customizer_preview_css' );

		$json = array();

		// gather google
		$source = astoundify_themecustomizer_get_assetsource( 'googlefonts' );
		$json   = $source->generate_webfont_json();

		if ( empty( $json ) ) {
			wp_send_json_error();
		}

		wp_send_json_success( $json );
	}

	/**
	 * Wrapper function for substituting preview values in theme mod settings.
	 *
	 * @since 1.0.0
	 */
	public function preview_thememods() {
		// @codingStandardsIgnoreStart
		if ( ! isset( $_POST['action'] ) ) {
			return;
		}

		if ( ! in_array( $_POST['action'], array( 'astoundify-themecustomizer-webfont', 'astoundify-themecustomizer-css' ) ) ) {
			return;
		}

		$customized = (array) $_POST['astoundify-themecustomizer-customized-controls'];
		// @codingStandardsIgnoreEnd

		foreach ( $customized as $setting_id => $value ) {
			add_filter( 'theme_mod_' . sanitize_key( $setting_id ), array( $this, 'preview_thememod_value' ) );
		}
	}

	/**
	 * Return a preview value for a particular theme mod setting.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value
	 * @return mixed $value
	 */
	public function preview_thememod_value( $value ) {
		$preview = (array) maybe_unserialize( $_POST['astoundify-themecustomizer-customized-controls'] );

		$setting_id = str_replace( 'theme_mod_', '', current_filter() );

		if ( isset( $preview[ $setting_id ] ) ) {
			return $preview[ $setting_id ];
		}

		return $value;
	}

}
