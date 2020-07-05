<?php
/**
 * WooCommerce Product Vendors Template
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use stdClass;
use WC_Product_Vendors_Utils;
use WP_Query;
use WP_Term_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Filter returned page templates.
 *
 * @since 1.0.0
 *
 * @param array $post_templates The current list of templates.
 * @return array
 */
function woocommerce_product_vendors_templates( $post_templates ) {
	if ( ! astoundify_wc_themes_has_support( 'vendors' ) ) {
		return $post_templates;
	}

	$post_templates['app/integrations/woocommerce/views/archive-vendor.php'] = esc_html_x( 'Find Vendors', 'page template title', 'vendify' );

	return $post_templates;
}

/**
 * Add JS config.
 *
 * @since 1.0.0
 *
 * @param array $args i18n Arguments.
 * @return array
 */
function woocommerce_product_vendors_i18n( $args ) {
	if ( ! isset( $args['woocommerce'] ) ) {
		$args['woocommerce'] = [];
	}

	$args['woocommerce']['findVendorsUrl'] = woocommerce_product_vendors_search_url();

	return $args;
}

/**
 * Find the page URL to search for vendors.
 *
 * @since 1.0.0
 *
 * @return string
 */
function woocommerce_product_vendors_search_url() {
	$page = get_transient( 'vendify-vendors-search-page' );

	if ( false === $page ) {

		// @codingStandardsIgnoreStart
		$query = new WP_Query(
			[
				'fields'                 => 'ids',
				'nopaging'               => true,
				'post_type'              => 'page',
				'update_post_meta_cache' => false,
				'update_term_meta_cache' => false,
				'posts_per_page'         => 1,
				'meta_query'             => [
					[
						'key'     => '_wp_page_template',
						'value'   => 'app/integrations/woocommerce/views/archive-vendor.php',
						'compare' => '=',
					],
				],
			]
		);

		// @codingStandardsIgnoreEnd
		if ( ! empty( $query->posts ) ) {
			set_transient( 'vendify-vendors-search-page', $query->posts[0] );
		}
	}

	return get_permalink( $page );
}

/**
 * Delete transient when an object saves.
 *
 * @since 1.0.0
 */
function woocommerce_product_vendors_search_url_reset() {
	delete_transient( 'vendify-vendors-search-page' );
}

/**
 * Turn off transparent header on the dashboard page.
 *
 * @since 1.0.0
 *
 * @param bool $transparent Current status.
 * @return bool
 */
function woocommerce_product_vendors_is_transparent_header( $transparent ) {
	if ( astoundify_wc_themes_vendors_is_dashboard() ) {
		return false;
	}

	if ( is_page_template( 'app/integrations/woocommerce/views/archive-vendor.php' ) && ! empty( woocommerce_product_vendors_get_featured_vendors() ) ) {
		return true;
	}

	return $transparent;
}

/**
 * Get featured vendors.
 *
 * @since 1.0.0
 *
 * @return array|false
 */
function woocommerce_product_vendors_get_featured_vendors( $args = [] ) {
	$defaults = [
		'meta_key' => 'vendor_featured', // @codingStandardsIgnoreLine
        'meta_value'   => '1',
		'meta_compare'   => '=',
		'taxonomy' => WC_PRODUCT_VENDORS_TAXONOMY,
	];

	$args = wp_parse_args( $args, $defaults );

	$featured = new WP_Term_Query( $args );

	return $featured->get_terms();
}

/**
 * Get the ID of the vendor admin.
 *
 * @since 1.0.0
 *
 * @param int $vendor Vendor term ID.
 * @return int
 */
function woocommerce_product_vendors_get_vendor_user_id( $vendor ) {
	$vendor_data = get_term_meta( $vendor, 'vendor_data', true );

	return is_array( $vendor_data['admins'] ) ? current( $vendor_data['admins'] ) : $vendor_data['admins'];
}

/**
 * Get the vendor data based on a product.
 *
 * @since 1.0.0
 *
 * @param int $product_id Product ID.
 * @return array
 */
function woocommerce_product_vendors_get_vendor_by_product( $product_id ) {
	$vendor_id = WC_Product_Vendors_Utils::get_vendor_id_from_product( $product_id );

	return WC_Product_Vendors_Utils::get_vendor_data_by_id( $vendor_id );
}

/**
 * Default vendor data that doesn't exist in the plugin.
 *
 * @since 1.0.0
 *
 * @return array
 */
function get_default_vendor_meta() {
	return [
		'term_id'     => false,
		'name'        => false,
		'link'        => false,
		'logo'        => false,
		'logo_image'  => false,
		'cover'       => false,
		'cover_image' => false,
		'location'    => false,
		'profile'     => false,
	];
}

/**
 * Merge extra defaults with existing store settings.
 *
 * @since 1.0.0
 *
 * @param array $vendor_data Existing vendor data.
 * @return array
 */
function astoundify_wc_themes_vendor_dashboard_store_settings_data( $vendor_data ) {
	return wp_parse_args( $vendor_data, get_default_vendor_meta() );
}

/**
 * Get vendor meta merged with the user meta.
 *
 * @todo make a bit more dynamic.
 *
 * @since 1.0.0
 *
 * @param int $object_id The object to source the vendor meta from.
 * @param int $object_type The type of object the data is being sourced from.
 * @return mixed
 */
function get_vendor_meta( $object_id, $object_type = 'vendor_id' ) {
	$defaults = get_default_vendor_meta();

	switch ( $object_type ) {
		case 'product_id':
			$vendor_data = woocommerce_product_vendors_get_vendor_by_product( $object_id );
			break;
		case 'user_id':
			$vendor_data = current( WC_Product_Vendors_Utils::get_all_vendor_data( $object_id ) );
			break;
		default:
			$vendor_data = WC_Product_Vendors_Utils::get_vendor_data_by_id( $object_id );
	}

	$vendor_data = wp_parse_args( $vendor_data, $defaults );

	// Store in separate meta.
	foreach ( [ 'vendor_profile', 'shipping_policy', 'return_policy', 'vendor_tagline', 'vendor_location', 'vendor_name' ] as $meta ) {
		$vendor_data[ $meta ] = get_term_meta( $vendor_data['term_id'], $meta, true );
	}

	if ( ! empty( $vendor_data ) ) {
		// Populate with a link.
		$link                = get_term_link( $vendor_data['term_id'], WC_PRODUCT_VENDORS_TAXONOMY );
		$vendor_data['link'] = ! is_wp_error( $link ) ? $link : false;

		// Add a logo image.
		$logo                      = isset( $vendor_data['logo'] ) ? absint( $vendor_data['logo'] ) : false;
		$vendor_data['logo_image'] = $logo ? wp_get_attachment_image_url( $logo, 'thumbnail' ) : get_avatar_url(
			0,
			[
				'size' => 150,
			]
		);

		$cover                      = isset( $vendor_data['cover'] ) ? absint( $vendor_data['cover'] ) : false;
		$vendor_data['cover_image'] = $cover ? wp_get_attachment_image_url( (int) $cover, 'cover' ) : false;

		if ( isset( $vendor_data['admins'] ) ) {
			$user_data = get_userdata( current( (array) $vendor_data['admins'] ) );

			if ( $user_data ) {
				return wp_parse_args( $vendor_data, get_object_vars( $user_data->data ) );
			}
		}
	}

	return $vendor_data;
}

/**
 * Return a cached list of Vendor product IDs.
 *
 * @since 1.0.0
 *
 * @param int $vendor_id Vendor to get products for.
 * @return array
 */
function get_vendor_product_ids( $vendor_id ) {
	$products = wp_cache_get( $vendor_id . '_product_ids', 'vendify' );

	if ( false === $products ) {
		$products = (array) WC_Product_Vendors_Utils::get_vendor_product_ids( $vendor_id );

		wp_cache_set( $vendor_id . '_product_ids', $products, 'vendify' );
	}

	return $products;
}

/**
 * Get vendor products count.
 *
 * @since 1.0.0
 *
 * @param int $vendor_id Vendor to get products for.
 * @return int
 */
function get_vendor_products_count( $vendor_id ) {
	return count( get_vendor_product_ids( $vendor_id ) );
}

/**
 * Get vendor products.
 *
 * Uses the unlimited query since that is built in to WC Product Vendors and
 * is likely already cached at this point. This wrapper allows the rest of
 * the query to be modified.
 *
 * @since 1.0.0
 *
 * @param int   $vendor_id Vendor to get products for.
 * @param array $args Modify arguments for wc_get_products().
 * @return array
 */
function get_vendor_products( $vendor_id, $args = [] ) {
	$products = get_vendor_product_ids( $vendor_id );

	$key = array_search( get_the_ID(), $products, true );

	if ( false !== $key ) {
		unset( $products[ $key ] );
	}

	if ( empty( $products ) ) {
		$products = [ -9999 ];
	}

	$defaults = [
		'include' => (array) $products,
	];

	$args = wp_parse_args( $args, $defaults );

	return wc_get_products( $args );
}

/**
 * Use the vendor logo as a user's avatar if available.
 *
 * @since 1.0.0
 *
 * @param mixed $url Current avatar.
 * @param mixed $id_or_email ID or email to fetch.
 *
 * @return mixed $url The avatar URL.
 */
function wc_product_vendors_get_avatar_url( $url, $id_or_email ) {
	// We can't get it by a email.
	if ( $id_or_email && ! is_numeric( $id_or_email ) && is_string( $id_or_email ) ) {
		$user = get_user_by( 'user_email', $id_or_email );

		if ( $user ) {
			$id_or_email = $user->ID;
		}
	}

	if ( ! $id_or_email ) {
		return $url;
	}

	if ( ! WC_Product_Vendors_Utils::is_vendor( $id_or_email ) ) {
		return $url;
	}

	$data = get_vendor_meta( $id_or_email, 'user_id' );

	if ( $data['logo_image'] ) {
		return esc_url( $data['logo_image'] );
	}

	return $url;
}

/**
 * Vendor profile shop.
 *
 * @since 1.0.0
 */
function vendor_archive_shop() {
	add_filter( 'option_woocommerce_catalog_columns', function() {
			return 3;
	});

	wc_get_template( 'products.php' );
}

/**
 * Vendor profile about.
 *
 * @since 1.0.0
 */
function vendor_archive_about() {
	$vendor_id   = get_queried_object_id();
	$vendor_data = get_vendor_meta( $vendor_id );

	echo wp_kses_post( wpautop( $vendor_data['vendor_profile'] ) );
}

/**
 * Vendor profile reviews.
 *
 * @since 1.0.0
 */
function vendor_archive_reviews() {
	wc_get_template( 'single-vendor/reviews.php' );
}

/**
 * Vendor register form.
 *
 * @since 1.0.0
 *
 * @param bool $echo Display the form or not.
 *
 * @return string
 */
function vendor_registration_form() {
	ob_start();

	wc_get_template( 'vendors/form-register.php' );

	$form = ob_get_clean();

	return $form;
}

/**
 * Return tabs and data for "Find Vendors" page.
 *
 * @since 1.0.0
 *
 * @return array
 */
function woocommerce_product_vendors_find_vendor_tabs() {
	$top = astoundify_wc_themes_vendors_get_top_vendors(
		[
			'limit' => 16,
			'range' => null
		]
	);

	// $best_rated = astoundify_wc_themes_vendors_get_top_vendors(
	// 	[
	// 		'range' => null,
	// 		'limit' => 16,
	// 	]
	// );

	$newest  = [];
	$_newest = get_terms(
		[
			'taxonomy' => WC_PRODUCT_VENDORS_TAXONOMY,
			'fields'   => 'ids',
			'limit'    => 16,
		]
	);

	if ( $_newest && ! is_wp_error( $newest ) ) {
		foreach ( $_newest as $term ) {
			$match            = new stdClass();
			$match->vendor_id = $term;

			$newest[] = $match;
		}
	}

	$tabs = [];

	// if ( ! empty( $best_rated ) ) {
	// 	$tabs['best-rated'] = [
	// 		'label' => esc_html__( 'Best Rated', 'vendify' ),
	// 		'data'  => $best_rated,
	// 	];
	// }

	if ( ! empty( $newest ) ) {
		$tabs['newest'] = [
			'label' => esc_html__( 'Newest', 'vendify' ),
			'data'  => $newest,
		];
	}

	if ( ! empty( $top ) ) {
		$tabs['best-sellers'] = [
			'label' => esc_html__( 'Best Sellers', 'vendify' ),
			'data'  => $top,
		];
	}

	return apply_filters( 'vendify_woocommerce_product_vendors_find_vendor_tabs', $tabs );
}

/**
 * Return results for a vendor search.
 *
 * @since 1.0.0
 *
 * @return array
 */
function woocommerce_product_vendors_find_vendor_search() {
	$results = [];

	// @codingStandardsIgnoreStart
	if ( ! isset( $_GET['vendor_search'] ) ) {
		return $results;
	}

	$keyword  = isset( $_GET['vendor_keyword'] ) ? esc_attr( $_GET['vendor_keyword'] ) : '';
	$location = isset( $_GET['vendor_location'] ) ? esc_attr( $_GET['vendor_location'] ) : '';

	$args = array(
		'taxonomy'   => WC_PRODUCT_VENDORS_TAXONOMY,
		'fields'     => 'ids',
		'meta_query' => array(
			'relation' => 'OR',
		),
	);

	if ( '' !== $keyword ) {
		$args['meta_query'][] = array(
			'key'     => 'vendor_name',
			'value'   => $keyword,
			'compare' => 'LIKE',
		);

		$args['meta_query'][] = array(
			'key'     => 'vendor_profile',
			'value'   => $keyword,
			'compare' => 'LIKE',
		);

		$args['meta_query'][] = array(
			'key'     => 'vendor_tagline',
			'value'   => $keyword,
			'compare' => 'LIKE',
		);
	}

	if ( '' !== $location ) {
		$args['meta_query'][] = array(
			'key'     => 'vendor_location',
			'value'   => $location,
			'compare' => 'LIKE',
		);
	}
	// @codingStandardsIgnoreEnd

	$vendors = get_terms( $args );

	if ( ! $vendors || is_wp_error( $vendors ) ) {
		return $results;
	}

	foreach ( $vendors as $vendor ) {
		$match            = new stdClass();
		$match->vendor_id = $vendor;

		$results[] = $match;
	}

	return $results;
}


/**
 * Add Policy tab to product page.
 *
 * @since 1.0.0
 *
 * @param array $tabs Current tabs.
 * @return array
 */
function woocommerce_product_tabs( $tabs ) {
	global $product;

	$vendor_data = get_vendor_meta( $product->get_id(), 'product_id' );
	$shipping    = isset( $vendor_data['shipping_policy'] ) && '' !== $vendor_data['shipping_policy'] ? $vendor_data['shipping_policy'] : false;
	$return      = isset( $vendor_data['return_policy'] ) && '' !== $vendor_data['return_policy'] ? $vendor_data['return_policy'] : false;

	if ( $shipping || $return ) {
		$tabs['policies'] = [
			'title'    => __( 'Policies', 'vendify' ),
			'priority' => 60,
			'callback' => 'Astoundify\Vendify\woocommerce_product_policies_tab',
		];
	}

	return $tabs;
}
