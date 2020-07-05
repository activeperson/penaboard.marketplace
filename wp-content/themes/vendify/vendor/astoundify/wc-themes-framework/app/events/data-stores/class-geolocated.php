<?php
/**
 * Geolocated Product Data Store.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Data Store
 * @author Astoundify
 */

namespace Astoundify\WC_Themes\Datastores;

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Event Product Data Store.
 *
 * @version 1.0.0
 */
class Geolocated extends \WC_Product_Data_Store_CPT {

	/**
	 * Update a product.
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Product $product Current product.
	 */
	public function update( &$product ) {
		parent::update( $product );

		// Product exists but no location data.
		$location = $this->get_location_data( $product->get_id() );

		if ( ! $location || empty( $location ) ) {
			$this->insert_location_data( $product );
		} else {
			$this->update_location_data( $product );
		}
	}

	/**
	 * Delete a product.
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Product $product Current product.
	 */
	public function delete( &$product, $args = array() ) {
		parent::delete( $product, $args );

		// Delete args.
		$args = wp_parse_args( $args, array(
			'force_delete' => false,
		) );

		// Only delete db if product deleted, not trashed.
		if ( $args['force_delete'] ) {

			// Only delete if exist.
			$location = $this->get_location_data( $product->get_id() );
			if ( $location ) {
				$this->delete_location_data( $product->get_id() );
			}
		}
	}

	/**
	 * Read product data.
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Product $product Current product.
	 */
	protected function read_product_data( &$product ) {
		parent::read_product_data( $product );

		$props = array();
		$location = $this->get_location_data( $product->get_id() );

		if ( ! $location || empty( $location ) ) {
			return;
		}

		// Populate location data.
		foreach ( $product->get_address_data_keys() as $key ) {
			$location_key = str_replace( 'location_', '', $key );
			$props[ $key ] = $location->$location_key;
		}

		$product->set_props( $props );
	}

	/**
	 * Insert a new row of data.
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Product $product Current product.
	 */
	public function insert_location_data( $product ) {
		global $wpdb;

		// @codingStandardsIgnoreStart
		$wpdb->insert(
			$wpdb->prefix . 'wc_product_locations',
			$this->get_location_data_values( $product )
		);
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Update custom location product meta.
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Product $product Current product.
	 */
	protected function update_location_data( $product ) {
		global $wpdb;

		// @codingStandardsIgnoreStart
		$wpdb->update(
			$wpdb->prefix . 'wc_product_locations',
			$this->get_location_data_values( $product ),
			array(
				'product_id' => $product->get_id(),
			)
		);
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Delete custom location product meta.
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Product $product Current product.
	 */
	public function delete_location_data( $product_id ) {
		global $wpdb;

		// @codingStandardsIgnoreStart
		$wpdb->delete(
			$wpdb->prefix . 'wc_product_locations',
			array(
				'product_id' => $product_id,
			)
		);
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Get the current values of the custom data.
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Product $product Current product.
	 * @return array
	 */
	protected function get_location_data_values( $product ) {
		$data = array();
		$data['product_id'] = $product->get_id();

		foreach ( $product->get_address_data_keys() as $key ) {
			$data_key = str_replace( 'location_', '', $key );
			$data[ $data_key ] = call_user_func( array( $product, "get_{$key}" ) );
		}

		return $data;
	}

	/**
	 * Read location meta from `wc_product_locations` table.
	 *
	 * @since 1.0.0
	 *
	 * @param int $product_id Product to retrieve location data for.
	 * @return stdObj|false
	 */
	public function get_location_data( $product_id ) {
		$data = wp_cache_get( 'product-location-' . $product_id, 'astoundify-wc-themes' );

		if ( false === $data ) {
			global $wpdb;

			// @codingStandardsIgnoreStart
			$data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wc_product_locations WHERE product_id = %d LIMIT 1", $product_id ) );
			// @codingStandardsIgnoreEnd

			if ( null !== $data ) {
				wp_cache_set( 'product-location-' . $product_id, $data, 'astoundify-wc-themes' );
			}
		}

		return $data;
	}

}
