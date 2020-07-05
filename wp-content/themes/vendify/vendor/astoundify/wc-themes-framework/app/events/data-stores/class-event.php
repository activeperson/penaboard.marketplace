<?php
/**
 * Event Product Data Store.
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
class Event extends Geolocated {

	/**
	 * Read product data.
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Product $product Current product.
	 */
	protected function read_product_data( &$product ) {
		parent::read_product_data( $product );

		$set_props  = array();

		foreach ( $product->get_extra_data_keys() as $key ) {
			$set_props[ $key ] = get_post_meta( $product->get_id(), "_astoundify_wc_themes_{$key}", true );
		}

		$product->set_props( $set_props );
	}

	/**
	 * Read extra data associated with the product, like button text or product URL for external products.
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Product $product Current product.
	 */
	protected function read_extra_data( &$product ) {
		foreach ( $product->get_extra_data_keys() as $key ) {
			$function = 'set_' . $key;
			if ( is_callable( array( $product, $function ) ) ) {
				$product->{$function}( get_post_meta( $product->get_id(), "_astoundify_wc_themes_{$key}", true ) );
			}
		}
	}

	/**
	 * Update Post Meta
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Product $product Current product.
	 * @param bool       $force Force all props to be written even if not changed.
	 */
	protected function update_post_meta( &$product, $force = false ) {
		parent::update_post_meta( $product, $force );

		foreach ( $product->get_extra_data_keys() as $key ) {
			update_post_meta( $product->get_id(), "_astoundify_wc_themes_{$key}", $product->{ "get_{$key}" }( 'edit' ) );
		}
	}

	/**
	 * Update meta fields used to query events by date.
	 *
	 * @since 1.0.0
	 *
	 * @param WC_Product $product Current product.
	 * @param array      $schedule Schedule data.
	 */
	public function update_schedule_days( &$product, $schedule ) {
		delete_post_meta( $product->get_id(), '_astoundify_wc_themes_schedule_day' );

		foreach ( $schedule as $entry ) {
			add_post_meta( $product->get_id(), '_astoundify_wc_themes_schedule_day', $entry['date'], false );
		}
	}

}
