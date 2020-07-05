<?php
/**
 * Vendor Dashboard Overview REST Controller.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category API
 * @author Astoundify
 */

namespace Astoundify\WC_Themes\API\Vendors;
use Astoundify\WC_Themes\API\REST_Controller;
use WC_REST_Controller, WP_REST_Server, WC_Product_Vendors_Utils, WP_Error;

/**
 * Vendor Dashboard Overview Controller.
 *
 * REST API Endpoint: "/wp-json/astoundify/wc-themes/v1/vendor/dashboard-overview".
 *
 * @since 1.0.0
 *
 * @extends Astoundify\WC_Themes\API\REST_Controller
 */
class Dashboard_Overview_REST_Controller extends REST_Controller {

	/**
	 * Route base.
	 *
	 * @var string
	 */
	protected $rest_base = 'vendor/dashboard-overview';

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
		$data = array(
			'weekly_average'   => 0,
			'total_items_sold' => 0,
			'average_ratings'  => 0,
			'total_reviews'    => 0,
		);

		$vendor_id = WC_Product_Vendors_Utils::get_logged_in_vendor();

		if ( $vendor_id ) {

			// Use cache data if available.
			$data = wp_cache_get( $vendor_id, 'astoundify_wc_themes_vendors_dashboard_data_overview' );

			if ( false === $data || ! is_array( $data ) || ! $data ) {
				$data = array(
					'weekly_average'   => wc_price( astoundify_wc_themes_vendors_get_vendor_weekly_average_commission( $vendor_id ) ),
					'total_items_sold' => astoundify_wc_themes_vendors_get_vendor_total_data( array(
						'vendor_id' => $vendor_id,
						'column'    => 'product_quantity',
						'range'     => null,
					) ),
					'average_ratings'  => WC_Product_Vendors_Utils::get_vendor_rating( $vendor_id ),
					'total_reviews'    => astoundify_wc_themes_vendors_get_vendor_total_reviews( array(
						'vendor_id' => $vendor_id,
						'range'     => null,
					) ),
				);
				wp_cache_set( $vendor_id, $data, 'astoundify_wc_themes_vendors_dashboard_data_overview', HOUR_IN_SECONDS );
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
			'title'      => 'vendor_overview_report',
			'type'       => 'object',
			'properties' => array(
				'weekly_average' => array(
					'description' => esc_html__( 'Average weekly earnings for the vendor.', 'astoundify-wc-themes' ),
					'type'        => 'string',
					'context'     => array( 'view' ),
					'readonly'    => true,
				),
				'total_items_sold' => array(
					'description' => esc_html__( 'Total number of items sold by the vendor.', 'astoundify-wc-themes' ),
					'type'        => 'integer',
					'context'     => array( 'view' ),
					'readonly'    => true,
				),
				'average_rating' => array(
					'description' => esc_html__( 'Average rating value for the vendor.', 'astoundify-wc-themes' ),
					'type'        => 'integer',
					'context'     => array( 'view' ),
					'readonly'    => true,
				),
				'total_reviews' => array(
					'description' => esc_html__( 'Total reviews for the vendor.', 'astoundify-wc-themes' ),
					'type'        => 'integer',
					'context'     => array( 'view' ),
					'readonly'    => true,
				),
			),
		);

		return $this->add_additional_fields_schema( $schema );
	}
}
