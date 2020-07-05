<?php
/**
 * Partial template which should display the <!--more--> flag.
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

wp_link_pages(
	[
		'before'         => '<nav class="navigation pagination" role="navigation"><div class="nav-links">',
		'after'          => '</div></nav>',
		'next_or_number' => 'next',
	]
);
