<?php
/**
 * Hero Search
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 *
 * @var $attributes array
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$vendors = false;

if ( has_integration( 'woocommerce-product-vendors' ) ) {
	$url = woocommerce_product_vendors_search_url();

	if ( $url ) {
		$vendors = true;
	}
} ?>

<form class="hero-search" action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
	<div class="hero-search__bar">
		<?php if ( $vendors ) { ?>
		<div class="hero-search__switch">
			<label class="switch">
				<input type="checkbox" class="switch__input">
				<span class="switch__label"><?php echo esc_html_e( 'Products', 'vendify' ); ?></span>
				<span class="switch__indicator"></span>
				<span class="switch__label"><?php echo esc_html_e( 'Vendors', 'vendify' ); ?></span>
			</label>
		</div>
		<?php } ?>

		<div class="filter__search">
			<label for="s" aria-label="<?php esc_attr_e( 'Search', 'vendify' ); ?>">
				<?php svg( 'search' ); ?>
			</label>

			<input class="form-control form-control-lg js-hero-search-field" id="s" name="s" type="search" placeholder="<?php echo esc_attr( $attributes['keywordPlaceholder'] ); ?>" />
		</div>

<?php /** if ( $vendors ) : ?>
		<div class="filter__location" style="display: none;">
			<label for="vendor_location" aria-label="<?php echo esc_attr_e( 'Location', 'vendify' ); ?>">
				<?php svg( 'pin' ); ?>
			</label>

			<input class="form-control form-control-lg" id="vendor_location" name="vendor_location" type="text" placeholder="<?php echo esc_attr( $attributes['locationPlaceholder'] ); ?>" />
			<input type="hidden" name="vendor_search" id="vendor_search" value="1" />
		</div>
<?php endif;  */ ?>

		<button type="submit" class="btn btn-lg btn-secondary ml-md-3">
			<?php echo esc_attr( $attributes['searchValue'] ); ?>
		</button>
	</div>
</form>
