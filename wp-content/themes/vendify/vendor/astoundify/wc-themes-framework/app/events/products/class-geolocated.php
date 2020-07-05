<?php
/**
 * A product that has location data attached to it.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Product
 * @author Astoundify
 */

namespace Astoundify\WC_Themes\Products;

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Event product.
 *
 * @since 1.0.0
 */
class Geolocated extends \WC_Product_Simple {

	/**
	 * Extra event dta.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $address_data = array(
		'location_address_1' => '',
		'location_address_2' => '',
		'location_city' => '',
		'location_state' => '',
		'location_postcode' => '',
		'location_country' => '',
		'location_latitude' => '',
		'location_longitude' => '',
		'location_formatted' => '',
		'location_input' => '',
		'location_raw' => array(),
	);

	/**
	 * Get location data.
	 *
	 * @since 1.0.0
	 */
	public function get_address_data() {
		return $this->address_data;
	}

	/**
	 * Get location data keys.
	 *
	 * @since 1.0.0
	 */
	public function get_address_data_keys() {
		return array_keys( $this->address_data );
	}

	/**
	 * Getters
	 */

	/**
	 * Address 1
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string
	 */
	public function get_location_address_1( $context = 'view' ) {
		return $this->get_prop( 'location_address_1', $context );
	}

	/**
	 * Address 2
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string
	 */
	public function get_location_address_2( $context = 'view' ) {
		return $this->get_prop( 'location_address_2', $context );
	}

	/**
	 * City
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string
	 */
	public function get_location_city( $context = 'view' ) {
		return $this->get_prop( 'location_city', $context );
	}

	/**
	 * State
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string
	 */
	public function get_location_state( $context = 'view' ) {
		return $this->get_prop( 'location_state', $context );
	}

	/**
	 * Postcode
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string
	 */
	public function get_location_postcode( $context = 'view' ) {
		return $this->get_prop( 'location_postcode', $context );
	}

	/**
	 * Country
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string
	 */
	public function get_location_country( $context = 'view' ) {
		return $this->get_prop( 'location_country', $context );
	}

	/**
	 * Latitude
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string
	 */
	public function get_location_latitude( $context = 'view' ) {
		return $this->get_prop( 'location_latitude', $context );
	}

	/**
	 * Longitude
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string
	 */
	public function get_location_longitude( $context = 'view' ) {
		return $this->get_prop( 'location_longitude', $context );
	}

	/**
	 * Formatted
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string
	 */
	public function get_location_formatted( $context = 'view' ) {
		return $this->get_prop( 'location_formatted', $context );
	}

	/**
	 * Original input.
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string
	 */
	public function get_location_input( $context = 'view' ) {
		return $this->get_prop( 'location_input', $context );
	}

	/**
	 * Raw
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return array
	 */
	public function get_location_raw( $context = 'view' ) {
		return $this->get_prop( 'location_raw', $context );
	}

	/**
	 * Location JSON-LD Data
	 *
	 * @since 1.0.0
	 * @see http://json-ld.org/
	 * @see https://github.com/woocommerce/woocommerce/blob/master/includes/class-wc-structured-data.php
	 *
	 * @return array
	 */
	public function get_location_json_ld_data() {
		// Start Markup.
		$data = array(
			'@context'    => 'http://schema.org',
			'@type'       => 'Place',
			'@id'         => esc_url( $this->get_permalink() ),
			'name'        => esc_attr( $this->get_name() ),
			'description' => wp_kses_post( $this->get_short_description() ),
			'url'         => array(
				'@type'   => 'URL',
				'@id'     => esc_url( $this->get_permalink() ),
			),
		);

		// Coordinates.
		$lat = $this->get_location_latitude();
		$lng = $this->get_location_longitude();

		// Map URL.
		if ( $lat && $lng ) {
			$data['hasMap'] = add_query_arg( array(
				'daddr' => urlencode( "{$lat},{$lng}" ),
			), 'http://maps.google.com/maps' );
			$data['geo'] = array(
				'@type'      => 'GeoCoordinates',
				'latitude'   => $lat,
				'longitude'  => $lng,
			);
		}

		// Location.
		if ( $address_1 = $this->get_location_address_1() ) {
			$data['address'] = array(
				'@type' => 'PostalAddress',
			);
			if ( $city = $this->get_location_city() ) {
				$data['address']['addressLocality'] = $city;
			}
			if ( $state = $this->get_location_state() ) {
				$data['address']['addressRegion'] = $state;
			}
			if ( $postcode = $this->get_location_postcode() ) {
				$data['address']['postalCode'] = $postcode;
			}
			if ( $country = $this->get_location_country() ) {
				$data['address']['addressCountry'] = $country;
			}
			$address_2 = $this->get_location_address_2();
			$data['address']['streetAddress'] = $address_1 . ( $address_2 ? ( ' ' . $address_2 ) : '' );
		}

		return apply_filters( 'astoundify_wc_themes_events_product_json_ld_data', $data, $this );
	}

	/**
	 * Setters
	 */

	/**
	 * Address 1
	 *
	 * @since 1.0.0
	 *
	 * @param string $value Street.
	 */
	public function set_location_address_1( $value ) {
		$this->set_prop( 'location_address_1', $value );
	}

	/**
	 * Address 2
	 *
	 * @since 1.0.0
	 *
	 * @param string $value Street number.
	 */
	public function set_location_address_2( $value ) {
		$this->set_prop( 'location_address_2', $value );
	}

	/**
	 * City
	 *
	 * @since 1.0.0
	 *
	 * @param string $value City.
	 */
	public function set_location_city( $value ) {
		$this->set_prop( 'location_city', $value );
	}

	/**
	 * State
	 *
	 * @since 1.0.0
	 *
	 * @param string $value State.
	 */
	public function set_location_state( $value ) {
		$this->set_prop( 'location_state', $value );
	}

	/**
	 * Postcode
	 *
	 * @since 1.0.0
	 *
	 * @param string $value Postcode.
	 */
	public function set_location_postcode( $value ) {
		$this->set_prop( 'location_postcode', $value );
	}

	/**
	 * Country
	 *
	 * @since 1.0.0
	 *
	 * @param string $value Country.
	 */
	public function set_location_country( $value ) {
		$this->set_prop( 'location_country', $value );
	}

	/**
	 * Latitude
	 *
	 * @since 1.0.0
	 *
	 * @param string $value Latitude.
	 */
	public function set_location_latitude( $value ) {
		$this->set_prop( 'location_latitude', $value );
	}

	/**
	 * Longitude
	 *
	 * @since 1.0.0
	 *
	 * @param string $value Longitude.
	 */
	public function set_location_longitude( $value ) {
		$this->set_prop( 'location_longitude', $value );
	}

	/**
	 * Formatted
	 *
	 * @since 1.0.0
	 *
	 * @param string $value Formatted.
	 */
	public function set_location_formatted( $value ) {
		$this->set_prop( 'location_formatted', $value );
	}

	/**
	 * Original input.
	 *
	 * @since 1.0.0
	 *
	 * @param string $value Formatted.
	 */
	public function set_location_input( $value ) {
		$this->set_prop( 'location_input', $value );
	}

	/**
	 * Raw
	 *
	 * @since 1.0.0
	 *
	 * @param array $value Raw.
	 */
	public function set_location_raw( $value ) {
		$this->set_prop( 'location_raw', maybe_unserialize( $value ) );
	}

}
