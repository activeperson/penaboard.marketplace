<?php
/**
 * Product card: v5
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 *
 * @var $vendor_link;
 * @var $vendor_name;
 * @var $vendor_logo;
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;
?>

<div class="product-item product-item--scale">
	<a class="product-item__link" href="<?php the_permalink( $product->get_id() ); ?>"></a>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<header class="pi__header">
		<?php do_action( 'woocommerce_shop_loop_item_header', $product ); ?>
	</header>

	<div class="pi__img-holder">
		<?php echo $product->get_image(); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>

	<div class="pi__content">
		<div class="pi__content__body">
			<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>

			<h5 class="pi__name">
				<?php
				echo get_the_title( $product->get_id() );
				do_action( 'woocommerce_shop_loop_item_title' ); ?>
			</h5>

			<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>

			<?php if ( $product->get_price_html() ) : ?>
			<span class="price">
				<?php woocommerce_template_loop_price(); ?>
			</span>
			<?php endif; ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</div>
