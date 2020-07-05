<?php
/**
 * Product Filters functions.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Event
 * @author Astoundify
 */

/**
 * Filtering scripts and styles.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_filter_scripts() {
	if ( ! astoundify_wc_themes_events_is_archive_page() ) {
		return;
	}

	// Script Vars.
	$debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? true : false;
	$version = $debug ? time() : ASTOUNDIFY_WC_THEMES_VERSION;

	/* === CSS === */

	$deps = array();
	$url = ASTOUNDIFY_WC_THEMES_URL . 'public/assets/css/events-filters.min.css';
	if ( $debug ) {
		$deps[] = 'astoundify-wc-themes-date-picker';
		$url = ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/css/events-filters.css';
	}
	wp_enqueue_style( 'astoundify-wc-themes-events-filters', $url, $deps, $version );

	/* === JS === */

	$deps = array(
		'jquery',
		'jquery-ui-datepicker',
		'jquery-ui-slider',
		'wc-jquery-ui-touchpunch',
		'wp-util',
		'google-maps',
	);
	$url = ASTOUNDIFY_WC_THEMES_URL . 'public/assets/js/events-filters.min.js';
	if ( $debug ) {
		$url = ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/js/events-filters.js';
	}
	wp_register_script( 'astoundify-wc-themes-events-filters', $url, $deps, $version, true );

	$data = array(
		'settings' => array(
			'radius' => array(
				'unit'    => astoundify_wc_themes_events_distance_unit(),
				'default' => 50,
				'min'     => 10,
				'max'     => 100,
				'step'    => 10,
			),
			'autoCompleteArgs' => array(
				'types' => array( 'geocode' ),
			),
			'dateFormat' => astoundify_wc_themes_get_jquery_ui_dateformat(),
		),
	);
	wp_localize_script( 'astoundify-wc-themes-events-filters', 'astoundifyWcThemesEventFilters', apply_filters( 'astoundify_wc_themes_event_filters_js', $data ) );
}
add_action( 'wp_enqueue_scripts', 'astoundify_wc_themes_events_filter_scripts' );

/**
 * Add a wrapper around the shop loop so the content can be replaced dynamically.
 *
 * @todo: prefix with "events" or remove.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_before_shop_loop() {
	if ( ! astoundify_wc_themes_events_is_archive_page() ) {
		return;
	}
	echo '<div id="astoundify-wc-themes-loop">';
}
add_action( 'woocommerce_before_shop_loop', 'astoundify_wc_themes_before_shop_loop', 6 );
add_action( 'woocommerce_no_products_found', 'astoundify_wc_themes_before_shop_loop', 6 );

/**
 * Close wrapper around the shop loop so the content can be replaced dynamically.
 *
 * @todo: prefix with "events" or remove.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_after_shop_loop() {
	if ( ! astoundify_wc_themes_events_is_archive_page() ) {
		return;
	}
	echo '</div>';
}
add_action( 'woocommerce_after_shop_loop', 'astoundify_wc_themes_after_shop_loop', 20 );
add_action( 'woocommerce_no_products_found', 'astoundify_wc_themes_after_shop_loop', 15 );

/**
 * AJAX callback filters.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_product_results() {
	// @codingStandardsIgnoreStart
	global $wp_query;

	parse_str( $_REQUEST['formData'], $form_data );
	$_REQUEST = wp_parse_args( $form_data, $_REQUEST );

	$orderby_value = isset( $_REQUEST['orderby'] ) ? wc_clean( (string) $_REQUEST['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

	// Get order + orderby args from string
	$orderby_value = explode( '-', $orderby_value );
	$orderby = isset( $orderby_value[0] ) ? esc_attr( $orderby_value[0] ) : '';
	$order = isset( $orderby_value[1] ) ? esc_attr( $orderby_value[1] ) : '';

	$ordering = WC()->query->get_catalog_ordering_args( $orderby, $order );

	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'meta_query'     => WC()->query->get_meta_query( array(), false ),
		'tax_query'      => WC()->query->get_tax_query( null, false ),
		'post__in'       => array_unique( (array) apply_filters( 'loop_shop_post_in', array() ) ),
		'posts_per_page' => apply_filters( 'loop_shop_per_page', get_option( 'posts_per_page' ) ),
		'paged'          => absint( isset( $_REQUEST['page'] ) ?  $_REQUEST['page'] : 1 ),
		'orderby'        => $ordering['orderby'],
		'order'          => $ordering['order'],
		's'              => esc_attr( $_REQUEST['s'] ),
	);

	if ( isset( $ordering['meta_key'] ) ) {
		$args['meta_key'] = $ordering['meta_key'];
	}

	$GLOBALS['wp_query'] = new WP_Query( $args );

	$orig_req_uri = esc_url( $_SERVER['REQUEST_URI'] );
	$_SERVER['REQUEST_URI'] = esc_url( $_REQUEST['current_base'] );

	// @codingStandardsIgnoreEnd

	ob_start();

	astoundify_wc_themes_get_template( 'product-filters/archive-product-loop.php' );

	$display = ob_get_clean();

	// Reset everything.
	$_SERVER['REQUEST_URI'] = $orig_req_uri;
	wp_reset_postdata();

	return wp_send_json_success( $display );
}
add_action( 'wp_ajax_nopriv_astoundify_wc_themes_events_product_results', 'astoundify_wc_themes_events_product_results' );
add_action( 'wp_ajax_astoundify_wc_themes_events_product_results', 'astoundify_wc_themes_events_product_results' );

/**
 * Retrieve all registered filters.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_product_filters() {
	return array(
		'main_fields' => apply_filters( 'astoundify_wc_themes_events_main_product_filters', array(
			'keyword',
			'location',
			'date',
		) ),
		'extended_fields' => apply_filters( 'astoundify_wc_themes_events_extended_product_filters', array() ),
	);
}

/**
 * Load Filters Before Product Sort, After Notices.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_load_product_filters() {
	if ( did_action( 'astoundify_wc_themes_archive_product_loop' ) || ! astoundify_wc_themes_events_is_archive_page() ) {
		return;
	}

	wp_enqueue_script( 'astoundify-wc-themes-events-filters' );

	astoundify_wc_themes_get_template( 'product-filters/product-filters.php', astoundify_wc_themes_events_product_filters() );
}
add_action( 'woocommerce_before_shop_loop', 'astoundify_wc_themes_events_load_product_filters', 5 );
add_action( 'woocommerce_no_products_found', 'astoundify_wc_themes_events_load_product_filters', 5 );

/**
 * Keyword Field
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_product_filters_keyword_field() {
	astoundify_wc_themes_get_template( 'product-filters/field-keyword.php', array(
		'value' => get_search_query(),
	) );
}
add_action( 'astoundify_wc_themes_events_product_filters_keyword_field', 'astoundify_wc_themes_events_product_filters_keyword_field' );

/**
 * Location Field
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_product_filters_location_field() {
	// @codingStandardsIgnoreStart
	astoundify_wc_themes_get_template( 'product-filters/field-location.php', array(
		'value' => array(
			'location' => isset( $_GET['location'] ) ? $_GET['location'] : '',
			'lat'      => isset( $_GET['lat'] ) ? $_GET['lat'] : '',
			'lng'      => isset( $_GET['lng'] ) ? $_GET['lng'] : '',
			'radius'   => isset( $_GET['radius'] ) ? $_GET['radius'] : '50',
		),
	) );
	// @codingStandardsIgnoreEnd
}
add_action( 'astoundify_wc_themes_events_product_filters_location_field', 'astoundify_wc_themes_events_product_filters_location_field' );

/**
 * Date Field
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_product_filters_date_field() {
	// @codingStandardsIgnoreStart
	astoundify_wc_themes_get_template( 'product-filters/field-date.php', array(
		'value' => array(
			'schedule_start' => isset( $_GET['schedule_start'] ) ? $_GET['schedule_start'] : '',
			'schedule_end'   => isset( $_GET['schedule_end'] ) ? $_GET['schedule_end'] : '',
		),
	) );
	// @codingStandardsIgnoreEnd
}
add_action( 'astoundify_wc_themes_events_product_filters_date_field', 'astoundify_wc_themes_events_product_filters_date_field' );
