<?php
/**
 * Nav right.
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

if ( ! is_header_style( 3 ) ) {
	partial( 'nav/right--icons' );
	partial( 'nav/right--user' );
}

if ( is_header_style( 3 ) ) {
	wp_nav_menu(
		[
			'theme_location' => 'primary-right',
			'menu_class'     => 'nav',
			'container'      => false,
			'walker'         => new Bootstrap_Menu_Walker(),
			'depth'          => 2,
			'fallback_cb'    => false,
		]
	);
} ?>

<button class="btn-icon d-md-none js-menu-toggle" data-direction="right" aria-label="<?php echo esc_html_e( 'Toggle user dropdown', 'vendify' ); ?>">
	<?php svg( 'user' ); ?>
</button>
