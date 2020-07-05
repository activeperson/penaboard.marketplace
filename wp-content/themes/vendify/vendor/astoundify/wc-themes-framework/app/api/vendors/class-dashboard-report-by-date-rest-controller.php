<?php
/**
 * Vendor Dashboard Report by Date REST Controller.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Products
 * @author Astoundify
 */

namespace Astoundify\WC_Themes\API\Vendors;

use Astoundify\WC_Themes\API\REST_Controller;
use WC_REST_Controller;
use WP_REST_Server, WC_Product_Vendors_Utils, WP_Error;

/**
 * Vendor Dashboard Reports by Date REST Controller.
 *
 * Data in this endpoint:
 * - total_commission : Total commission.
 * - total_items : Total item sold.
 * - total_orders : Total orders sold.
 * - total_reviews : Total reviews.
 * - chart_commission: ChartJS Data to display commission by date range.
 *
 * REST API Endpoint: "/wp-json/astoundify/wc-themes/v1/vendor/dashboard-commission-by-date".
 *
 * @since 1.0.0
 *
 * @extends Astoundify\WC_Themes\API\REST_Controller
 */
class Dashboard_Report_By_Date_REST_Controller extends REST_Controller {

	/**
	 * Route base.
	 *
	 * @var string
	 */
	protected $rest_base = 'vendor/dashboard-report-by-date';

	/**
	 * Registers the routes for the objects of the controller.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_routes() {
		register_rest_route( $this->namespace, '/' . $this->rest_base, array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_items' ),
				'permission_callback' => array( $this, 'get_items_permissions_check' ),
				'args'                => $this->get_collection_params(),
			),
			'schema' => array( $this, 'get_public_item_schema' ),
		) );
	}

	/**
	 * Check whether a given request has permission to read report.
	 *
	 * @since 1.0.0
	 *
	 * @param  WP_REST_Request $request Full details about the request.
	 * @return WP_Error|true
	 */
	public function get_items_permissions_check( $request ) {
		if ( ! WC_Product_Vendors_Utils::is_vendor() ) {
			return new WP_Error( 'astoundify_wc_themes_rest_cannot_view', esc_html__( 'Sorry, you cannot view this data.', 'astoundify-wc-themes' ), array(
				'status' => rest_authorization_required_code(),
			) );
		}

		return true;
	}

	/**
	 * Get overview data.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_REST_Request $request API request.
	 * @return array|WP_Error|WP_REST_Response
	 */
	public function get_items( $request ) {
		// Set request range to month as default.
		// @codingStandardsIgnoreStart
		if ( ! isset( $_GET['range'] ) || ! $_GET['range'] ) {
			$_GET['range'] = 'month';
			$request['range'] = 'month';
		}
		// @codingStandardsIgnoreEnd

		// Default.
		$data = array(
			'chart_commission' => array(),
			'total_commission' => 0,
			'total_items'      => 0,
			'total_orders'     => 0,
			'total_reviews'    => 0,
		);

		$vendor_id = WC_Product_Vendors_Utils::get_logged_in_vendor();

		if ( $vendor_id ) {

			// Use cached data if available.
			$cache_key = $vendor_id . '_' . md5( serialize( $request ) );
			$data = wp_cache_get( $cache_key, 'astoundify_wc_themes_vendors_dashboard_data_report_by_date' );

			if ( false === $data || ! is_array( $data ) || ! $data ) {

				// Get sales report by date.
				$report = astoundify_wc_themes_vendors_get_report_sales_by_date();

				// Report data.
				$report_data = $report->get_report_data();

				$data = array(
					'chart_commission' => $report->astoundify_wc_themes_vendors_get_commission_chart_data(),
					'total_commission' => wc_price( $report_data->total_commission ),
					'total_items'      => $report_data->total_items,
					'total_orders'     => $report_data->total_orders,
					'total_reviews'    => astoundify_wc_themes_vendors_get_vendor_total_reviews(),
				);
				wp_cache_set( $cache_key, $data, 'astoundify_wc_themes_vendors_dashboard_data_report_by_date', HOUR_IN_SECONDS );
			}
		}

		if ( isset( $request['context'] ) && 'json' === $request['context'] ) {
			wp_send_json_success( $data );
		}

		return rest_ensure_response( $data );
	}

	/**
	 * Get the Report's schema, conforming to JSON Schema.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_item_schema() {
		$schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'vendor_overview_report_by_date',
			'type'       => 'object',
			'properties' => array(
				'chart_comission' => array(
					'description' => esc_html__( 'Data to build a chart based on comission data.', 'astoundify-wc-themes' ),
					'type'        => 'object',
					'context'     => array( 'view' ),
					'readonly'    => true,
				),
				'total_comission' => array(
					'description' => __( 'Total commission earnings for time period.', 'astoundify-wc-themes' ),
					'type'        => 'integer',
					'context'     => array( 'view' ),
					'readonly'    => true,
				),
				'total_items' => array(
					'description' => __( 'Total items sold for time period.', 'astoundify-wc-themes' ),
					'type'        => 'integer',
					'context'     => array( 'view' ),
					'readonly'    => true,
				),
				'total_orders' => array(
					'description' => __( 'Total orders for the time period.', 'astoundify-wc-themes' ),
					'type'        => 'integer',
					'context'     => array( 'view' ),
					'readonly'    => true,
				),
				'total_reviews' => array(
					'description' => __( 'Total reviews for the time period.', 'astoundify-wc-themes' ),
					'type'        => 'integer',
					'context'     => array( 'view' ),
					'readonly'    => true,
				),
			),
		);

		return $this->add_additional_fields_schema( $schema );
	}
}
