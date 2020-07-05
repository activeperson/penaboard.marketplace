<?php
/**
 * Private Messages template hooks.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Allow template overrides.
add_filter( 'pm_locate_template', 'Astoundify\Vendify\pm_locate_template', 10, 2 );
add_filter( 'page_template_hierarchy', 'Astoundify\Vendify\pm_assign_page_templates', 5 );
