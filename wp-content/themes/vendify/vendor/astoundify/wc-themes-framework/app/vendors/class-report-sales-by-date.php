<?php
/**
 * Vendor Reports Sales By Date
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Events
 * @author Astoundify
 */

namespace Astoundify\WC_Themes\Vendors;
use WC_Product_Vendors_Vendor_Report_Sales_By_Date, WC_Product_Vendors_Utils;

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sales Report by Date
 *
 * @since 1.0.0
 */
class Report_Sales_By_Date extends WC_Product_Vendors_Vendor_Report_Sales_By_Date {

	/**
	 * Report Data
	 *
	 * @since 1.0.0
	 */
	private $astoundify_wc_themes_vendors_report_data = array();

	/**
	 * Constructor
	 *
	 * @access public
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @return bool
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Set Report Data
	 *
	 * This is needed becase WC Product Vendors retrieve all data on the chart output callback
	 * which also print the chart js.
	 * Even though we only need `$total_commission`, all data is loaded for future use.
	 *
	 * @since 1.0.0
	 *
	 * @see WC_Product_Vendors_Vendor_Report_Sales_By_Date::get_main_chart() Chart output.
	 */
	private function astoundify_wc_themes_vendors_set_report_data() {
		global $wp_locale, $wpdb;

		// Check if table exists before continuing
		if ( ! WC_Product_Vendors_Utils::commission_table_exists() ) {
			return $this->report_data;
		}

		// Calculate current range.
		$this->calculate_current_range( $this->current_range );

		// Start Query.
		$select = 'SELECT COUNT( DISTINCT commission.order_id ) AS count, COUNT( commission.order_id ) AS order_item_count, SUM( commission.product_amount + commission.product_shipping_amount + commission.product_tax_amount + commission.product_shipping_tax_amount ) AS total_sales, SUM( commission.product_shipping_amount ) AS total_shipping, SUM( commission.product_tax_amount ) AS total_tax, SUM( commission.product_shipping_tax_amount ) AS total_shipping_tax, SUM( commission.total_commission_amount ) AS total_earned, SUM( commission.total_commission_amount ) AS total_commission, commission.order_date';

		$sql = $select;
		$sql .= ' FROM ' . WC_PRODUCT_VENDORS_COMMISSION_TABLE . ' AS commission';
		$sql .= ' WHERE 1=1';
		$sql .= ' AND commission.vendor_id = %d';
		$sql .= " AND commission.commission_status != 'void'";

		// In WC Product Vendors the default is "7day", for this plugin, the default is "month".
		switch ( $this->current_range ) {
			case 'year' :
				$sql .= ' AND YEAR( commission.order_date ) = YEAR( CURDATE() )';
				break;

			case 'last_month' :
				$sql .= ' AND MONTH( commission.order_date ) = MONTH( NOW() ) - 1';
				break;

			case '7day' :
				$sql .= ' AND DATE( commission.order_date ) BETWEEN DATE_SUB( NOW(), INTERVAL 7 DAY ) AND NOW()';
				break;

			case 'custom' :
				$start_date = ! empty( $_GET['start_date'] ) ? sanitize_text_field( $_GET['start_date'] ) : '';
				$end_date = ! empty( $_GET['end_date'] ) ? sanitize_text_field( $_GET['end_date'] ) : '';

				$sql .= " AND DATE( commission.order_date ) BETWEEN '" . $start_date . "' AND '" . $end_date . "'";
				break;

			case 'default' :
			case 'month' : // Default is set to "month".
				$sql .= ' AND MONTH( commission.order_date ) = MONTH( NOW() )';
				break;
		}

		$sql .= ' GROUP BY DATE( commission.order_date )';

		// Enable big selects for reports.
		$wpdb->query( 'SET SESSION SQL_BIG_SELECTS=1' );

		// All results.
		$results = $wpdb->get_results( $wpdb->prepare( $sql, WC_Product_Vendors_Utils::get_logged_in_vendor() ) );

		// Prepare data for report.
		$order_counts         = $this->prepare_chart_data( $results, 'order_date', 'count', $this->chart_interval, $this->start_date, $this->chart_groupby );

		$order_item_counts    = $this->prepare_chart_data( $results, 'order_date', 'order_item_count', $this->chart_interval, $this->start_date, $this->chart_groupby );

		$order_amounts        = $this->prepare_chart_data( $results, 'order_date', 'total_sales', $this->chart_interval, $this->start_date, $this->chart_groupby );

		$shipping_amounts     = $this->prepare_chart_data( $results, 'order_date', 'total_shipping', $this->chart_interval, $this->start_date, $this->chart_groupby );

		$shipping_tax_amounts = $this->prepare_chart_data( $results, 'order_date', 'total_shipping_tax', $this->chart_interval, $this->start_date, $this->chart_groupby );

		$tax_amounts          = $this->prepare_chart_data( $results, 'order_date', 'total_tax', $this->chart_interval, $this->start_date, $this->chart_groupby );

		$total_earned         = $this->prepare_chart_data( $results, 'order_date', 'total_earned', $this->chart_interval, $this->start_date, $this->chart_groupby );

		$total_commission     = $this->prepare_chart_data( $results, 'order_date', 'total_commission', $this->chart_interval, $this->start_date, $this->chart_groupby );

		$net_order_amounts = array();

		foreach ( $order_amounts as $order_amount_key => $order_amount_value ) {
			$net_order_amounts[ $order_amount_key ]    = $order_amount_value;
			$net_order_amounts[ $order_amount_key ][1] = $net_order_amounts[ $order_amount_key ][1] - $shipping_amounts[ $order_amount_key ][1] - $shipping_tax_amounts[ $order_amount_key ][1] - $tax_amounts[ $order_amount_key ][1];
		}

		// Add it in report data.
		$this->astoundify_wc_themes_vendors_report_data = array(
			'order_counts'          => $order_counts,
			'order_item_counts'     => $order_item_counts,
			'order_amounts'         => $order_amounts,
			'shipping_amounts'      => $shipping_amounts,
			'shipping_tax_amounts'  => $shipping_tax_amounts,
			'tax_amounts'           => $tax_amounts,
			'total_earned'          => $total_earned,
			'total_commission'      => $total_commission,
		);
	}

	/**
	 * Get Report Data
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function astoundify_wc_themes_vendors_get_report_data() {
		if ( ! $this->astoundify_wc_themes_vendors_report_data ) {
			$this->astoundify_wc_themes_vendors_set_report_data();
		}

		return $this->astoundify_wc_themes_vendors_report_data;
	}

	/**
	 * Get and Format Commission Data for ChartJS
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function astoundify_wc_themes_vendors_get_commission_chart_data() {
		// Get commission data.
		$commission_data = $this->astoundify_wc_themes_vendors_get_report_data()['total_commission'];

		// Data needed.
		$labels = array();
		$datas = array();
		$tooltips_titles = array();
		$tooltips_contents = array();

		// Loop and format.
		foreach ( $commission_data as $item ) {
			$timestamp = $item[0] / 1000; // Milliseconds to second.
			$amount = wc_format_decimal( $item[1], wc_get_price_decimals() );

			// Add amount as data.
			$datas[] = $amount;

			// ChartJS tooltip do not support HTML Entities, needed to correctly display currency code.
			$tooltips_contents[] = mb_convert_encoding( strip_tags( wc_price( $amount ) ), 'UTF-8', 'HTML-ENTITIES' );

			// If grouped by day, show date.
			if ( $this->chart_groupby === 'day' ) {
				$labels[] = date( 'd', $timestamp );
				$tooltips_titles[] = date( get_option( 'date_format' ), $timestamp );
			} else { // Display month in chart label, add year context in tooltips title.
				$labels[] = date( 'M', $timestamp );
				$tooltips_titles[] = date( 'M Y', $timestamp );
			}
		}

		// Format for ChartJS data.
		$chart_data = apply_filters( 'astoundify_wc_themes_report_by_date_chart', array(
			'labels'          => $labels,
			'tooltips_titles' => $tooltips_titles,
			'datasets' => array(
				array(
					'data'              => $datas,
					'tooltips_contents' => $tooltips_contents,
					'backgroundColor'   => array( 'rgba(0, 0, 0, 0.1)' ),
					'borderColor'       => array( 'rgba(0, 0, 0, 0.3)' ),
					'borderWidth'       => 3,
				),
			),
		) );

		return $chart_data;
	}
}
