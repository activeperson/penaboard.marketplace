<?php
/**
 * Order Query.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Events
 * @author Astoundify
 */

namespace Astoundify\WC_Themes\Vendors;

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Order Query.
 *
 * @since 1.0.0
 */
class Order_Query {

	/**
	 * Query Args.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected $query_args = array();

	/**
	 * Orders.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected $orders = array();

	/**
	 * Offset.
	 *
	 * @var int
	 * @since 1.0.0
	 */
	protected $offset = 0;

	/**
	 * Total Items.
	 *
	 * @var int
	 * @since 1.0.0
	 */
	protected $total = 0;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Modify default arguments.
	 */
	public function __construct( $args = array() ) {
		$defaults = array(
			'limit'          => 10, // Item per page.
			'page'           => 1,  // Current page.
			'vendor_id'      => \WC_Product_Vendors_Utils::get_logged_in_vendor(),
			'order_id'       => false,
		);

		// Set args.
		$this->query_args = wp_parse_args( $args, $defaults );
	}

	/**
	 * Query
	 *
	 * @since 1.0.0
	 */
	public function query() {
		global $wpdb;

		// Bail if orders already set, table not found, or no vendor set.
		if ( $this->orders || ! \WC_Product_Vendors_Utils::commission_table_exists() || ! $this->query_args['vendor_id'] ) {
			return;
		}

		// @codingStandardsIgnoreStart

		/* === SET TOTAL === */

		$sql  = 'SELECT COUNT(commission.id) FROM ' . WC_PRODUCT_VENDORS_COMMISSION_TABLE . ' AS commission';
		$sql .= ' WHERE 1=1';
		$sql .= ' AND `vendor_id` = %d';
		if ( $this->query_args['order_id'] ) {
			$sql .= " AND `order_id` = {$this->query_args['order_id']}";
		}

		$query = $wpdb->prepare( $sql, $this->query_args['vendor_id'] );
		$total_items = $wpdb->get_var( $query );
		$this->total = absint( (double) $total_items );

		/* === QUERY === */

		$sql = 'SELECT * FROM ' . WC_PRODUCT_VENDORS_COMMISSION_TABLE . ' AS commission';
		$sql .= ' WHERE 1=1';
		$sql .= ' AND `vendor_id` = %d';
		if ( $this->query_args['order_id'] ) {
			$sql .= " AND `order_id` = {$this->query_args['order_id']}";
		}
		$sql .= ' ORDER BY `order_id` DESC';

		if ( $this->query_args['limit'] > 0 ) {
			$sql .= " LIMIT {$this->query_args['limit']}";
		}

		$this->offset = ( absint( $this->query_args['page'] ) - 1 ) * absint( $this->query_args['limit'] );

		if ( $this->offset ) {
			$sql .= " OFFSET {$this->offset}";
		}

		$query = $wpdb->prepare( $sql, $this->query_args['vendor_id'] );
		$orders = $wpdb->get_results( $query );
		$this->orders = is_array( $orders ) ? $orders : array();

		// @codingStandardsIgnoreEnd
	}

	/**
	 * Get Orders
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_orders() {
		$this->query();
		return is_array( $this->orders ) ? $this->orders : 0;
	}

	/**
	 * Get Total Items
	 *
	 * @since 1.0.0
	 *
	 * @return int
	 */
	public function get_total_items() {
		$this->query();
		return absint( $this->total );
	}

	/**
	 * Get Total Pages.
	 *
	 * @since 1.0.0
	 *
	 * @return int
	 */
	public function get_total_pages() {
		$this->query();
		if ( $this->query_args['limit'] < 0 ) {
			return 1;
		}
		$total_pages = absint( ceil( $this->total / $this->query_args['limit'] ) );
		return empty( $total_pages ) ? 1 : absint( $total_pages );
	}

	/**
	 * Get Pages.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_pages() {
		return range( 1, $this->get_total_pages() );
	}

	/**
	 * Get Current Page.
	 *
	 * @since 1.0.0
	 *
	 * @return int
	 */
	public function get_current_page() {
		return $this->query_args['page'];
	}
}
