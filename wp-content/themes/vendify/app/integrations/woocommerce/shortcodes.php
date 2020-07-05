<?php
/**
 * WooCommerce shortcodes.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Integration
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function vendify_woocommerce_shortcode_before_products_loop( $attributes ) {
	if (
		'' !== $attributes['tag'] ||
		'' !== $attributes['category'] ||
		'' !== $attributes['ids'] ||
		'' !== $attributes['skus'] ||
		'' !== $attributes['terms'] ||
		'' !== $attributes['attribute']
	) {
		return;
	}

	$categories = woocommerce_get_product_subcategories( 0 );

	if ( empty( $categories ) ) {
		return;
	}
	?>

<nav class="navigation home-subnavigation">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active"><?php esc_html_e( 'All', 'vendify' ); ?></a>
		</li>

		<?php foreach ( $categories as $category ) : ?>
		<li class="nav-item">
			<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="nav-link"><?php echo esc_html( $category->name ); ?></a>
		</li>
		<?php endforeach; ?>
	</ul>
</nav>

	<?php
}
add_action( 'woocommerce_shortcode_before_products_loop', 'vendify_woocommerce_shortcode_before_products_loop' );
