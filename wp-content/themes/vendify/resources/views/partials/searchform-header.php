<?php
/**
 * Searchform header (and mobile).
 *
 * Note: This does not include the wrapping <form> element.
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

if ( ! get_theme_mod( 'header-search', true ) ) {
	return;
}

if ( function_exists( 'wc_get_page_id' ) ) {
	$search_url = get_permalink( wc_get_page_id( 'shop' ) );
} else {
	$search_url = home_url();
} ?>

<form action="<?php echo esc_url( $search_url ); ?>" method="GET" class="custom-search <?php echo is_header_style( [ 2, 5 ] ) ? 'custom-search--static' : ''; ?>">

	<?php if ( function_exists( 'wc_get_page_id' ) ) { ?>
		<input type="hidden" name="post_type" value="product" />
	<?php } ?>

	<label class="custom-search__label">

		<input
			class="form-control form-control-sm form-control-search"
			type="text"
			name="s"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php esc_attr_e( 'Search...', 'vendify' ); ?>"
		/>

		<span class="btn-icon custom-search__close" tabindex="-1">
			<?php svg(
				[
					'icon'    => 'close',
					'classes' => [ 'ico--xs', 'ml-2' ],
				]
			); ?>
		</span>

	</label>

	<button type="submit" class="btn-icon custom-search__icon">
		<?php svg( 'search' ); ?>
	</button>
</form>
