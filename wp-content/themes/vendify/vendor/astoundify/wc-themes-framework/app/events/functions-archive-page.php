<?php
/**
 * Archive Page
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
 * Events Products Archive Page Settings
 *
 * @since 1.0.0
 *
 * @param array $settings Settings.
 * @return array
 */
function astoundify_wc_themes_events_product_settings( $settings ) {
	$_settings = array();

	// Add settings in catalog option section.
	foreach ( $settings as $setting ) {
		if ( 'sectionend' === $setting['type'] && 'catalog_options' === $setting['id'] ) {
			$_settings[] = array(
				'title'    => __( 'Events page', 'astoundify-wc-themes' ),
				'desc'     => '<br/>' . esc_html__( 'Select page as events archive page.', 'astoundify-wc-themes' ),
				'id'       => 'astoundify_wc_themes_events_page_id',
				'type'     => 'single_select_page',
				'default'  => '',
				'class'    => 'wc-enhanced-select-nostd',
				'css'      => 'min-width:300px;',
				'desc_tip' => __( 'This sets the base page of your events products - this is where your events archive will be.', 'astoundify-wc-themes' ),
			);
			$_settings[] = $setting;
		} else {
			$_settings[] = $setting;
		}
	}

	return $_settings;
}
add_filter( 'woocommerce_product_settings', 'astoundify_wc_themes_events_product_settings' );

/**
 * Events Page ID.
 *
 * @since 1.0.0
 *
 * @return int|false
 */
function astoundify_wc_themes_events_get_archive_page_id() {
	$page_id = get_option( 'astoundify_wc_themes_events_page_id' );
	if ( $page_id && get_post( $page_id ) ) {
		return $page_id;
	}
	return false;
}

/**
 * Is Events Page.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function astoundify_wc_themes_events_is_archive_page() {
	$page_id = astoundify_wc_themes_events_get_archive_page_id();
	if ( $page_id && is_page( $page_id ) && is_post_type_archive( 'product' ) ) {
		return true;
	}
	return false;
}

/**
 * Pre Get Posts
 *
 * Create faux archive page by overriding WP main query.
 * This is similar with how WC override main query of shop page is used as front page.
 *
 * @since 1.0.0
 * @see WC_Query::pre_get_posts() "woocommerce/includes/class-wc-query.php".
 *
 * @param object $q WP_Query
 */
function astoundify_wc_themes_events_pre_get_posts( $q ) {
	if ( ! $q->is_main_query() || is_admin() ) {
		return;
	}

	// Only in Events Archive Page.
	$page_id = astoundify_wc_themes_events_get_archive_page_id();
	if ( ! $page_id || ! $q->is_page() || absint( $q->get_queried_object_id() ) !== absint( $page_id ) ) {
		return;
	}

	// Set Query.
	$q->set( 'post_type', 'product' );
	$q->set( 'page_id', '' );
	$q->is_singular          = false;
	$q->is_post_type_archive = true;
	$q->is_archive           = true;
	$q->is_page              = true;

	// Simple Duplicate Functionality of WC_Query.
	// Ordering.
	if ( ! is_feed() ) {
		$ordering  = WC()->query->get_catalog_ordering_args();
		$q->set( 'orderby', $ordering['orderby'] );
		$q->set( 'order', $ordering['order'] );

		if ( isset( $ordering['meta_key'] ) ) {
			$q->set( 'meta_key', $ordering['meta_key'] );
		}
	}

	// Meta Query.
	$q->set( 'meta_query', WC()->query->get_meta_query( $q->get( 'meta_query' ), true ) );

	// Tax Query.
	$tax_query = $q->get( 'tax_query' );
	if ( ! is_array( $tax_query ) ) {
		$tax_query = array(
			'relation' => 'AND',
		);
	}
	$tax_query[] = array(
		'taxonomy'      => 'product_type',
		'field'         => 'slug',
		'terms'         => array( 'event' ),
	);
	$q->set( 'tax_query', WC()->query->get_tax_query( $tax_query, true ) );

	// Posts Per Page.
	$q->set( 'posts_per_page', $q->get( 'posts_per_page' ) ? $q->get( 'posts_per_page' ) : apply_filters( 'loop_shop_per_page', get_option( 'posts_per_page' ) ) );

	// WC Query.
	$q->set( 'wc_query', 'product_query' );

	// Post In.
	$q->set( 'post__in', array_unique( (array) apply_filters( 'loop_shop_post_in', array() ) ) );

	/**
	 * WordPress Query (Posts Where) Will seek for current page if it's not a blog page
	 * We can filter it, so it will think that this page is posts page.
	 *
	 * add_filter( 'option_page_for_posts', function() use( $page_id ) {
	 *    return $page_id;
	 * } );
	 * add_filter( 'option_show_on_front', function() {
	 *    return 'page';
	 * } );
	 *
	 * Or filter Posts Where Clause, and remove the current page from DB request.
	 * I think it's safer, because it will filter/target specific ID in the clause.
	 *
	 * $where .= " AND ({$wpdb->posts}.ID = '$reqpage')";
	 *
	 * @see "wp-includes/class-wp-query.php" Line 1936-1948.
	 */
	add_filter( 'posts_where', function( $where ) use ( $page_id ) {
		global $wpdb;

		// Remove SQL string for current page lookup.
		$where = str_replace( "AND ({$wpdb->posts}.ID = '{$page_id}')", '', $where );
		return $where;
	});
}
add_action( 'pre_get_posts', 'astoundify_wc_themes_events_pre_get_posts' );

/**
 * Archive Title
 *
 * @since 1.0.0
 *
 * @param string $title Archive Title
 * @return string
 */
function astoundify_wc_themes_events_archive_title( $page_title ) {
	if ( astoundify_wc_themes_events_is_archive_page() ) {
		$page_title = get_the_title( astoundify_wc_themes_events_get_archive_page_id() );
	}
	return $page_title;
}
add_filter( 'woocommerce_page_title', 'astoundify_wc_themes_events_archive_title' );
