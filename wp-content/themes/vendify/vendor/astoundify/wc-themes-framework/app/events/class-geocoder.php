<?php
/**
 * Geocode an address with Google.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Integration
 * @author Astoundify
 */

namespace Astoundify\WC_Themes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Geocode address or coordinate with Google.
 *
 * @since 1.0.0
 */
class Geocoder {

	/**
	 * Google Geocoder API Key
	 *
	 * @since 1.0.0
	 *
	 * @var false|string $api_key Google Geocoder API Key.
	 */
	protected $api_key = 'AIzaSyBEXVgw-F0idIeqdzqOxKxHuBEolYzMtOw';

	/**
	 * Google Geocoder API URL
	 *
	 * @since 1.0.0
	 *
	 * @var string $base_url Google Geocoder API URL.
	 */
	protected $base_url = 'https://maps.googleapis.com/maps/api/geocode/json';

	/**
	 * Errors Data
	 *
	 * @since 1.0.0
	 *
	 * @var array $errors Errors Data.
	 */
	protected $errors = array();

	/**
	 * Input
	 *
	 * @since 1.0.0
	 *
	 * @var false|string $input Data Input.
	 */
	protected $input = false;

	/**
	 * Input type
	 *
	 * @since 1.0.0
	 *
	 * @var false|string $input_type Input type.
	 */
	protected $input_type = false;

	/**
	 * Language
	 *
	 * @since 1.0.0
	 *
	 * @var false|string $language API Language.
	 */
	protected $language = false;

	/**
	 * Region
	 *
	 * @since 1.0.0
	 *
	 * @var false|string $region API Region.
	 */
	protected $region = false;

	/**
	 * Formatted Location Data.
	 *
	 * @since 1.0.0
	 *
	 * @var array $location_data Raw Data.
	 */
	protected $location_data = array(
		'place_id' => '',
		'address_1' => '',
		'address_2' => '',
		'city' => '',
		'state' => '',
		'postcode' => '',
		'country' => '',
		'latitude' => '',
		'longitude' => '',
		'formatted' => '',
		'input' => '',
		'raw' => array(),
	);

	/**
	 * Raw Address Data from Google Geocoder.
	 *
	 * @since 1.0.0
	 *
	 * @var array $raw_data Raw Data.
	 */
	protected $raw_data = array();

	/**
	 * Class Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $input String for address, or array for coordinate ('lat' & 'lng' as key).
	 * @param string       $api_key Google Geocoder API Key.
	 */
	public function __construct( $input = '', $api_key = '' ) {
		$this->set_input( $input );
		$this->set_api_key( $api_key );
	}

	/**
	 * Set Error
	 *
	 * @since 1.0.0
	 *
	 * @param string $error_message Error message.
	 */
	public function set_error( $error_message ) {
		$this->errors[] = wp_kses_post( $error_message );
	}

	/**
	 * Get Errors.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_errors() {
		return ! empty( $this->errors ) ? $this->errors : false;
	}

	/**
	 * Set base URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $base_url Set a different geoocder base URL.
	 */
	public function set_base_url( $base_url = false ) {
		$this->base_url = $base_url;
	}

	/**
	 * Get base URL.
	 *
	 * @since 1.0.0
	 *
	 * @return false|string
	 */
	public function get_base_url() {
		return $this->base_url;
	}

	/**
	 * Set API Key
	 *
	 * @since 1.0.0
	 *
	 * @param string $api_key Set a Google Maps API key.
	 */
	public function set_api_key( $api_key = false ) {
		$this->api_key = strip_tags( $api_key );
	}

	/**
	 * Get API Key
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_api_key() {
		return strip_tags( apply_filters( 'astoundify_wc_themes_geocoder_api_key', $this->api_key, $this ) );
	}

	/**
	 * Set Input
	 *
	 * @since 1.0.0
	 *
	 * @param false|string $input Data Input.
	 */
	public function set_input( $input = false ) {
		$this->input = $input;
		$this->set_input_type( $this->input );
	}

	/**
	 * Get Input
	 *
	 * @since 1.0.0
	 */
	public function get_input() {
		return $this->input;
	}

	/**
	 * Set Input Type
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $input Data Input.
	 */
	public function set_input_type( $input ) {
		$this->input_type = is_array( $input ) && isset( $input[0], $input[1] ) ? 'coordinate' : 'address';
	}

	/**
	 * Get Input Type
	 *
	 * @since 1.0.0
	 */
	public function get_input_type() {
		return 'address' === $this->input_type ? 'address' : 'coordinate';
	}

	/**
	 * Set Language
	 *
	 * @since 1.0.0
	 *
	 * @param string $language Set a specific language locale or use the website's.
	 */
	public function set_language( $language = false ) {
		$this->language = $language ? $language : substr( get_locale(), 0, 2 );
	}

	/**
	 * Get Language
	 *
	 * @since 1.0.0
	 */
	public function get_language() {
		return apply_filters( 'astoundify_wc_themes_geocoder_language', $this->language, $this );
	}

	/**
	 * Set Region
	 *
	 * @since 1.0.0
	 *
	 * @param false|string $region Current region.
	 */
	public function set_region( $region = false ) {
		$this->region = $region;
	}

	/**
	 * Get Region
	 *
	 * @since 1.0.0
	 */
	public function get_region() {
		return apply_filters( 'astoundify_wc_themes_geocoder_region', $this->region, $this );
	}

	/**
	 * Generate a request URL.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_request_url() {
		$args = array();

		// Key.
		if ( $this->get_api_key() ) {
			$args['key'] = rawurlencode( $this->get_api_key() );
		}

		// Input.
		if ( 'address' === $this->get_input_type() ) {
			$args['address'] = rawurlencode( $this->get_input() );
		} else {
			$args['latlng'] = rawurlencode( "{$this->get_input()[0]},{$this->get_input()[1]}" );
		}

		// Language.
		if ( $this->get_language() ) {
			$args['language'] = rawurlencode( $this->get_language() );
		}

		// Region.
		if ( $this->get_region() ) {
			$args['region'] = rawurlencode( $this->get_region() );
		}

		$args = apply_filters( 'astoundify_wc_themes_geocoder_args', $args, $this );
		$url = add_query_arg( $args, $this->get_base_url() );

		return esc_url_raw( apply_filters( 'astoundify_wc_themes_geocoder_request_url', $url, $this ) );
	}

	/**
	 * Get Data via Google Geocode.
	 *
	 * @return false|array First Location Data from Google Geocode.
	 */
	public function geocode() {
		// Request data.
		$result = wp_remote_get(
			esc_url_raw( $this->get_request_url() ),
			array(
				'timeout'     => 5,
				'redirection' => 1,
				'httpversion' => '1.1',
				'user-agent'  => 'WordPress/Astoundify_WC_Themes; ' . home_url( '/' ),
				'sslverify'   => false,
			)
		);

		$result = wp_remote_retrieve_body( $result );
		$result = json_decode( $result, true ); // Set as array.

		// Results data need to available.
		if ( ! $result || ! is_array( $result ) || ! isset( $result['results'] ) || ! isset( $result['status'] ) ) {
			$this->set_error( esc_html__( 'Invalid request.', 'astoundify-wc-themes' ) );
			return array();
		}

		// Check results status.
		$valid_statuses = array(
			'OK',
			'ZERO_RESULTS',
			'OVER_QUERY_LIMIT',
			'REQUEST_DENIED',
			'INVALID_REQUEST',
			'UNKNOWN_ERROR',
		);

		// Known status.
		if ( in_array( $result['status'], $valid_statuses, true ) ) {
			if ( 'OK' !== $result['status'] && isset( $result['error_message'] ) && $result['error_message'] ) {
				$this->set_error( $result['error_message'] ); // Display error from Google.
				return array();
			}
		} else { // Invalid Status.
			$this->set_error( esc_html__( 'Invalid request.', 'astoundify-wc-themes' ) );
			return array();
		}

		// Results data need to available.
		if ( ! isset( $result['results'][0] ) ) {
			$this->set_error( esc_html__( 'Invalid geocoding results.', 'astoundify-wc-themes' ) );
			return array();
		}

		// No errors, transform data.
		$this->set_location_data( $result['results'][0] );
	}

	/**
	 * Set Location Data
	 *
	 * @since 1.0.0
	 *
	 * @param array $raw_data Data sent back from Google.
	 */
	public function set_location_data( $raw_data ) {
		// Defaults.
		$this->location_data = array(
			'latitude'          => 'coordinate' === $this->get_input_type() ? $this->get_input()[0] : false,
			'longitude'         => 'coordinate' === $this->get_input_type() ? $this->get_input()[1] : false,
			'input'             => $this->get_input(),
			'raw'               => $raw_data,
		);

		// Bail early if not set.
		if ( ! isset( $raw_data['address_components'] ) || ! is_array( $raw_data['address_components'] ) ) {
			return $type ? '' :  array();
		}

		// Get address components.
		$address_data = $raw_data['address_components'];

		// Get formatted address.
		if ( isset( $raw_data['formatted_address'] ) ) {
			$this->location_data['formatted'] = sanitize_text_field( $raw_data['formatted_address'] );
		}

		// If using coordinate to get location, it should store the input coordinate.
		if ( ! $this->location_data['latitude'] && isset( $raw_data['geometry']['location']['lat'] ) ) {
			$this->location_data['latitude'] = $raw_data['geometry']['location']['lat'];
		}
		if ( ! $this->location_data['longitude'] && isset( $raw_data['geometry']['location']['lng'] ) ) {
			$this->location_data['longitude'] = $raw_data['geometry']['location']['lng'];
		}

		// Place ID.
		if ( isset( $raw_data['place_id'] ) ) {
			$this->location_data['place_id'] = $raw_data['place_id'];
		}

		// Get each data.
		foreach ( $address_data as $data ) {
			switch ( $data['types'][0] ) {
				case 'street_number' :
					$this->location_data['street_number'] = sanitize_text_field( $data['long_name'] );
				break;
				case 'route' :
					$this->location_data['address_1'] = sanitize_text_field( $data['long_name'] );
				break;
				case 'subpremise' :
					$this->location_data['address_2'] = sanitize_text_field( $data['long_name'] );
				break;
				case 'locality' :
				case 'postal_town' :
				case 'sublocality_level_1' :
					$this->location_data['city'] = sanitize_text_field( $data['long_name'] );
				break;
				case 'administrative_area_level_1' :
					$this->location_data['state'] = sanitize_text_field( $data['long_name'] );
				break;
				case 'postal_code' :
					$this->location_data['postcode'] = sanitize_text_field( $data['long_name'] );
				break;
				case 'country' :
					$this->location_data['country'] = sanitize_text_field( $data['long_name'] );
				break;
			}
		}
	}

	/**
	 * Get Location Data
	 *
	 * @param string|false $type Location data type, e.g street, country, etc. False to return all in array.
	 * @return string|array
	 */
	public function get_location_data( $type = false ) {
		// Get data.
		$location_data = apply_filters( 'astoundify_wc_themes_geocoding_location_data', $this->location_data, $this );

		// Return specific data.
		if ( $type ) {
			if ( isset( $this->location_data[ $type ] ) ) {
				return $this->location_data[ $type ];
			} else {
				return '';
			}
		}

		return $this->location_data;
	}

}
