<?php
/**
 * Dashboard Page: Activities Item (User)
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
	// Translators: %1$s User name, %2$s star count, %3$s product name.
	__( '%1$s left a %2$s star review on %3$s', 'astoundify-wc-themes' ),
	$user_name,
	$star_count,
	$product_name
);
