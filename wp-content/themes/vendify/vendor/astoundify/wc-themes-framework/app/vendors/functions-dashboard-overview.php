<?php
/**
 * Vendor Dashboard Overview Functions
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

/**
 * Get Report Sales By Date
 *
 * This is just a wrapper function, to make sure vendor sales by date class is included before loading the class.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_get_report_sales_by_date() {
	include_once( WC_PRODUCT_VENDORS_PATH . '/includes/admin/reports/vendor/class-wc-product-vendors-vendor-report-sales-by-date.php' );
	return new \Astoundify\WC_Themes\Vendors\Report_Sales_By_Date();
}

/**
 * Get number of active weeks of current vendor.
 *
 * Week since 1st order. This data is needed to calcualte lifetime weekly average.
 *
 * @since 1.0.0
 *
 * @param int $vendor_id Vendor ID.
 * @return int
 */
function astoundify_wc_themes_vendors_get_vendor_active_weeks( $vendor_id = null ) {
	global $wpdb;
	$vendor_id = ! $vendor_id ? WC_Product_Vendors_Utils::get_logged_in_vendor() : null;

	if ( ! WC_Product_Vendors_Utils::commission_table_exists() || ! $vendor_id ) {
		return 1;
	}

	$week = 1;

	// Get first order.
	$sql = 'SELECT order_date FROM ' . WC_PRODUCT_VENDORS_COMMISSION_TABLE;
	$sql .= ' WHERE 1=1';
	$sql .= ' AND `vendor_id` = %d';
	$sql .= ' ORDER BY `order_id` ASC';
	$sql .= ' LIMIT 1';
	$query = $wpdb->prepare( $sql, $vendor_id );
	$orders = $wpdb->get_results( $query );

	if ( $orders ) {
		$order = current( $orders );
		$order_date = strtotime( $order->order_date );
		$current_time = current_time( 'timestamp' );

		$from = DateTime::createFromFormat( 'U', $order_date );
		$to = DateTime::createFromFormat( 'U', $current_time );
		if ( ! $from || ! $to || $from > $to ) {
			$week = 1;
		} else {
			$_week = floor( $from->diff( $to )->days / 7 );
			$week = $_week > 1 ? $_week : 1;
		}
	}

	return absint( $week );
}

/**
 * Weekly Average Commission.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_get_vendor_weekly_average_commission( $vendor_id = null ) {
	$vendor_id = ! $vendor_id ? WC_Product_Vendors_Utils::get_logged_in_vendor() : null;
	$week = astoundify_wc_themes_vendors_get_vendor_active_weeks( $vendor_id );
	$total = astoundify_wc_themes_vendors_get_vendor_total_data( array(
		'column' => 'total_commission_amount',
		'status' => 'paid',
	) );
	if ( $week < 1 || $total < 1 ) {
		return $total;
	}
	return $total / $week;
}

/**
 * Get top vendors from commission table.
 *
 * @since 1.0.0
 *
 * @param array $args Options.
 * @return array
 */
function astoundify_wc_themes_vendors_get_top_vendors( $args = array() ) {
	global $wpdb;

	$defaults = array(
		'vendor_id'  => 'all',
		'product_id' => null,
		'status'     => 'paid',
		'range'      => 'month',
		'start_date' => '',
		'end_date'   => '',
		'limit'      => 10,
	);

	$args = wp_parse_args( $args, $defaults );

	// Bail early if no data.
	if ( ! WC_Product_Vendors_Utils::commission_table_exists() ) {
		return 0;
	}

	$vendors = wp_cache_get( 'top_vendors_' . md5( serialize( $args ) ), 'astoundify_wc_themes_vendors_dashboard_data_overview' );

	if ( ! $vendors ) {
		$sql = "
			SELECT vendor_id, SUM(total_commission_amount) as total FROM " . WC_PRODUCT_VENDORS_COMMISSION_TABLE . "
			WHERE 1=1";

		$sql  = astoundify_wc_themes_vendors_apply_where_clause( $sql, $args );
		$sql .= ' GROUP BY vendor_id ORDER BY total DESC';

		if ( $args['limit'] ) {
			$sql .= $wpdb->prepare( ' LIMIT %d', $args['limit'] );
		}

		$vendors = $wpdb->get_results( $sql );

		wp_cache_set( 'top_vendors_' . md5( serialize( $args ) ), $vendors, 'astoundify_wc_themes_vendors_dashboard_data_overview' );
	}

	return $vendors;
}

/**
 * Get Total Data From Commision Table.
 *
 * Calculate total data entry by vendor ID, range, db column, and commission status.
 * As default it will look for product quantity (total item sold).
 *
 * @since 1.0.0
 *
 * @param array $args Options.
 * @return int Total data entry.
 */
function astoundify_wc_themes_vendors_get_vendor_total_data( $args = array() ) {
	global $wpdb;

	// Set args.
	$defaults = array(
		'column'     => 'product_quantity',
		'vendor_id'  => WC_Product_Vendors_Utils::get_logged_in_vendor(),
		'product_id' => null,
		'status'     => '', // Commission status: "paid", "unpaid". Default to look for "not void".
		'range'      => isset( $_GET['range'] ) ? sanitize_text_field( $_GET['range'] ) : 'month', // Supported Range: "year", "last_month", "month", "7day" or "custom". Set to null to get all data.
		'start_date' => isset( $_GET['start_date'] ) ? sanitize_text_field( $_GET['start_date'] ) : '',
		'end_date'   => isset( $_GET['end_date'] ) ? sanitize_text_field( $_GET['end_date'] ) : '',
		'limit'      => null,
	);

	$args = wp_parse_args( $args, $defaults );

	// Bail early if no data.
	if ( ! WC_Product_Vendors_Utils::commission_table_exists() || ! $args['vendor_id'] ) {
		return 0;
	}

	$total = wp_cache_get( $args['vendor_id'] . '_total_data', 'astoundify_wc_themes_vendors_dashboard_data_overview' );

	if ( ! $total ) {
		// Start Query.
		$sql = " SELECT SUM({$args['column']}) FROM " . WC_PRODUCT_VENDORS_COMMISSION_TABLE . " WHERE 1=1";
		$sql = astoundify_wc_themes_vendors_apply_where_clause( $sql, $args );

		if ( $args['limit'] ) {
			$sql .= $wpdb->prepare( ' LIMIT %d', $args['limit'] );
		}

		$total = $wpdb->get_var( $sql );
		$total = $total ? $total : 0;
		
		wp_cache_set( $args['vendor_id'] . '_total_data', $total, 'astoundify_wc_themes_vendors_dashboard_data_overview' );
	}

	return $total;
}

/**
 * Build some generic queries.
 *
 * @since 1.0.0
 *
 * @param string $sql Current base SQL.
 * @param array  $args Args passed to parent function.
 * @return string
 */
function astoundify_wc_themes_vendors_apply_where_clause( $sql, $args ) {
	global $wpdb;

	$where = array();

	if ( 'all' !== $args['vendor_id'] ) {
		$where[] = $wpdb->prepare( 'AND vendor_id = %d', $args['vendor_id'] );
	}

	// Commission status.
	if ( $args['status'] ) {
		$where[] = $wpdb->prepare( 'AND commission_status = %s', $args['status'] );
	} else {
		$where[] = "AND commission_status != 'void'";
	}

	// Specific product.
	if ( $args['product_id'] ) {
		$where[] = $wpdb->prepare( 'AND product_id = %d', $args['product_id'] );
	}

	// Range.
	switch ( $args['range'] ) {
		case 'year':
			$where[] = 'AND YEAR( order_date ) = YEAR( CURDATE() )';
			break;
		case 'last_month':
			$where[] = 'AND MONTH( order_date ) = MONTH( NOW() ) - 1';
			break;
		case 'month':
			$where[] = 'AND MONTH( order_date ) = MONTH( NOW() )';
			break;
		case 'custom':
			break;
		case '7day':
			$where[] = 'AND DATE( order_date ) BETWEEN DATE_SUB( NOW(), INTERVAL 7 DAY ) AND NOW()';
			break;
		case 'default':
			break;
	}

	if ( ! empty( $where ) ) {
		$sql .= ' ' . implode( ' ', $where );
	}

	return $sql;
}

/**
 * Get vendor total reviews.
 *
 * @since 1.0.0
 *
 * @return int
 */
function astoundify_wc_themes_vendors_get_vendor_total_reviews( $args = array() ) {
	// Set args.
	$defaults = array(
		'vendor_id'  => WC_Product_Vendors_Utils::get_logged_in_vendor(),
		'range'      => isset( $_GET['range'] ) ? sanitize_text_field( $_GET['range'] ) : 'month', // Supported Range: "month" and "custom". Set to null to get all data.
		'start_date' => isset( $_GET['start_date'] ) ? sanitize_text_field( $_GET['start_date'] ) : '', // Only applicable for "custom" range.
		'end_date'   => isset( $_GET['end_date'] ) ? sanitize_text_field( $_GET['end_date'] ) : '', // Only applicable for "custom" range.
	);
	$args = wp_parse_args( $args, $defaults );

	// Get Product IDs.
	$product_ids = WC_Product_Vendors_Utils::get_vendor_product_ids( $args['vendor_id'] );

	// Bail if no products.
	if ( ! $product_ids ) {
		return 0;
	}

	// Default output.
	$total = 0;

	// No range, get all data.
	if ( ! $args['range'] ) {

		// Get Products.
		$products = wc_get_products( array(
			'include' => $product_ids,
			'limit'   => -1,
		) );

		// Calculate total reviews for each product.
		foreach ( $products as $product ) {
			$total += $product->get_rating_count();
		}
	} else {

		// Comments query.
		$comments_query = new WP_Comment_Query;

		// Query Args.
		$comments_query_args = array(
			'fields'     => 'ids',
			'post__in'   => $product_ids,
			'parent'     => 0,
			'status'     => 'approve',
			'date_query' => array(),
		);
		// @todo: support more range.
		if ( 'month' === $args['range'] ) {
			$comments_query_args['date_query']['after'] = 'First day of this month';
			$comments_query_args['date_query']['before'] = 'Last day of this month';
		} elseif ( 'custom' === $args['range'] ) {
			$comments_query_args['date_query'] = array(
				'after' => array(
					'year'   => date( 'Y', strtotime( $args['start_date'] ) ),
					'month'  => date( 'm', strtotime( $args['start_date'] ) ),
					'day'    => date( 'd', strtotime( $args['start_date'] ) ),
				),
				'before' => array(
					'year'   => date( 'Y', strtotime( $args['end_date'] ) ),
					'month'  => date( 'm', strtotime( $args['end_date'] ) ),
					'day'    => date( 'd', strtotime( $args['end_date'] ) ),
				),
			);
		}

		// Load query args.
		$comments = $comments_query->query( $comments_query_args );

		// Calculate total comments.
		$total = count( $comments );
	}// End if().

	return $total;
}

/**
 * Return a count of unfulfilled orders.
 *
 * @since 1.0.0
 *
 * @return int
 */
function astoundify_wc_themes_vendors_get_vendor_unfulfilled_products() {
	if ( ! WC_Product_Vendors_Utils::commission_table_exists() ) {
		return 0;
	}

	$unfulfilled_products = get_transient( 'wcpv_reports_wg_fulfillment_' . WC_Product_Vendors_Utils::get_logged_in_vendor() );

	if ( false === $unfulfilled_products ) {
		global $wpdb;

		$sql = "SELECT COUNT( commission.id ) FROM " . WC_PRODUCT_VENDORS_COMMISSION_TABLE . " AS commission";
		$sql .= " INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS order_item_meta ON commission.order_item_id = order_item_meta.order_item_id";
		$sql .= " WHERE 1=1";
		$sql .= " AND commission.vendor_id = %d";
		$sql .= " AND order_item_meta.meta_key = '_fulfillment_status'";
		$sql .= " AND order_item_meta.meta_value = 'unfulfilled'";

		$unfulfilled_products = $wpdb->get_var( $wpdb->prepare( $sql, WC_Product_Vendors_Utils::get_logged_in_vendor() ) );

		set_transient( 'wcpv_reports_wg_fulfillment_' . WC_Product_Vendors_Utils::get_logged_in_vendor(), $unfulfilled_products, DAY_IN_SECONDS );
	}

	return (int) $unfulfilled_products;
}
