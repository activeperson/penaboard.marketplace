<?php
/**
 * Dashboard Page
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var array $activities_by_timestamp Activities by timezone.
 * @var array $activities_by_groups Activities by groups.
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

astoundify_wc_themes_get_template( 'vendor-dashboard/dashboard-report-by-date.php' );

astoundify_wc_themes_get_template( 'vendor-dashboard/dashboard-overview.php' );

astoundify_wc_themes_get_template( 'vendor-dashboard/dashboard-activities.php', array(
	'activities_by_timestamp' => $activities_by_timestamp,
	'activities_by_groups'    => $activities_by_groups,
) );
