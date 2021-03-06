<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<form role="search" method="get" class="woocommerce-product-search filter__search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'vendify' ); ?></label>

	<button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'vendify' ); ?>" aria-label="<?php echo esc_attr_x( 'Search', 'submit button', 'vendify' ); ?>" class="btn-icon">
		<?php svg( 'search' ); ?>
	</button>

	<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="form-control form-control--transparent search-field" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'vendify' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<input type="hidden" name="post_type" value="product" />
</form>
