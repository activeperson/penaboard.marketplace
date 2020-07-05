<?php
/**
 * Header: v5
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
<header class="site-header site-header--5 site-header--<?php echo transparent_item_classname(); ?>">
	<div class="container">
		<button class="btn-icon d-md-none js-menu-toggle" data-direction="left" aria-label="<?php echo esc_html_e( 'Toggle the navigation', 'vendify' ); ?>">
			<?php svg( 'hamburger' ); ?>
		</button>

		<?php
		$logo_tag = is_front_page() || is_home() ? 'h1' : 'p';
		partial( 'branding', [ 'tag' => $logo_tag ] );
		partial( 'nav/left' ); ?>

		<div class="custom-search custom-search--static d-none d-md-block ml-fluid">
			<?php partial( 'searchform-header' ); ?>
		</div>

		<div class="sh-dropdown sh-dropdown--more ml-auto d-none d-md-flex"></div>

		<?php partial( 'nav/right' ); ?>
	</div>
</header>
