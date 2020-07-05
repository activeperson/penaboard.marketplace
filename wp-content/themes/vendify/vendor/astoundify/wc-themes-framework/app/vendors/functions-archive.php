<?php
/**
 * Vendor Archive Functions
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

/**
 * Replace {{vendor-shop}} custom link URL with a link to the current vendor's store.
 *
 * Or remove the item if not a vendor.
 *
 * @since  1.0.0
 *
 * @param string $item_output Item output.
 * @param object $item        Item.
 * @param int    $depth       Depth.
 * @param array  $args        Args.
 * @return string $item_output
 */
function astoundify_wc_themes_vendors_shop_link( $item_output, $item, $depth, $args ) {
	// WordPress sanitizes the URL so the tag gets modified.
	if ( false === strpos( $item->url, 'http://vendor-shop' ) ) {
		return $item_output;
	}

	if ( ! WC_Product_Vendors_Utils::is_vendor() ) {
		return '';
	}

	$item_output = str_replace( 'http://vendor-shop', get_term_link( WC_Product_Vendors_Utils::get_user_active_vendor(), WC_PRODUCT_VENDORS_TAXONOMY ), $item_output );

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'astoundify_wc_themes_vendors_shop_link', 10, 4 );

/**
 * Add Query Variable so WP can recognize it.
 *
 * @since 1.0.0
 *
 * @param array $vars Query vars.
 * @return array
 */
function astoundify_wc_themes_vendors_archive_add_query_vars( $vars ) {
	$vars[] = 'astoundify_wc_themes_vendor_endpoint';
	$vars[] = 'astoundify_wc_themes_vendor_endpoint_paged';
	return $vars;
}
add_filter( 'query_vars', 'astoundify_wc_themes_vendors_archive_add_query_vars' );

/**
 * Archive Endpoints.
 *
 * @since 1.0.0
 *
 * @return array
 */
function astoundify_wc_themes_vendors_archive_endpoints() {
	$options = array(
		'reviews'  => 'reviews',
		'about'    => 'about',
		'policies' => 'policies',
	);

	$endpoints = array(
		'reviews' => array(
			'title'    => esc_html__( 'Reviews', 'astoundify-wc-themes' ),
			'slug'     => $options['reviews'],
			'paged'    => true,
		),
		'about' => array(
			'title'    => esc_html__( 'About', 'astoundify-wc-themes' ),
			'slug'     => $options['about'],
			'paged'    => false,
		),
	);

	if ( 'virtual' !== get_option( 'woocommerce_product_type' ) ) {
		$endpoints['policies'] = array(
			'title' => esc_html__( 'Policies', 'astoundify-wc-themes' ),
			'slug'  => $options['policies'],
			'paged' => false,
		);
	}
	
	return apply_filters( 'astoundify_wc_themes_vendors_archive_endpoints', $endpoints );
}

/**
 * Add Vendor Archive Endpoint Rewrite Rule.
 * The rewrite rule below need to be in correct order.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_archive_rewrite_rule() {
	$endpoints = astoundify_wc_themes_vendors_archive_endpoints();

	foreach ( $endpoints as $endpoint => $data ) {
		// Pagination: Need to be defined before slug.
		if ( $data['paged'] ) {
			add_rewrite_rule( '^vendor/([^/]*)/' . $data['slug'] . '/([0-9]+)/?', 'index.php?wcpv_product_vendors=$matches[1]&astoundify_wc_themes_vendor_endpoint=' . $endpoint . '&astoundify_wc_themes_vendor_endpoint_paged=$matches[2]', 'top' );
		}

		add_rewrite_rule( '^vendor/([^/]*)/' . $data['slug'] . '/?', 'index.php?wcpv_product_vendors=$matches[1]&astoundify_wc_themes_vendor_endpoint=' . $endpoint, 'top' );
	}
}
add_action( 'init', 'astoundify_wc_themes_vendors_archive_rewrite_rule' );

/**
 * Get endpoint URL
 *
 * @since 1.0.0
 *
 * @param string           $endpoint Endpoint.
 * @param int|WP_Term|null $term_id  Vendor ID.
 * @return string|false
 */
function astoundify_wc_themes_vendors_archive_get_endpoint_url( $endpoint = 'shop', $term_id = null ) {
	if ( ! $term_id && is_tax( 'wcpv_product_vendors' ) ) {
		$term_id = get_queried_object();
	}

	if ( ! $term_id ) {
		return false;
	}

	$base_url = get_term_link( $term_id, 'wcpv_product_vendors' );

	if ( ! $base_url || is_wp_error( $base_url ) ) {
		return false;
	}

	// Endpoints & endpoint.
	$endpoints = astoundify_wc_themes_vendors_archive_endpoints();
	$endpoint = $endpoint && array_key_exists( $endpoint, $endpoints ) ? $endpoints[ $endpoint ] : $endpoints['shop'];

	// Shop endpoint is always the base page.
	if ( 'shop' === $endpoint ) {
		return esc_url( $base_url );
	}

	// Pretty permalink.
	if ( get_option( 'permalink_structure' ) ) {
		return esc_url( user_trailingslashit( trailingslashit( $base_url ) . $endpoint['slug'] ) );
	} else { // Ugly permalink.
		return esc_url( add_query_arg( 'astoundify_wc_themes_vendor_endpoint', $endpoint['slug'], $base_url ) );
	}
}

/**
 * Get active endpoint.
 *
 * @since 1.0.0
 *
 * @return string|false
 */
function astoundify_wc_themes_vendors_archive_get_active_endpoint() {
	// Need to be in vendor archive.
	if ( ! is_tax( 'wcpv_product_vendors' ) ) {
		return false;
	}

	// Valid endpoints.
	$endpoints = astoundify_wc_themes_vendors_archive_endpoints();

	// Get current endpoint.
	$endpoint = get_query_var( 'astoundify_wc_themes_vendor_endpoint', 'shop' );

	return $endpoint && array_key_exists( $endpoint, $endpoints ) ? $endpoint : 'shop';
}

/**
 * Get current page.
 *
 * @since 1.0.0
 *
 * @return int
 */
function astoundify_wc_themes_vendors_archive_get_page() {
	$page = absint( get_query_var( 'astoundify_wc_themes_vendor_endpoint_paged', 1 ) );
	$active = astoundify_wc_themes_vendors_archive_get_active_endpoint();
	$endpoints = astoundify_wc_themes_vendors_archive_endpoints();

	return absint( $page && $active && isset( $endpoints[ $active ]['paged'] ) && $endpoints[ $active ]['paged'] ? $page : 1 );
}
