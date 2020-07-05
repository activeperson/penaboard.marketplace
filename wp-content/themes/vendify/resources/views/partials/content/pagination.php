<?php
/**
 * Content pagination.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

the_posts_pagination(
	[
		'prev_text' => __( 'Prev', 'vendify' ),
		'next_text' => __( 'Next', 'vendify' ),
	]
);
