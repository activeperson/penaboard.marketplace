<?php
/**
 * Nav left dropdown.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! has_nav_menu( 'primary-left' ) ) {
	return;
} ?>

<div class="dropdown dropdown--user d-none d-md-block ml-half mr-fluid">
	<button class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php echo esc_html( wp_get_nav_menu_name( 'primary-left' ) ); ?>
	</button>

	<?php
	wp_nav_menu(
		[
			'theme_location' => 'primary-left',
			'menu_class'     => 'dropdown-menu',
			'menu_container' => 'div',
			'container'      => false,
			'fallback_cb'    => false,
			'depth'          => 1,
		]
	); ?>
</div>
