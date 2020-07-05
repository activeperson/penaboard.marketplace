<?php
/**
 * Product card: v3
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

<div class="card product-item product-item--scale has-gradient--top">
	<a class="product-item__link" href="<?php the_permalink( $product->get_id() ); ?>"></a>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<header class="pi__header">
		<?php do_action( 'woocommerce_shop_loop_item_header', $product ); ?>

		<?php if ( $product->get_price_html() ) : ?>
		<span class="badge badge-primary badge--price-tag price">
			<?php woocommerce_template_loop_price(); ?>
		</span>
		<?php endif; ?>
	</header>

	<div class="pi__img-holder has-gradient--top">
		<?php echo $product->get_image(); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>

	<div class="pi__content pi__content--centered">
		<?php if ( $is_vendor ) { ?>
			<div class="mr-3 d-inline-block" style="width: 46px;">
				<img src="<?php echo esc_url( $vendor_logo ); ?>" alt="<?php esc_attr_e( 'Logo', 'vendify' ); ?>" width="46" />
			</div>
		<?php } ?>

		<div class="pi__content__body">
			<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>

			<h5 class="pi__name">
				<a href="<?php the_permalink( $product->get_id() ); ?>"><?php echo get_the_title( $product->get_id() ); ?></a>
				<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
			</h5>

			<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>

			<?php if ( $is_vendor ) { ?>
				<a href="<?php echo esc_url( $vendor_link ); ?>" class="link link-cta pi__author">
					<?php echo esc_html( $vendor_name ); ?>
				</a>
			<?php } ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</div>
