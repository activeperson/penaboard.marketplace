<?php
/**
 * Find a vendor search form.
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
?>

<div class="ml-auto col-lg-7 mr-auto">
	<form class="shop-listing-search-bar" action="#search-results" method="GET">
		<div class="filter__search">
			<button type="submit" class="btn btn--has-icon"><?php svg( 'search' ); ?></button>

			<label for="shop-listing-search">
				<span class="screen-reader-text"><?php esc_html_e( 'Search', 'vendify' ); ?></span>
			</label>

			<input class="form-control" id="shop-listing-search" type="search" name="vendor_keyword" placeholder="<?php esc_attr_e( 'Find a vendor...', 'vendify' ); ?>" value="<?php echo esc_attr( isset( $_GET['vendor_keyword'] ) ? $_GET['vendor_keyword'] : null ); ?>" />
		</div>
<?php /*
		<div class="filter__location ml-auto">
			<label for="shop-listing-location" aria-label="<?php esc_attr_e( 'Location', 'vendify' ); ?>">
				<?php svg( 'pin' ); ?>
			</label>

			<input class="form-control" id="shop-listing-location" type="text" name="vendor_location" placeholder="<?php esc_attr_e( 'Location', 'vendify' ); ?>" value="<?php echo esc_attr( isset( $_GET['vendor_location'] ) ? $_GET['vendor_location'] : null ); ?>" />
		</div>
*/?>
		<input type="hidden" name="vendor_search" value="1" />
	</form>
</div>
