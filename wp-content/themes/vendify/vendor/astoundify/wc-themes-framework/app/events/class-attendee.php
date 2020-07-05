<?php
/**
 * Attendee.
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
 * Attendee.
 */
class Attendee {

	/**
	 * Data
	 *
	 * @since 1.0.0
	 *
	 * @var array|WP_User Attendee data.
	 */
	public $data;

	/**
	 * Data Type
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $type;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $attendee Attendee data.
	 */
	public function __construct( $attendee ) {
		if ( is_array( $attendee ) ) {
			$this->type = 'external';
			$this->data = $attendee;
		} else {
			$this->type = 'user';
			$this->data = get_user_by( 'ID', $attendee );
		}
	}

	/**
	 * Get type.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if WP User, False if external.
	 */
	public function get_type() {
		return 'user' === $this->type ? 'user' : 'external';
	}

	/**
	 * Is user.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if WP User, False if external.
	 */
	public function is_user() {
		return 'user' === $this->get_type();
	}

	/**
	 * User ID.
	 *
	 * @since 1.0.0
	 *
	 * @return int|false User ID if WP User, False if external.
	 */
	public function user_id() {
		return $this->is_user() ? $this->data->ID : false;
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
			if ( $this->is_user() ) {
				$name = $this->data->first_name;

				if ( $this->data->last_name ) {
					$name .= ' ' . $this->data->last_name;
				}

				if ( '' === $name ) {
					$name = $this->data->user_login;
				}
			} else {
				$name = $this->data['name'];
			}
		}

		return apply_filters( 'astoundify_wc_themes_events_attendee_name', $name, $this );
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
			$email = $this->is_user() ? $this->data->user_email : $this->data['email'];
		}

		return sanitize_email( apply_filters( 'astoundify_wc_themes_events_attendee_email', $email, $this ) );
	}

	/**
	 * Get Location
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_location() {
		$location = '';

		if ( $this->data ) {
			$location = $this->is_user() ? $this->data->location : $this->data['location'];
		}

		return apply_filters( 'astoundify_wc_themes_events_attendee_location', $location, $this );
	}
}
