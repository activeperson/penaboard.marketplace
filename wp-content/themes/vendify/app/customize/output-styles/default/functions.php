<?php
/**
 * A set of filters and actions to apply different values and features for the Tasti demo.
 */

namespace Astoundify\Vendify\Customize\Classic;

/**
 * @param $attr
 *
 * @return string
 */
function add_pagination_style_classes( $attr ) {
	$attr = ' class="wp-block-button btn-outline-primary is-style-outline has-primary-color" ';

	return $attr;
}

add_filter( 'next_posts_link_attributes', 'Astoundify\Vendify\Customize\Classic\add_pagination_style_classes' );
add_filter( 'previous_posts_link_attributes', 'Astoundify\Vendify\Customize\Classic\add_pagination_style_classes' );
