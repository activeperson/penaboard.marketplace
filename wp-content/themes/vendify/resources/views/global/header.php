<?php
/**
 * Global page header.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>
<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="initial-scale=1">

		<link rel="profile" href="http://gmpg.org/xfn/11">

		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>">
		<?php endif;

		wp_head(); ?>
	</head>

	<body <?php body_class( 'vendify' ); ?>>

		<div class="pusher-container">

			<div class="pusher">
				<aside class="menu menu--left">
					<?php partial( 'nav/left-offcanvas' ); ?>
				</aside>

				<aside class="menu menu--right">
					<?php partial( 'nav/right-offcanvas' ); ?>
				</aside>

				<div class="page-wrap d-flex flex-column">

				<?php
				partial( 'header/style-' . get_theme_mod( 'header-style', 1 ) );

				do_action( 'vendify_header_after' );
