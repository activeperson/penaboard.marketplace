<?php
/**
 * Astoundify Favorites Functions
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

/**
 * Enable Product Favorites.
 *
 * @since 1.0.0
 *
 * @param array $post_types Supported post types.
 * @return array
 */
function astoundify_wc_themes_vendors_favorites_add_product_post_type( $post_types ) {
	$post_types[] = 'product';
	return $post_types;
}
add_filter( 'astoundify_favorites_post_types', 'astoundify_wc_themes_vendors_favorites_add_product_post_type' );

/**
 * Add Valid Favorite Target Type.
 *
 * @since 1.0.0
 *
 * @param array $post_types Supported post types.
 * @return array
 */
function astoundify_wc_themes_vendors_favorites_add_valid_target_type( $type ) {
	$type[] = 'wcpv_product_vendors';
	return $type;
}
add_filter( 'astoundify_favorites_valid_target_types', 'astoundify_wc_themes_vendors_favorites_add_valid_target_type' );

/**
 * Favorite Target Class Name
 *
 * @since 1.0.0
 *
 * @param string $classname   Class name.
 * @param string $target_type Target type.
 * @return string
 */
function astoundify_wc_themes_vendors_favorites_set_vendor_target_classname( $classname, $target_type ) {
	if ( 'wcpv_product_vendors' === $target_type ) {
		$classname = '\Astoundify\WC_Themes\Vendors\Favorite_Target';
	}
	return $classname;
}
add_filter( 'astoundify_favorites_get_favorite_target_classname','astoundify_wc_themes_vendors_favorites_set_vendor_target_classname', 10, 2 );

/**
 * Display Favorite Button in Vendor Archive.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_favorites_add_favorite_link() {
	global $wp_query;

	$term =	$wp_query->queried_object;

	if ( ! is_object( $term ) || empty( $term->term_id ) ) {
		return;
	}

	echo astoundify_favorites_link( $term->term_id, '<p class="vendor-favorite-link">', '</p>', 'wcpv_product_vendors' );
}
add_action( 'woocommerce_archive_description', 'astoundify_wc_themes_favorites_add_favorite_link' );
