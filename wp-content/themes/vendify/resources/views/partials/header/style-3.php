<?php
/**
 * Header: v3
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
<header class="site-header site-header--3 site-header--<?php echo transparent_item_classname(); ?>">
	<div class="container">
		<button class="btn-icon d-md-none js-menu-toggle" data-direction="left" aria-label="<?php echo esc_html_e( 'Toggle the navigation', 'vendify' ); ?>">
			<?php svg( 'hamburger' ); ?>
		</button>

		<div class="custom-search custom-search--left mr-auto">
			<?php partial( 'searchform-header' ); ?>
		</div>

		<div class="nav-branding-split">
			<?php
			partial( 'nav/left' );
			$logo_tag = is_front_page() || is_home() ? 'h1' : 'p';
			partial( 'branding', [ 'tag' => $logo_tag ] );
			?>
		</div>

		<?php
		partial( 'nav/right' );
		partial( 'nav/right--icons' );
		?>

	</div>
</header>
