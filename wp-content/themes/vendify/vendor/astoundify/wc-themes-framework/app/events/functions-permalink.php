<?php
/**
 * Permalink Functions
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Event
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Permalink Settings
 *
 * This is added via late "current_screen" hook, because WC add it there, so the field can be below WC permalink settings.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_permalink_register_settings() {
	// Add Section.
	add_settings_section(
		$id       = 'astoundify-wc-themes-events-permalink',
		$title    = esc_html__( 'Event permalinks', 'astoundify-wc-themes' ),
		$callback = 'astoundify_wc_themes_events_permalink_settings_section',
		$page     = 'permalink'
	);
}
add_action( 'current_screen', 'astoundify_wc_themes_events_permalink_register_settings', 20 );

/**
 * Permalink Settings Section HTML Callback
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_permalink_settings_section() {
	$archive_page_id = astoundify_wc_themes_events_get_archive_page_id();
	$option = get_option( 'astoundify_wc_themes_events_permalink_option', 'default' );

	// Always use default if archive page not selected or not valid.
	if ( ! $archive_page_id || ! in_array( $option, array( 'default', 'archive_base' ), true ) || ! get_option( 'permalink_structure' ) ) {
		$option = 'default';
	}
?>
	<?php echo wpautop( esc_html__( 'These settings control the permalinks used specifically for event products.', 'astoundify-wc-themes' ) ); ?>

	<table class="form-table wc-permalink-structure">

		<tbody>
			<tr>
				<th><label><input name="event_permalink_option" type="radio" value="default" <?php checked( 'default', $option ); ?>/> <?php esc_html_e( 'Default', 'astoundify-wc-themes' ); ?></label></th>
				<td><p class="description"><?php esc_html_e( 'Use product permalink structure.', 'astoundify-wc-themes' ); ?></p></td>
			</tr>

			<?php if ( $archive_page_id && get_option( 'permalink_structure' ) ) : ?>

				<tr>
					<th><label><input name="event_permalink_option" type="radio" value="archive_base" <?php checked( 'archive_base', $option ); ?>/> <?php esc_html_e( 'Event Base', 'astoundify-wc-themes' ); ?></label></th>
					<td><code><?php echo esc_url( home_url() ); ?>/<?php echo esc_html( astoundify_wc_themes_events_archive_slug() ); ?>/sample-event/</code></td>
				</tr>

			<?php endif; ?>

		</tbody>

	</table>
	<?php wp_nonce_field( 'astoundify_wc_themes_events_permalink', '_astoundify_wc_themes_events_permalink_nonce' ); ?>
<?php
}

/**
 * Save Permalink Settings
 *
 * Permalink settings need to be updated manually. We cannot use settings API in permalink settings.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_permalink_settings_save() {
	if ( ! isset( $_POST['event_permalink_option'], $_POST['_astoundify_wc_themes_events_permalink_nonce'] ) || ! wp_verify_nonce( $_POST['_astoundify_wc_themes_events_permalink_nonce'], 'astoundify_wc_themes_events_permalink' ) ) {
		return;
	}

	$option = $_POST['event_permalink_option'];

	if ( ! in_array( $option, array( 'default', 'archive_base' ), true ) ) {
		$option = 'default';
	}

	update_option( 'astoundify_wc_themes_events_permalink_option', esc_attr( $option ) );
}
add_action( 'admin_init', 'astoundify_wc_themes_events_permalink_settings_save' );

/**
 * Enable Custom Permalink Base for Events Product.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function astoundify_wc_themes_events_enable_custom_permalink() {
	// Bail early if pretty permalink disabled.
	if ( ! get_option( 'permalink_structure' ) ) {
		return false;
	}

	$archive_page_id = astoundify_wc_themes_events_get_archive_page_id();
	$option = get_option( 'astoundify_wc_themes_events_permalink_option', 'default' );

	// Always use default if archive page not selected or not valid.
	if ( ! $archive_page_id || ! in_array( $option, array( 'default', 'archive_base' ), true ) ) {
		$option = 'default';
	}

	return 'default' === $option ? false : true;
}

/**
 * Get Event Archive Slug.
 *
 * @since 1.0.0
 *
 * @return string
 */
function astoundify_wc_themes_events_archive_slug() {
	$page_id = astoundify_wc_themes_events_get_archive_page_id();
	if ( ! $page_id ) {
		return '';
	}
	$post = get_post( $page_id );
	return $post->post_name;
}

/**
 * Generate Rewrite Rule.
 *
 * So, basically the request URL is 'https://site.com?astoundify_wc_themes_event_product={product_slug}',
 * And it will be converted to 'https://site.com/{event product base}/{product_slug}'
 *
 * This function only called when permalink are flush.
 *
 * @since 1.0.0
 *
 * @return array
 */
function astoundify_wc_themes_events_rewrite_rules() {
	global $wp_rewrite;

	// Bail if not enabled.
	if ( ! astoundify_wc_themes_events_enable_custom_permalink() ) {
		return $wp_rewrite->rules;
	}

	// The request pattern to rewrite.
	$wp_rewrite->add_rewrite_tag( '%product%', '(.+?)', 'astoundify_wc_themes_event_product=' );

	// Rewritten URL.
	$base = astoundify_wc_themes_events_archive_slug();
	$rewrite_keywords_structure = "/{$base}/%product%/";

	// Generate rewrite rule based on pattern structure,
	$new_rule = $wp_rewrite->generate_rewrite_rules( $rewrite_keywords_structure );

	// Add it in rewrite rule.
	$wp_rewrite->rules = $new_rule + $wp_rewrite->rules;
	return $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'astoundify_wc_themes_events_rewrite_rules' );

/**
 * Add Query Var So WP Can Recognize it.
 *
 * @since 1.0.0
 *
 * @param array $vars Query vars.
 * @return array
 */
function astoundify_wc_themes_events_add_query_vars( $vars ) {
	// Bail if not enabled.
	if ( ! astoundify_wc_themes_events_enable_custom_permalink() ) {
		return $vars;
	}

	$vars[] = 'astoundify_wc_themes_event_product';
	return $vars;
}
add_filter( 'query_vars', 'astoundify_wc_themes_events_add_query_vars', 0 );

/**
 * Filter event permalink
 *
 * @see wc_product_post_type_link() in wc/includes/wc-product-functions.php
 */
function astoundify_wc_themes_events_product_post_type_link( $permalink, $post ) {
	// Bail if not enabled.
	if ( ! astoundify_wc_themes_events_enable_custom_permalink() ) {
		return $permalink;
	}

	if ( 'product' !== $post->post_type ) {
		return $permalink;
	}

	$product = wc_get_product( $post );

	if ( $product && 'event' === $product->get_type() ) {

		$url = get_permalink( astoundify_wc_themes_events_get_archive_page_id() );

		$permalink = user_trailingslashit( untrailingslashit( trailingslashit( $url ) . $post->post_name ) );
	}
	return $permalink;
}
add_filter( 'post_type_link', 'astoundify_wc_themes_events_product_post_type_link', 20, 2 );

/**
 * Sample Permalink.
 * This is to enable editable slug in edit post screen using our custom base.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_get_sample_permalink( $permalink, $post_id, $title, $name, $post ) {
	// Bail if not enabled.
	if ( ! astoundify_wc_themes_events_enable_custom_permalink() ) {
		return $permalink;
	}

	if ( 'product' !== $post->post_type ) {
		return $permalink;
	}

	// Get Product object.
	$product = wc_get_product( $post );

	// Only filter product object.
	if ( $product && 'event' === $product->get_type() ) {

		$url = get_permalink( astoundify_wc_themes_events_get_archive_page_id() );
		$pattern = untrailingslashit( trailingslashit( $url ) . '%pagename%' );
		$slug = $post->post_name;

		if ( ! is_null( $name ) ) {
			$post->post_name = sanitize_title( $name ? $name : $post->post_name, $post->ID );
		}

		$post->post_name = wp_unique_post_slug( $post->post_name, $post->ID, $post->post_status, $post->post_type, $post->post_parent );

		$permalink = array( $pattern, $post->post_name );
	}

	return $permalink;
}
add_filter( 'get_sample_permalink', 'astoundify_wc_themes_events_get_sample_permalink', 20, 5 );

/**
 * Pre Get Posts: Set requested page to product page if product found.
 *
 * @since 1.0.0
 * @see WC_Query::pre_get_posts() "woocommerce/includes/class-wc-query.php".
 *
 * @param object $q WP_Query
 */
function astoundify_wc_themes_events_singular_pre_get_posts( $q ) {
	// Bail if not enabled.
	if ( ! astoundify_wc_themes_events_enable_custom_permalink() ) {
		return;
	}

	if ( ! $q->is_main_query() || is_admin() ) {
		return;
	}

	if ( ! isset( $q->query['astoundify_wc_themes_event_product'] ) ) {
		return;
	}
	if ( ! $q->query['astoundify_wc_themes_event_product'] ) {
		return;
	}

	$product_slug = $q->query['astoundify_wc_themes_event_product'];

	// Check if product exists.
	$args = array(
		'name'           => $product_slug,
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
	);
	$posts = get_posts( $args );
	if ( ! $posts ) {
		$q->set( 'name', $product_slug );
		$q->is_404 = true;
		$q->is_home = false;
		return;
	}

	$post = current( $posts );
	$product = wc_get_product( $post );
	if ( ! $product || 'event' !== $product->get_type() ) {
		$q->set( 'name', $product_slug );
		$q->is_404 = true;
		$q->is_home = false;
		return;
	}

	$q->set( 'name', $product_slug );
	$q->set( 'product', $product_slug );
	$q->set( 'post_type', 'product' );
	$q->is_singular = true;
	$q->is_home = false;
	$q->is_single = true;
}
add_action( 'pre_get_posts', 'astoundify_wc_themes_events_singular_pre_get_posts' );

/**
 * Redirect to Correct Permalink if Event Base Enabled.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_custom_permalink_redirect() {
	// Bail if not enabled.
	if ( ! astoundify_wc_themes_events_enable_custom_permalink() ) {
		return;
	}

	if ( ! is_singular( 'product' ) ) {
		return;
	}

	$product = wc_get_product( get_queried_object() );

	if ( 'event' !== $product->get_type() ) {
		return;
	}

	if ( get_query_var( 'astoundify_wc_themes_event_product' ) ) {
		return;
	}

	$permalink = get_permalink( astoundify_wc_themes_events_get_archive_page_id() );
	$permalink = user_trailingslashit( trailingslashit( $permalink ) . get_query_var( 'product' ) );
	wp_safe_redirect( esc_url_raw( $permalink ) );
	exit;
}
add_action( 'template_redirect', 'astoundify_wc_themes_events_custom_permalink_redirect' );
