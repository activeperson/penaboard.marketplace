<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @todo Remove repeated code.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_user_logged_in() ) {
	return;
}

$endpoints = wc_get_account_menu_items();
$main      = array_slice( $endpoints, 0, count( $endpoints ) - 1 );
$logout    = array_slice( $endpoints, count( $endpoints ) - 1, 1 ); ?>

<nav class="navigation navigation--dashboard">
	<div class="container">
		<ul class="nav nav-tabs">
			<?php foreach ( $main as $endpoint => $label ) { ?>
				<li class="<?php echo is_page( wc_get_page_id( 'myaccount' ) ) ? wc_get_account_menu_item_classes( $endpoint ) : null; ?> nav-item">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="nav-link"><?php echo esc_html( $label ); ?></a>
				</li>
			<?php }

			if ( has_integration( 'private-messages' ) ) { ?>
			<li class="nav-item">
				<a href="<?php echo esc_url( pm_get_permalink( 'dashboard' ) ); ?>" class="nav-link">
					<?php
					esc_html_e( 'Messages', 'vendify' );

					if ( 0 !== (int) pm_get_unread_count( get_current_user_id() ) ) { ?>
						<span class="badge badge--sm badge--pill badge-secondary"><?php echo esc_html( pm_get_unread_count( get_current_user_id() ) ); ?></span>
					<?php } else { ?>
						<span class="badge badge--sm badge--pill badge-outline-gray-500">0</span>
					<?php } ?>
				</a>
			</li>
			<?php }

			foreach ( $logout as $endpoint => $label ) { ?>
				<li class="<?php echo is_page( wc_get_page_id( 'myaccount' ) ) ? wc_get_account_menu_item_classes( $endpoint ) : null; ?> nav-item">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="nav-link"><?php echo esc_html( $label ); ?></a>
				</li>
			<?php } ?>
		</ul>
	</div>
</nav>
