<?php
/**
 * Manage integrations.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Integration
 * @author Astoundify
 */

namespace Astoundify\WC_Themes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Manage integrations with other WordPress plugins.
 *
 * @since 1.0.0
 */
class Integrations {

	/**
	 * Registered integrations.
	 *
	 * @var array $integrations
	 * @since 1.0.0
	 */
	protected static $integrations = array();

	/**
	 * Add an integration if its dependency is available.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug The slug of the integration directory and base filename.
	 * @param array  $dependencies List of required dependencies.
	 */
	public static function register( $slug, $dependencies = array() ) {
		$activate = true;

		foreach ( $dependencies as $dependency ) {
			if ( ! $dependency ) {
				$activate = false;
				break;
			}
		}

		if ( $activate ) {
			self::$integrations[ $slug ] = true;
		}
	}

	/**
	 * Register active integrations and connect them to WordPress.
	 *
	 * @since 1.0.0
	 */
	public static function load() {
		foreach ( self::$integrations as $integration => $loaded ) {
			require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/integrations/' . $integration . '/' . $integration . '.php' );
		}
	}

	/**
	 * Check if an integration is active.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug The slug of the integration to check.
	 * @return bool
	 */
	public static function is_active( $slug ) {
		return isset( self::$integrations[ $slug ] );
	}

}
