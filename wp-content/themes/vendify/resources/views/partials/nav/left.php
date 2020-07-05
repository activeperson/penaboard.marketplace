<?php
/**
 * Nav left.
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

wp_nav_menu(
	[
		'theme_location' => 'primary-left',
		'menu_class'     => 'nav' . ( is_header_style( 4 ) ? ' nav-justified' : '' ),
		'container'      => false,
		'walker'         => new Bootstrap_Menu_Walker(),
		'depth'          => 2,
		'fallback_cb'    => function() {
			echo '<ul class="nav"></ul>'; // WPCS: XSS ok.
		},
	]
);

if ( is_header_style( [ 1, 2, 5 ] ) && has_nav_menu( 'primary-more' ) ) { ?>

<div class="sh-dropdown d-none d-md-flex ml-half">
	<button class="sh-dropdown__toggle sh-dropdown__toggle-ml" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php svg( 'more' ); ?>
	</button>

	<?php
	wp_nav_menu(
		[
			'theme_location' => 'primary-more',
			'menu_class'     => 'dropdown-menu dropdown-menu--bordered dropdown-menu-right',
			'container'      => false,
			'fallback_cb'    => false,
			'depth'          => 1,
		]
	); ?>
</div>

<?php }


