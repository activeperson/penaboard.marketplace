<?php
/**
 * Off canvas menu: user.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use WC_Product_Vendors_Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>

<header class="menu__header menu__header--link has-background has-light-background-color">
	<?php

	if ( is_user_logged_in() ) {

		if ( has_integration( 'woocommerce-product-vendors' ) && WC_Product_Vendors_Utils::is_vendor() ) {
			$vendor_data = get_vendor_meta( get_current_user_id(), 'user_id' );

			$unpaid = astoundify_wc_themes_vendors_get_vendor_total_data(
				[
					'column' => 'total_commission_amount',
					'status' => 'unpaid',
				]
			); ?>

			<span class="menu__user-logo">
				<?php echo get_avatar( get_current_user_id(), 30 ); ?>
			</span>

			<?php echo esc_attr( $vendor_data['name'] ); ?>

			<span class="badge badge--sm badge-outline-success ml-auto"><?php echo wc_price( $unpaid ); ?></span>

			<a class="btn-icon ml-2" href="<?php echo esc_url( astoundify_wc_themes_vendors_get_dashboard_endpoint_url( false ) ); ?>">
				<?php
				svg(
					[
						'icon'    => 'caret-slider-right',
						'classes' => [ 'ico--xs' ],
					]
				); ?>
			</a>

		<?php } elseif ( function_exists( 'wc_get_page_id' ) ) { ?>

			<span class="menu__user-logo">
				<?php echo get_avatar( get_current_user_id(), 30 ); ?>
			</span>

			<?php echo esc_attr( get_the_author_meta( 'display_name', get_current_user_id() ) ); ?>

			<a class="btn-icon ml-auto" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>">
				<?php
				svg(
					[
						'icon'    => 'caret-slider-right',
						'classes' => [ 'ico--xs' ],
					]
				); ?>
			</a>

		<?php }
	} else { ?>

		<span class="menu__user-logo">
			<?php echo get_avatar( 0, 34 ); ?>
		</span>

		<?php
		esc_html_e( 'Guest', 'vendify' );

	} ?>
</header>

<div class="menu__content">
	<?php
	wp_nav_menu(
		[
			'theme_location'  => 'primary-account',
			'menu_class'      => 'nav flex-column',
			'container'       => 'nav',
			'container_class' => 'menu__nav menu__nav--user',
			'fallback_cb'     => false,
			'depth'           => 0,
		]
	); ?>
</div>

<footer class="menu__footer menu__footer--link">
	<?php if ( is_user_logged_in() ) { ?>
		<a href="<?php echo esc_url( wp_logout_url() ); ?>">
			<?php esc_html_e( 'Sign Out', 'vendify' ); ?>
	<?php } else { ?>
		<a href="<?php echo esc_url( wp_login_url() ); ?>">
			<?php esc_html_e( 'Sign In', 'vendify' );
	}

		svg(
			[
				'icon'    => 'caret-slider-right',
				'classes' => [ 'ico--xs' ],
			]
		); ?>
	</a>
</footer>
