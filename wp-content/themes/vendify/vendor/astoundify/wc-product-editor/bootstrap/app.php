<?php
/**
 * Load the application.
 *
 * @since 1.0.0
 *
 * @package Astoundify\WC_Product_Editor
 * @category Bootstrap
 * @author Astoundify
 */

namespace Astoundify\WC_Product_Editor;

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load classes that handle REST API.
add_action( 'rest_api_init', function() {
	require_once ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH . 'app/api/class-rest-controller.php';
	require_once ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH . 'app/api/v1/products/class-categories.php';
	require_once ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH . 'app/api/v1/products/class-tags.php';
});

/**
 * Open live editor.
 */
add_action( 'init', function() {
		// Load helper functions.
	require_once ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH . 'app/functions.php';
	require_once ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH . 'app/template-functions.php';
	require_once ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH . 'app/capabilities.php';

	require_once ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH . 'app/api-functions.php';

	// Ensure environment.
	if ( ! isset( $_GET['wcre'] ) ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? $_GET['post'] : false;

	// If not editing, create a draft and send them back.
	if ( ! $post_id ) {
		$draft_id = insert_draft_product();

		wp_safe_redirect( get_edit_url( $draft_id ) );
		exit();
	}

	$post = get_post( $post_id );
	
	new Editor( $post );
});

/**
 * Hide the admin bar when the product-editor is active.
 *
 * @since 1.0.0
 */
add_action( 'after_setup_theme', function() {
	if ( ! is_admin() && isset( $_GET['wcre_preview'] ) && $_GET['wcre_preview'] ) {
		show_admin_bar( false );
	}
} );

/**
 * If debug is enabled show a button in the classic editor.
 *
 * @since 1.0.0
 */
add_action( 'post_submitbox_misc_actions', function() {
	// Only available in dev environments.
	if ( ! defined( 'WP_DEBUG' ) || true !== WP_DEBUG ) {
		return;
	}

	global $post;

	if ( ! $post || ! $post->post_type || $post->post_type !== 'product' ) {
		return;
	} ?>

	<div class="misc-pub-section">
		<a href="<?php echo esc_url( get_edit_url( $post->ID ) ); ?>" class="button button-primary button-large" id="wcre-open-button">
			Edit With Live Preview
		</a>
	</div>
<?php });
