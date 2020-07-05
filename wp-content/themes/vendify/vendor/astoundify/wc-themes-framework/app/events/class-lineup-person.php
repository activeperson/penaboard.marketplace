<?php
/**
 * Lineup person.
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
 * Lineup person.
 */
class Lineup_Person {

	/**
	 * Data
	 *
	 * @since 1.0.0
	 *
	 * @var array|WP_User Lineup person data.
	 */
	public $data;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $lineup_person Lineup person data.
	 */
	public function __construct( $lineup_person ) {
		$this->data = $lineup_person;
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

		return apply_filters( 'astoundify_wc_themes_events_lineup_person_name', $name, $this );
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

		return sanitize_email( apply_filters( 'astoundify_wc_themes_events_lineup_person_email', $email, $this ) );
	}

	/**
	 * Get Image URL
	 *
	 * @since 1.0.0
	 *
	 * @return int Attachment Image ID.
	 */
	public function get_image() {
		$image = '';

		if ( $this->data ) {
			$image = $this->data['image'];
		}

		return absint( apply_filters( 'astoundify_wc_themes_events_lineup_person_image', $image, $this ) );
	}

	/**
	 * Get Title/Label
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_title() {
		$title = '';

		if ( $this->data ) {
			$title = $this->data['title'];
		}

		return apply_filters( 'astoundify_wc_themes_events_lineup_person_title', $title, $this );
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

		return apply_filters( 'astoundify_wc_themes_events_lineup_person_url', $url, $this );
	}
}
