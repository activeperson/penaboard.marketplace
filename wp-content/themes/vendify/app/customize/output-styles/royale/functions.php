<?php
/**
 * A set of filters and actions to apply different values and features for the Royale demo.
 */

namespace Astoundify\Vendify\Customize\Royale;

function return_secondary_class_name( $default_color ){
	return 'secondary';
}

/**
 * Royale uses a secondary color for the contact button, but the default is light.
 */
add_filter( 'vendify_vendor_contact_button_color', 'Astoundify\Vendify\Customize\Royale\return_secondary_class_name' );

/**
 * Royale uses a secondary color for the vendor name in vendor cards.
 */
add_filter( 'vendify_product_card_autor_name_class', function ( $classname ) {
	return 'has-text-color has-secondary-color font-weight-normal';
} );

function add_pagination_style_classes( $attr ) {
	$attr = ' class="wp-block-button btn-outline-primary is-style-outline has-primary-color" ';

	return $attr;
}

add_filter( 'next_posts_link_attributes', 'Astoundify\Vendify\Customize\Royale\add_pagination_style_classes' );
add_filter( 'previous_posts_link_attributes', 'Astoundify\Vendify\Customize\Royale\add_pagination_style_classes' );
