<?php
/**
 * A product that has event data attached to it.
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
class Event extends Geolocated {

	/**
	 * Stores extar data (using WordPress post meta data as storage).
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $extra_data = array(
		'attendees' => array(),
		'sponsors' => array(),
		'lineup' => array(),
		'schedule' => array(),
		'schedule_timezone' => '',
		'schedule_utc_offset' => '',
		'external_event' => false,
		'ticket_url' => '',
		'ticket_provider' => '',
	);

	/**
	 * Extra event data.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $custom_data = array();

	/**
	 * Get internal type.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_type() {
		return 'event';
	}

	/**
	 * Get custom data.
	 *
	 * Can't use $extra_data because this will default to the wp_postmeta table.
	 *
	 * @since 1.0.0
	 */
	public function get_custom_data() {
		return $this->custom_data;
	}

	/**
	 * Get custom data keys.
	 *
	 * Can't use $extra_data because this will default to the wp_postmeta table.
	 *
	 * @since 1.0.0
	 */
	public function get_custom_data_keys() {
		return array_keys( $this->custom_data );
	}

	/**
	 * Initialize an event product.
	 *
	 * Merges external product data in to the parent object.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $product Current product.
	 */
	public function __construct( $product = 0 ) {
		// Merge in our custom data so the getters and setters can be validated.
		$this->data = array_merge( $this->data, $this->get_custom_data(), $this->get_address_data() );

		parent::__construct( $product );
	}

	/* === EXTERNAL EVENT/TICKET === */

	/**
	 * Is External
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function is_external_event() {
		return 'yes' === $this->get_external_event() ? true : false;
	}

	/**
	 * Is External
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function get_external_event( $context = 'view' ) {
		return 'yes' === $this->get_prop( 'external_event', $context ) ? 'yes' : 'no';
	}

	/**
	 * Set event as external.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attendees List of attendees.
	 */
	public function set_external_event( $external ) {
		$this->set_prop( 'external_event', 'yes' === $external ? 'yes' : 'no' );
	}

	/* --- EXTERNAL PRODUCT: Stock Setup --- */

	/**
	 * External products cannot be stock managed.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $manage_stock Manage stock.
	 */
	public function set_manage_stock( $manage_stock ) {

		if ( false === $this->is_external_event() ) {
			$this->set_prop( 'manage_stock', wc_string_to_bool( $manage_stock ) );
		} else {
			$this->set_prop( 'manage_stock', wc_string_to_bool( 'no' ) );
		}
	}

	/**
	 * External products cannot be stock managed.
	 *
	 * @since 1.0.0
	 *
	 * @param string $stock_status Stock Status.
	 */
	public function set_stock_status( $stock_status = '' ) {

		if ( 'instock' !== $stock_status && $this->is_external_event() ) {
			$this->set_prop( 'stock_status', 'instock' );
			$this->error( 'product_external_invalid_stock_status', __( 'External products cannot be stock managed.', 'astoundify-wc-themes' ) );
		} else {
			$this->set_prop( 'stock_status', $stock_status );
		}
	}

	/**
	 * External products cannot be backordered.
	 *
	 * @since 1.0.0
	 *
	 * @param string $backorders Options: 'yes', 'no' or 'notify'.
	 */
	public function set_backorders( $backorders ) {

		if ( 'no' !== $backorders && $this->is_external_event() ) {
			$this->set_prop( 'backorders', 'no' );
			$this->error( 'product_external_invalid_backorders', __( 'External products cannot be backordered.', 'astoundify-wc-themes' ) );
		} else {
			$this->set_prop( 'backorders', $backorders );
		}
	}

	/* --- EXTERNAL PRODUCT: Other Action --- */

	/**
	 * Returns false if the product cannot be bought.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function is_purchasable() {
		return apply_filters( 'woocommerce_is_purchasable', $this->is_external_event() ? false : true, $this );
	}

	/**
	 * Get the add to url used mainly in loops.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function add_to_cart_url() {
		$url = $this->is_purchasable() && $this->is_in_stock() ? remove_query_arg( 'added-to-cart', add_query_arg( 'add-to-cart', $this->id ) ) : get_permalink( $this->id );
		return apply_filters( 'woocommerce_product_add_to_cart_url', $this->is_external_event() ? $this->get_ticket_url() : $url, $this );
	}

	/**
	 * Get the add to cart button text for the single page.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function single_add_to_cart_text() {
		return apply_filters( 'woocommerce_product_single_add_to_cart_text', $this->is_external_event() ? esc_html__( 'Buy Now', 'astoundify-wc-themes' ) : esc_html__( 'Add to cart', 'astoundify-wc-themes' ), $this );
	}

	/* === TICKET URL (EXTERNAL) === */

	/**
	 * Get ticket url.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $context Context.
	 * @return string
	 */
	public function get_ticket_url( $context = 'view' ) {
		return esc_url( $this->get_prop( 'ticket_url', $context ) );
	}

	/**
	 * Set ticket URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $ticket_url Product URL.
	 */
	public function set_ticket_url( $ticket_url ) {
		$this->set_prop( 'ticket_url', $ticket_url );
	}

	/* === TICKET PROVIDER (EXTERNAL) === */

	/**
	 * Get ticket provider.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $context Context.
	 * @return string
	 */
	public function get_ticket_provider( $context = 'view' ) {
		return esc_html( $this->get_prop( 'ticket_provider', $context ) );
	}

	/**
	 * Set ticket provider.
	 *
	 * @since 1.0.0
	 *
	 * @param string $ticket_url Product URL.
	 */
	public function set_ticket_provider( $ticket_provider ) {
		$this->set_prop( 'ticket_provider', astoundify_wc_themes_events_sanitize_ticket_provider( $ticket_provider ) );
	}

	/* === ATTENDEES === */

	/**
	 * Get a list of attendeeds.
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return array List of Attendee data.
	 */
	public function get_attendees( $context = 'view' ) {
		$attendees = $this->get_prop( 'attendees', $context );
		$attendees = is_array( $attendees ) ? $attendees : array();

		return $attendees;
	}

	/**
	 * Set a list of attendees.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attendees List of attendees.
	 */
	public function set_attendees( $attendees ) {
		// Must be an array.
		if ( ! is_array( $attendees ) ) {
			return;
		}

		// Sanitize.
		$attendees = array_filter( $attendees, 'astoundify_wc_themes_event_sanitize_attendee' );

		$this->set_prop( 'attendees', $attendees );
	}

	/**
	 * Add a single attendee.
	 *
	 * @since 1.0.0
	 *
	 * @param int|array $attendee Attendee data.
	 */
	public function add_attendee( $attendee ) {
		// Sanitize.
		$attendee = astoundify_wc_themes_event_sanitize_attendee( $attendee );

		if ( ! $attendee ) {
			return;
		}

		// Get all attendees.
		$attendees = $this->get_attendees( 'edit' );

		// Add attendee to list.
		if ( is_array( $attendee ) ) { // External.
			$attendees[ esc_attr( $attendee['name'] ) ] = $attendee;
		} elseif ( $attendee ) { // WP User.
			$attendees[ $attendee ] = $attendee;
		}

		$this->set_attendees( $attendees );
	}

	/* === SPONSORS === */

	/**
	 * Get a list of sponsors.
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return array List of Sponsors data.
	 */
	public function get_sponsors( $context = 'view' ) {
		$sponsors = $this->get_prop( 'sponsors', $context );
		$sponsors = is_array( $sponsors ) ? $sponsors : array();

		return $sponsors;
	}

	/**
	 * Get a list of sponsors.
	 *
	 * @since 1.0.0
	 *
	 * @param array $sponsors List of sponsors.
	 */
	public function set_sponsors( $sponsors ) {
		// Must be an array.
		if ( ! is_array( $sponsors ) ) {
			return;
		}

		// Sanitize.
		$sponsors = array_filter( $sponsors, 'astoundify_wc_themes_events_sanitize_sponsor' );

		$this->set_prop( 'sponsors', $sponsors );
	}

	/**
	 * Add a single sponsor.
	 *
	 * @since 1.0.0
	 *
	 * @param int|array $sponsor Sponsor data.
	 */
	public function add_sponsor( $sponsor ) {
		// Sanitize.
		$sponsor = astoundify_wc_themes_events_sanitize_sponsor( $sponsor );

		if ( ! $sponsor ) {
			return;
		}

		// Get all sponsors.
		$sponsors = $this->get_sponsors( 'edit' );

		// Add sponsor to list.
		if ( is_array( $sponsor ) ) { // External.
			$sponsors[ esc_attr( $sponsor['name'] ) ] = $sponsor;
		} elseif ( $sponsor ) { // WP User.
			$sponsors[ $sponsor ] = $sponsor;
		}

		$this->set_sponsors( $sponsors );
	}

	/* === LINEUP === */

	/**
	 * Get a lineup.
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return array Lineup.
	 */
	public function get_lineup( $context = 'view' ) {
		$lineup = $this->get_prop( 'lineup', $context );
		$lineup = is_array( $lineup ) ? $lineup : array();

		return $lineup;
	}

	/**
	 * Get a lineup.
	 *
	 * @since 1.0.0
	 *
	 * @param array $lineup List of lineup.
	 */
	public function set_lineup( $lineup ) {
		// Must be an array.
		if ( ! is_array( $lineup ) ) {
			return;
		}

		// Sanitize.
		$lineup = array_filter( $lineup, 'astoundify_wc_themes_events_sanitize_lineup_person' );

		$this->set_prop( 'lineup', $lineup );
	}

	/**
	 * Add a single lineup person.
	 *
	 * @since 1.0.0
	 *
	 * @param int|array $person Person.
	 */
	public function add_lineup_person( $person ) {
		// Sanitize.
		$person = astoundify_wc_themes_events_sanitize_lineup_person( $person );

		if ( ! $person ) {
			return;
		}

		// Get a lineup.
		$lineup = $this->get_lineup( 'edit' );

		// Add person to list.
		if ( is_array( $person ) ) { // External.
			$lineup[ esc_attr( $person['name'] ) ] = $person;
		} elseif ( $person ) { // WP User.
			$lineup[ $person ] = $person;
		}

		$this->set_lineup( $lineup );
	}

	/* === SCHEDULE === */

	/**
	 * Get schedule data.
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return array List of schedule data.
	 */
	public function get_schedule( $context = 'view' ) {
		return $this->get_prop( 'schedule', $context );
	}

	/**
	 * Set schedule data. All stored in timestamps.
	 *
	 * @since 1.0.0
	 *
	 * @param array $schedule List of schedule data..
	 */
	public function set_schedule( $schedule ) {
		// Must be an array.
		if ( ! is_array( $schedule ) ) {
			return;
		}

		$this->set_prop( 'schedule', $schedule );
	}

	/**
	 * Get schedule timezone string.
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string Schedule string.
	 */
	public function get_schedule_timezone( $context = 'view' ) {
		return $this->get_prop( 'schedule_timezone', $context );
	}

	/**
	 * Set schedule timezone.
	 *
	 * @since 1.0.0
	 *
	 * @param string $timezone Timezone string.
	 */
	public function set_schedule_timezone( $timezone ) {
		$this->set_prop( 'schedule_timezone', $timezone );
	}

	/**
	 * Get schedule timezone UTC offset.
	 *
	 * @since 1.0.0
	 *
	 * @param string $context Retrieval context.
	 * @return string
	 */
	public function get_schedule_utc_offset( $context = 'view' ) {
		return $this->get_prop( 'schedule_utc_offset', $context );
	}

	/**
	 * Set schedule UTC offset.
	 *
	 * @since 1.0.0
	 *
	 * @param string $value Timezone UTC offset.
	 */
	public function set_schedule_utc_offset( $value ) {
		$this->set_prop( 'schedule_utc_offset', $value );
	}

}
