<?php
/**
 * Sponsor.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Events
 * @author Astoundify
 */

namespace Astoundify\WC_Themes\Events;

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sponsor.
 */
class Sponsor {

	/**
	 * Data
	 *
	 * @since 1.0.0
	 *
	 * @var array|WP_User Sponsor data.
	 */
	public $data;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $sponsor Sponsor data.
	 */
	public function __construct( $sponsor ) {
		$this->data = $sponsor;
	}

	/**
	 * Get Name
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_name() {
		$name = '';

		if ( $this->data ) {
			$name = $this->data['name'];
		}

		return apply_filters( 'astoundify_wc_themes_events_sponsor_name', $name, $this );
	}

	/**
	 * Get Email
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_email() {
		$email = '';

		if ( $this->data ) {
			$email = $this->data['email'];
		}

		return sanitize_email( apply_filters( 'astoundify_wc_themes_events_sponsor_email', $email, $this ) );
	}

	/**
	 * Get Image URL
	 *
	 * @since 1.0.0
	 *
	 * @return int Attachment image ID.
	 */
	public function get_image() {
		$image = '';

		if ( $this->data ) {
			$image = $this->data['image'];
		}

		return absint( apply_filters( 'astoundify_wc_themes_events_sponsor_image', $image, $this ) );
	}

	/**
	 * Get Website URL
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_url() {
		$url = '';

		if ( $this->data ) {
			$url = $this->data['url'];
		}

		return apply_filters( 'astoundify_wc_themes_events_sponsor_url', $url, $this );
	}
}
