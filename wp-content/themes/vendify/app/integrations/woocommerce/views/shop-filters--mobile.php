<?php
/**
 * Mobile shop filters.
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

if ( ! is_active_sidebar( 'shop' ) ) :
	return;
endif; ?>

<nav class="navigation navigation--find-mobile">
	<div class="container">
			<ul class="nav nav-tabs">
				<li class="nav-item ml-auto">
					<button class="nav-link js-find-menu-toggle btn-icon">
						<?php svg( 'filter' ); ?>
					</button>
				</li>
			</ul>
	</div>
</nav>

<div class="find-menu">
	<header class="find-menu__header">
		<?php esc_html_e( 'Filters', 'vendify' ); ?>
		<button class="btn-icon">
			<?php
			svg(
				[
					'icon'    => 'filter',
					'classes' => [ 'ico--inverse' ],
				]
			); ?>
		</button>
	</header>

	<div class="find-menu__body">
		<?php dynamic_sidebar( 'shop' ); ?>
	</div>
</div>
