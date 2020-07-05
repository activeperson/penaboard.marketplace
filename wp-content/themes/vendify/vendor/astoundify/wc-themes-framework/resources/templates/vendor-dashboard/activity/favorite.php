<?php
/**
 * Dashboard Page: Activities Item (Favorite)
 *
 * @var array $activity
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

printf(
	// Translators: %1$s User name, %2$s product name.
	__( '%1$s favorited %2$s', 'astoundify-wc-themes' ),
	$user_name,
	$product_name
);
