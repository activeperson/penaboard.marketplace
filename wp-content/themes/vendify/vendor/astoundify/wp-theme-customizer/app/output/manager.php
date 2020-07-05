<?php
/**
 * Frontend output/handling of theme mods. This usually means creating
 * CSS based on the set values, but can extend beyond that.
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
 * Bootstrap the frontend.
 *
 * @since 1.0.0
 */
class Astoundify_ThemeCustomizer_Output_Manager extends Astoundify_ModuleLoader_Module {

	/**
	 * @since 1.1.0
	 * @var array $modules
	 * @access protected
	 */
	protected $modules = array(
		'phpgenerator'  => 'Astoundify_ThemeCustomizer_Output_PHPGenerator',
		'livepreview'   => 'Astoundify_ThemeCustomizer_Output_LivePreview',
	);

	/**
	 * Hook in to WordPress
	 *
	 * @since 1.1.0
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Early so all styles are added before most enqueing should happen.
		add_action( 'wp_enqueue_scripts', array( $this, 'load_output' ), 1 );

		// Allow output to be called elsewhere (such as live preview).
		add_action( 'astoundify_themecustomizer_load_output_css', array( $this, 'load_output' ) );

		// Attach the generated styles to the provided style dependency.
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ), 20 );

		$this->is_hooked = true;
	}

	/**
	 * Load output definitions.
	 *
	 * @since 1.0.0
	 */
	public function load_output() {
		$style   = get_theme_mod( 'style-kit', 'default' );

		$files = (array) glob( trailingslashit( astoundify_themecustomizer_get_option( 'definitions_dir' ) ) . 'output-styles/*.php' );
		$style_kit_path = trailingslashit( astoundify_themecustomizer_get_option( 'definitions_dir' ) ) . 'output-styles/' . $style . '/*.php';

		$style_files = (array) glob( $style_kit_path );

		if ( ! empty( $style_files ) ) {
			$files = array_merge(
				$files,
				$style_files
			);
		}

		if ( ! empty( $files ) ) {
			foreach ( $files as $file ) {
				include_once( $file );
			}
		}
	}

	/**
	 * Attach generated scripts to the set style dependency
	 *
	 * @since 1.0.0
	 */
	public function wp_enqueue_scripts() {
		$stylesheet = astoundify_themecustomizer_get_option( 'stylesheet' );

		// Fonts
		wp_enqueue_style( $stylesheet . '-fonts', astoundify_themecustomizer_get_googlefont_url() );

		$generator    = astoundify_themecustomizer_get_option( 'generator' );
		$output_style = empty( astoundify_themecustomizer_get_option( 'files' ) ) ? 'inline' : 'files';

		// When previewing use inline to override previously saved file (if exists).
		if ( isset( $_GET['customize_changeset_uuid'] ) ) {
			$output_style = 'inline';
		}

		// When using a PHP generator use inline (PHP generator does not support files currently).
		if ( 'php' === $generator ) {
			$output_style = 'inline';
		}

		if ( 'inline' === $output_style ) {
			wp_add_inline_style( $stylesheet, astoundify_themecustomizer_get_inline_css() );
		} else {
			$files = astoundify_themecustomizer_get_option( 'files' );
			$dequeue = false;

			foreach ( $files['entry'] as $file => $path ) {
				$enqueue = isset( $files['output'][$file]['enqueue'] ) && $files['output'][$file]['enqueue'];

				if ( ! $enqueue ) {
					continue;
				}

				$filename = get_option( 'vendify_custom_css_file_' . $file, false );
				$uri      = trailingslashit( $files['output'][$file]['uri'] );
				$path     = trailingslashit( $files['output'][$file]['path'] );

				if ( $filename && file_exists( $path . $filename ) ) {
					wp_enqueue_style( $stylesheet . '-' . $filename, $uri . $filename, array(), astoundify_themecustomizer_get_theme_version() );

					$dequeue = true;
				// Try to add inline if file could not be generated.
				} else {
					wp_add_inline_style( $stylesheet, astoundify_themecustomizer_get_inline_css() );
				}
			}

			// Remove base stylesheet. Only do this if other styles are enqueued.
			if ( $dequeue ) {
				wp_deregister_style( $stylesheet );
				wp_dequeue_style( $stylesheet );
			}
		}
	}

}
