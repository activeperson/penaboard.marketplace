<?php
/**
 * Load a local source.
 *
 * @package Astoundify
 * @subpackage ThemeCustomizer
 * @since 1.1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load a source.
 *
 * @since 1.1.0
 */
class Astoundify_ThemeCustomizer_AssetLoader_Local extends Astoundify_ThemeCustomizer_AssetLoader_Loader implements Astoundify_ThemeCustomizer_AssetLoader_LoaderInterface {

	/**
	 * Load raw data from a remote file.
	 *
	 * @since 1.1.0
	 *
	 * @return mixed $raw_data Array if valid or null.
	 */
	public function load_data() {
		$file     = $this->get_raw_data_origin();
		$raw_data = null;
		$pathinfo = pathinfo( $file );

		if ( 'json' == $pathinfo['extension'] ) {
			$raw_data = $this->load_json();
		} else {
			$raw_data = $this->load_php();
		}

		return $raw_data;
	}

	/**
	 * Load a local PHP file.
	 *
	 * Excepts the file to return a valid array.
	 *
	 * @since 1.1.0
	 *
	 * @return mixed $raw_data Array if valid JSON or null if file cannot be read or is invalid.
	 */
	public function load_php() {
		$raw_data = include_once( $this->get_raw_data_origin() );

		if ( ! is_array( $raw_data ) ) {
			return null;
		}

		return $raw_data;
	}

	/**
	 * Parse a local JSON file.
	 *
	 *
	 * @since 1.1.0
	 *
	 * @return mixed $raw_data Array if valid JSON or null if file cannot be read or is invalid.
	 */
	public function load_json() {
		$path       = $this->get_raw_data_origin();

		if ( file_exists( $path ) ) {
			ob_start();
			include ( $path );
			$json = ob_get_clean();
		}

		$raw_data = null;

		if ( ! empty( $json ) ) {
			$raw_data = json_decode( $json, true );
		}

		return $raw_data;
	}

}
