<?php
/**
 * WP User Avatars integration.
 *
 * @see https://github.com/stuttter/wp-user-avatars
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Integration
 * @author Astoundify
 */

namespace Astoundify\Vendify\Integrations\WPUserAvatars;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WP User Avatars
 *
 * @since 1.0.0
 */
class Integration extends \Astoundify\Vendify\Integration {

	/**
	 * Define the dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->set_dir( get_parent_theme_file_path( 'app/integrations/wp-user-avatars' ) );

		$this->set_dependencies(
			[
				function_exists( '_wp_user_avatars' ),
			]
		);
	}

	/**
	 * Load extra files.
	 *
	 * @since 1.0.0
	 */
	public function includes() {
		require_once $this->get_dir() . '/template-functions.php';
		require_once $this->get_dir() . '/template-hooks.php';
	}

	/**
	 * Connect to WordPress
	 *
	 * @since 1.0.0
	 */
	public function register() {}

}
