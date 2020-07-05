<?php
/**
 * Manage an integration with a 3rd-party application.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Integration
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Integration
 *
 * @since 1.0.0
 */
abstract class Integration {

	/**
	 * Current working directory.
	 *
	 * @var string $dir
	 * @since 1.0.0
	 */
	protected $dir = null;

	/**
	 * List of required dependencies.
	 *
	 * @var array $active
	 * @since 1.0.0
	 */
	protected $dependencies = [];

	/**
	 * If this integration is active and meets dependency requiremens.
	 *
	 * @var bool $active
	 * @since 1.0.0
	 */
	protected $active = null;

	/**
	 * Set the integration's working directory.
	 *
	 * @since 1.0.0
	 *
	 * @param string $dir The working directory.
	 */
	public function set_dir( $dir ) {
		$this->dir = $dir;
	}

	/**
	 * Get the integration's working directory.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_dir() {
		return $this->dir;
	}

	/**
	 * Set a list of required dependencies.
	 *
	 * @since 1.0.0
	 *
	 * @param array $dependencies List of required dependencies.
	 */
	public function set_dependencies( $dependencies ) {
		$this->dependencies = $dependencies;
	}

	/**
	 * Get a list of required dependencies.
	 *
	 * @since 1.0.0
	 *
	 * @return array $dependencies List of required dependencies.
	 */
	public function get_dependencies() {
		return $this->dependencies;
	}

	/**
	 * Determine if this integration is active.
	 *
	 * @since 1.0.0
	 */
	public function is_active() {
		if ( ! in_array( false, $this->get_dependencies(), true ) ) {
			$this->active = true;
		}

		return (bool) $this->active;
	}

	/**
	 * Bootstrap integration.
	 *
	 * @since 1.0.0
	 */
	public function load() {
		$this->includes();
		$this->register();
		$this->customizer();
	}

	/**
	 * Load extra files.
	 *
	 * @since 1.0.0
	 */
	abstract public function includes();

	/**
	 * Connect to WordPress
	 *
	 * @since 1.0.0
	 */
	abstract public function register();

	/**
	 * Add automatic customizer support for integrations.
	 *
	 * In the integration directory create the following structure:
	 *
	 *   class-integration.php
	 *   wp-cutomize-definitions/
	 *     panels/*.php
	 *     controls/*.php
	 *     sections/*.php
	 *     output-styles/*.php
	 *
	 * @since 1.0.0
	 */
	public function customizer() {
		add_action( 'wp_enqueue_scripts', [ $this, 'customizer_output_styles' ], 5 );

		add_action( 'customize_register', [ $this, 'customizer_setup_panels' ], 15 );
		add_action( 'customize_register', [ $this, 'customizer_setup_sections' ], 16 );
		add_action( 'customize_register', [ $this, 'customizer_setup_controls' ], 17 );
	}

	/**
	 * Output custom CSS based on control values.
	 *
	 * @since 1.0.0
	 */
	public function customizer_output_styles() {
		$style = get_theme_mod( 'style-kit', 'default' );
		$files = (array) glob( $this->get_dir() . '/customize/output-styles/*.php' );
		$style_kit_path = $this->get_dir() . '/customize/output-styles/' . $style . '/*.php';
		$style_files = (array) glob( $style_kit_path );

		if ( ! empty( $style_files ) ) {
			$files = array_merge(
				$files,
				$style_files
			);
		}

		foreach ( $files as $file ) {
			include_once $file;
		}
	}

	/**
	 * Register and modify panels.
	 *
	 * @since 1.8.0
	 *
	 * @param object $wp_customize WP_Customize_Manager.
	 */
	public function customizer_setup_panels( $wp_customize ) {
		foreach ( glob( $this->get_dir() . '/customize/panels/*.php' ) as $file ) {
			include_once $file;
		}
	}

	/**
	 * Register and modify sections.
	 *
	 * @since 1.0.0
	 *
	 * @param object $wp_customize WP_Customize_Manager.
	 */
	public function customizer_setup_sections( $wp_customize ) {
		foreach ( glob( $this->get_dir() . '/customize/sections/*.php' ) as $file ) {
			include_once $file;
		}
	}

	/**
	 * Register and modify controls.
	 *
	 * @since 1.0.0
	 *
	 * @param object $wp_customize WP_Customize_Manager.
	 */
	public function customizer_setup_controls( $wp_customize ) {
		foreach ( glob( $this->get_dir() . '/customize/controls/*.php' ) as $file ) {
			include_once $file;
		}
	}
}
