<?php
/**
 * Product card: v1
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

global $product; ?>

<div class="card product-item product-item--scale">
	<a class="product-item__link" href="<?php the_permalink( $product->get_id() ); ?>"></a>

	<header class="pi__header">
		<?php do_action( 'woocommerce_shop_loop_item_header', $product ); ?>
	</header>

	<div class="pi__img-holder">
		<?php echo $product->get_image(); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>

	<div class="pi__content">

		<div class="pi__content__title">
			<?php
			 do_action( 'woocommerce_before_shop_loop_item_title' ); ?>

			 <h5 class="pi__name">
				 <?php
				 echo get_the_title( $product->get_id() );
				 do_action( 'woocommerce_shop_loop_item_title' ); ?>
			 </h5>

			 <?php
			 do_action( 'woocommerce_after_shop_loop_item_title' );?>
		</div>

		<div class="pi__content__body">
			<?php if ( $is_vendor ) { ?>
				<a href="<?php echo esc_url( $vendor_link ); ?>" class="pi__author" title="<?php echo esc_attr( $vendor_name ); ?>">
					<span style="width: 20px;" class="pi__author-logo">
						<img src="<?php echo esc_url( $vendor_logo ); ?>" alt="<?php esc_attr_e( 'Logo.', 'vendify' ); ?>" width="20" />
					</span>
					<span class="link link-cta"><?php echo esc_html( $vendor_name ); ?></span>
				</a>
			<?php }

			if ( $product->get_price_html() ) { ?>
				<span class="badge badge-outline-secondary pi__price <?php if ( $is_vendor ) { ?>ml-auto<?php } else { ?>mr-auto<?php }?> mt-2">
					<?php woocommerce_template_loop_price(); ?>
				</span>
			<?php } ?>
		</div>
	</div>

</div>
