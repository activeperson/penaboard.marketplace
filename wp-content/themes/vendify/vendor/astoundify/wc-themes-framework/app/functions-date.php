<?php
/**
 * Date functions.
 *
 * WordPress's built in date functions rely on timezoned strings.
 * WooCommerce's built in date functions rely on global settings.
 *
 * These functions are a bit more flexible and do not rely on a global
 * timezone or UTC offset.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Formatting
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Convert a date string to a UTC timestamp.
 *
 * @since 1.0.0
 *
 * @param string $date Date string to format as a UTC timestamp.
 * @param string $timezone_or_offset Timezone or string offset to offset date with.
 * @return int
 */
function astoundify_wc_themes_date_string_to_timestamp( $date, $timezone_or_offset ) {
	$date = gmdate( 'Y-m-d H:i:s', wc_string_to_timestamp( $date ) );
	$date = wc_string_to_timestamp( astoundify_wc_themes_get_gmt_from_date( $date, $timezone_or_offset ) );

	return $date;
}

/**
 * Get GMT date from string using timezone string or offset.
 *
 * Takes a date string (usuall Y-m-d H:i:s) and returns the same string
 * as a GMT/UTC date based on a set offset.
 *
 * The offset can be a timezone string (America/New_York) or UTC (-4).
 *
 * @since 1.0.0
 *
 * @param string $string Date string.
 * @param string $timezone_or_offset Timezone string or offset.
 * @return string.
 */
function astoundify_wc_themes_get_gmt_from_date( $string, $timezone_or_offset ) {
	$format = 'Y-m-d H:i:s';

	// Timezone string.
	if ( ! preg_match( '/^UTC[+-]/', $timezone_or_offset ) ) {
		// Check valid timezone.
		try {
			$datetimezone = new DateTimeZone( $timezone_or_offset );
		} catch ( Exception $e ) {
			$datetimezone = null;
		}

		$datetime = date_create( $string, $datetimezone );

		if ( ! $datetime ) {
			return gmdate( $format, 0 );
		}

		$datetime->setTimezone( new DateTimeZone( 'UTC' ) );
		$string_gmt = $datetime->format( $format );
	} else { // UTC offset.
		// Can't parse the date.
		if ( ! preg_match( '#([0-9]{1,4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#', $string, $matches ) ) {
			$datetime = strtotime( $string );

			if ( false === $datetime ) {
				return gmdate( $format, 0 );
			}

			return gmdate( $format, $datetime );
		}

		// Get just the offset amount from the string.
		$offset = preg_replace( '/UTC\+?/', '', $timezone_or_offset );

		// Create a GMT date.
		$string_time = gmmktime( $matches[4], $matches[5], $matches[6], $matches[2], $matches[3], $matches[1] );

		// Offset timestamp.
		$string_gmt = gmdate( $format, $string_time - ( $offset * HOUR_IN_SECONDS ) );
	}// End if().

	return $string_gmt;
}

/**
 * Get a timezone offset based on a timezone or UTC offset.
 *
 * @since 1.0.0
 *
 * @param string $offset +6/-6 for UTC offset or timezone string.
 * @return int
 */
function astoundify_wc_themes_get_timezone_offset( $offset ) {
	if ( ! is_numeric( $offset ) ) {
		try {
			$timezone_object = new DateTimeZone( $offset );

			return $timezone_object->getOffset( new DateTime( 'now' ) );
		} catch ( Exception $e ) {
			return 0;
		}
	} else {
		return floatval( $offset * HOUR_IN_SECONDS );
	}
}
