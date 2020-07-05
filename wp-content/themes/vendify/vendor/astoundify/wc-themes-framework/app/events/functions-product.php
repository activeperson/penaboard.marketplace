<?php
/**
 * Product functions.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Products
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add custom product types.
 *
 * @since 1.0.0
 *
 * @param array $types Current product types.
 * @return array $types
 */
function astoundify_wc_themes_events_product_type_selector( $types ) {
	$types['event'] = esc_html__( 'Event product', 'astoundify-wc-themes' );

	return $types;
}
add_filter( 'product_type_selector', 'astoundify_wc_themes_events_product_type_selector' );

/**
 * When using the WC_Product_Factory ensure our custom product class is used if applicable.
 *
 * @since 1.0.0
 *
 * @param string $classname Current classname found.
 * @param string $product_type Current product type.
 * @return string $classname
 */
function astoundify_wc_themes_events_product_class( $classname, $product_type ) {
	if ( 'event' === $product_type ) {
		return 'Astoundify\WC_Themes\Products\Event';
	}

	return $classname;
}
add_filter( 'woocommerce_product_class', 'astoundify_wc_themes_events_product_class', 10, 2 );

/**
 * Add our custom data store to hold extra schema information.
 *
 * @since 1.0.0
 *
 * @param array $stores List of current data stores.
 * @return array $stores
 */
function astoundify_wc_themes_events_data_stores( $stores ) {
	$stores['product-event'] = 'Astoundify\WC_Themes\Datastores\Event';

	return $stores;
}
add_filter( 'woocommerce_data_stores', 'astoundify_wc_themes_events_data_stores' );

/**
 * Delete location data if product deleted.
 *
 * @since 1.0.0
 *
 * @param int $postid Product ID/Post ID.
 * @return void
 */
function astoundify_wc_themes_events_delete_product_location_data( $postid ) {
	$product = wc_get_product( $postid );

	if ( $product && 'event' === $product->get_type() ) {
		$product->get_data_store()->delete_location_data( $postid );
	}
}
add_action( 'before_delete_post', 'astoundify_wc_themes_events_delete_product_location_data' );

/**
 * Use simple add to cart for events.
 *
 * @since 1.0.0
 */
add_action( 'woocommerce_event_add_to_cart', 'woocommerce_simple_add_to_cart' );

/**
 * Add Tabs in Product Page.
 *
 * @since 1.0.0
 *
 * @param array $tabs Product Tabs.
 * @return array
 */
function astoundify_wc_themes_events_product_tabs( $tabs ) {
	global $product, $post;

	// Bail if not event.
	if ( 'event' !== $product->get_type() ) {
		return $tabs;
	}

	// Location.
	if ( $product->get_location_input() ) {
		$tabs['location'] = array(
			'title'    => esc_html__( 'Location', 'astoundify-wc-themes' ),
			'priority' => 12,
			'callback' => function() use ( $product ) {
				astoundify_wc_themes_get_template( 'product-tabs/location.php', array(
					'product' => $product,
				) );
			},
		);
	}

	// Schedule.
	if ( $product->get_schedule() ) {
		$tabs['schedule'] = array(
			'title'    => esc_html__( 'Schedule', 'astoundify-wc-themes' ),
			'priority' => 13,
			'callback' => function() use ( $product ) {
				astoundify_wc_themes_get_template( 'product-tabs/schedule.php', array(
					'product'   => $product,
				) );
			},
		);
	}

	// Attendees.
	if ( $product->get_attendees() ) {
		$tabs['attendees'] = array(
			'title'    => esc_html__( 'Attendees', 'astoundify-wc-themes' ),
			'priority' => 14,
			'callback' => function() use ( $product ) {
				astoundify_wc_themes_get_template( 'product-tabs/attendees.php', array(
					'product'   => $product,
				) );
			},
		);
	}

	// Sponsors.
	if ( $product->get_sponsors() ) {
		$tabs['sponsors'] = array(
			'title'    => esc_html__( 'Sponsors', 'astoundify-wc-themes' ),
			'priority' => 15,
			'callback' => function() use ( $product ) {
				astoundify_wc_themes_get_template( 'product-tabs/sponsors.php', array(
					'product'   => $product,
				) );
			},
		);
	}

	// Lineup
	if ( $product->get_lineup() ) {
		$tabs['lineup'] = array(
			'title'    => esc_html__( 'Lineup', 'astoundify-wc-themes' ),
			'priority' => 16,
			'callback' => function() use ( $product ) {
				astoundify_wc_themes_get_template( 'product-tabs/lineup.php', array(
					'product'   => $product,
				) );
			},
		);
	}

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'astoundify_wc_themes_events_product_tabs' );

/**
 * Product Type Query
 *
 * @since 1.0.0
 *
 * @param array    $tax_query Taxonomy Query.
 * @param WC_Query $query     WC Query.
 * @return array
 */
function astoundify_wc_themes_events_product_type_query( $tax_query, $query ) {
	// Enable search by product type.
	// @codingStandardsIgnoreStart
	if ( isset( $_REQUEST['product_type'] ) && $_REQUEST['product_type'] && is_array( $_REQUEST['product_type'] ) ) {
		// Filter by product type if requested.
		$tax_query[] = array(
			'taxonomy'      => 'product_type',
			'field'         => 'slug',
			'terms'         => $_REQUEST['product_type'],
		);
	} elseif ( ! astoundify_wc_themes_events_is_archive_page() && ! is_tax( 'wcpv_product_vendors' ) ) {
		// Exclude events product on regular shop page. Only show on events archive and vendors page.
		$tax_query[] = array(
			'taxonomy'      => 'product_type',
			'field'         => 'slug',
			'terms'         => array( 'event' ),
			'operator'      => 'NOT IN',
		);
	}
	// @codingStandardsIgnoreEnd

	return $tax_query;
}
add_filter( 'woocommerce_product_query_tax_query', 'astoundify_wc_themes_events_product_type_query', 10, 2 );

/**
 * Page Title
 *
 * @since 1.0.0
 *
 * @param string $page_title Page Title.
 * @return string
 */
function astoundify_wc_themes_events_product_page_title( $page_title ) {
	// Event search title.
	// @codingStandardsIgnoreStart
	if ( is_search() && isset( $_GET['product_type'] ) && is_array( $_GET['product_type'] ) && in_array( 'event', $_GET['product_type'], true ) ) {
		$page_title = esc_html__( 'Event Search', 'astoundify-wc-themes' );

		// Paged.
		if ( get_query_var( 'paged' ) ) {
			$page_title .= sprintf( esc_html__( '&nbsp;&ndash; Page %s', 'astoundify-wc-themes' ), get_query_var( 'paged' ) );
		}
	}
	// @codingStandardsIgnoreEnd

	return $page_title;
}
add_filter( 'woocommerce_page_title', 'astoundify_wc_themes_events_product_page_title' );

/**
 * Print Location/Place JSON-LD
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_product_add_json_ld() {
	if ( is_product() ) {
		$product = wc_get_product( get_queried_object_id() );

		if ( $product && 'event' === $product->get_type() && method_exists( $product, 'get_location_json_ld_data' ) && $data = wc_clean( $product->get_location_json_ld_data() ) ) {
			echo '<script type="application/ld+json">' . wp_json_encode( $data ) . '</script>';
		}
	}
}
add_action( 'wp_footer', 'astoundify_wc_themes_events_product_add_json_ld' );
