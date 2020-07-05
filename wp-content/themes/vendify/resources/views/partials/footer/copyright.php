<?php
/**
 * Footer copyright.
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
}

$footer_menu = wp_nav_menu(
	[
		'echo'           => false,
		'theme_location' => 'footer',
		'menu_class'     => 'nav',
		'fallback_cb'    => false,
	]
);

if ( ! empty( $footer_menu ) ) { ?>

	<div class="site-footer__dropup">
		<?php
		printf( '%s', $footer_menu ); ?>

		<button class="btn-icon btn-icon--close js-footer-dropup-close">
			<?php
			svg(
				[
					'icon'    => 'close',
					'classes' => [ 'ico--xs' ],
				]
			); ?>
		</button>
	</div>

<?php }

$legal_menu = wp_nav_menu(
	[
		'echo'           => false,
		'theme_location' => 'copyright',
		'fallback_cb'    => false,
		'menu_class'     => 'nav',
//			'container'      => '',
//			'items_wrap' => '%3$s',
//			'walker'         => new Link_Menu_Walker(),
//			'depth'          => 1,
	]
);

if ( ! empty( $legal_menu ) ) { ?>

	<div class="site-footer__dropup site-footer__dropup-legal">

		<?php printf( '%s', $legal_menu ); ?>

		<button class="btn-icon btn-icon--close js-footer-dropup-close-legal">
			<?php
			svg(
				[
					'icon'    => 'close',
					'classes' => [ 'ico--xs' ],
				]
			); ?>
		</button>
	</div>

<?php } ?>

<nav class="site-footer_secondary-nav d-flex">
	<?php

	partial( 'branding' );

	wp_nav_menu(
		[
			'theme_location' => 'footer',
			'menu_class'     => 'nav nav--copyright',
			'depth'          => 1,
			'fallback_cb'    => false,
		]
	); ?>

	<div class="site-footer__legal">
		<span><?php echo esc_html( sprintf( 'Все права защищены %d', date( 'Y' ) ) ); ?></span>
	</div>

	<?php /*
	if ( ! empty( $footer_menu ) ) { ?>
		<button class="btn-icon d-md-none ml-auto js-footer-toggle">
			<?php svg( 'more' ); ?>
		</button>
	<?php }

	if ( ! empty( $legal_menu ) ) { ?>
		<button class="btn-icon d-none d-md-block js-footer-toggle-legal">
			<?php svg( 'more' ); ?>
		</button>
	<?php } ?>

	<?php */ ?>
</nav>
