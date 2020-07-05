<?php
/**
 * A set of filters and actions to apply different values and features for the Tasti demo.
 */

/**
 * Tasti uses a secondary color for the contact button, but the default is light.
 */
add_filter( 'vendify_vendor_contact_button_color', function( $default_color ){
	return 'secondary';
} );
