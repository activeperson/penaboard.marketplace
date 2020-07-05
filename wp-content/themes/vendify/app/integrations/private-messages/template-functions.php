<?php
/**
 * Private Messages Template.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Look in our custom directory for a template.
 *
 * @since 1.0.0
 *
 * @param string $template      Template to load.
 * @param string $template_name Template file name.
 * @return string
 */
function pm_locate_template( $template, $template_name ) {
	$try = locate_template( [ 'app/integrations/private-messages/views/' . $template_name ], false, false );

	if ( $try ) {
		return $try;
	}

	return $template;
}

/**
 * Filter returned page templates.
 *
 * @since 1.0.0
 *
 * @param array $post_templates The current list of templates.
 * @return array
 */
function pm_assign_page_templates( $templates ) {
	$add     = [];
	$page_id = pm_get_option( 'pm_dashboard_page_id', false );

	if ( $page_id && is_page( $page_id ) ) {
		$add[] = 'app/integrations/private-messages/views/page-template.php';
	}

	if ( ! empty( $add ) ) {
		$templates = array_merge( $add, $templates );
	}

	return $templates;
}
