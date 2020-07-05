<?php
/**
 * Off canvas menu: main.
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

<header class="menu__header has-background has-light-background-color">
	<?php partial( 'branding' ); ?>
</header>

<div class="menu__content">
	<div class="custom-search custom-search--static custom-search--centered">
		<?php partial( 'searchform-header' ); ?>
	</div>

	<?php
	wp_nav_menu(
		[
			'theme_location'  => 'primary-left',
			'menu_class'      => 'nav flex-column align-items-start',
			'container'       => 'nav',
			'container_class' => 'menu__nav',
			'fallback_cb'     => false,
			'depth'           => 0,
			'walker'         => new Bootstrap_Menu_Walker(),
		]
	);

	$more_menu = wp_nav_menu(
		[
			'echo'            => false,
			'theme_location'  => 'primary-more',
			'menu_class'      => 'nav flex-column align-items-start',
			'container'       => 'nav',
			'container_class' => 'menu__nav menu__nav-more',
			'fallback_cb'     => false,
			'depth'           => 0,
		]
	);

	if ( ! empty( $more_menu ) ) {

		printf( '%s', $more_menu ); ?>

		<button class="btn-icon ml-auto js-sidebar-toggle"><?php svg( 'more' ); ?> </button>

	<?php } ?>

</div>
