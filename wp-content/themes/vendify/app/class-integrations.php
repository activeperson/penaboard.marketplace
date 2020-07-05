<?php
/**
 * Manage integrations.
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
	protected static $integrations = [];

	/**
	 * Retrieve an integration.
	 *
	 * @since 1.0.0
	 *
	 * @param string $integration Integration slug.
	 * @return false|stdClass
	 */
	public static function get_integration( $integration ) {
		return isset( self::$integrations[ $integration ] ) ? self::$integrations[ $integration ] : false;
	}

	/**
	 * Add an integration if its dependency is available.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug The slug of the integration.
	 * @param string $classname Force a specific classname to be used.
	 */
	public static function register( $slug, $classname = null ) {
		if ( ! $classname ) {
			$classname = ucwords( str_replace( '-', '_', $slug ) );
		}

		$class = __NAMESPACE__ . '\Integrations\\' . $classname . '\Integration';

		if ( ! class_exists( $class ) ) {
			return;
		}

		self::$integrations[ $slug ] = new $class();
	}

	/**
	 * Register active integrations and connect them to WordPress.
	 *
	 * @since 1.0.0
	 */
	public static function load() {
		foreach ( self::$integrations as $slug => $integration ) {
			// Don't go any further if dependency is not available.
			if ( ! $integration->is_active() ) {
				continue;
			}

			$integration->load();
		}
	}

}
