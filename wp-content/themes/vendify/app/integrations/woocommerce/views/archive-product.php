<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.6.0
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$shop_page_id = get_option( 'woocommerce_shop_page_id' );
$shop_page = get_post( $shop_page_id );

get_header( 'shop' );

if ( get_theme_mod( 'product-catalog-show-featured-vendors', true ) ) {
	wc_get_template( 'shop-featured.php' );
}

wc_get_template( 'shop-title.php' );

wc_get_template( 'shop-filters--mobile.php' ); ?>
	<main class="main-content main-content--single-section <?php echo esc_attr( content_has_hero_block( $shop_page->post_content ) ? 'page-content--has-hero-block' : null ); ?>">

	<?php do_action( 'woocommerce_before_main_content' ); ?>

		<div class="container">

			<?php

			if ( ! empty( $shop_page->post_content ) && get_theme_mod( 'product-catalog-show-page-content', true ) ) {
				echo apply_filters('the_content', $shop_page->post_content );
			}

			if (
				woocommerce_is_front_page()
				&& get_theme_mod( 'product-catalog-vendors', false )
				&& has_integration( 'woocommerce-product-vendors' )
			) { ?>
			<div class="row">
				<div class="col">
				<?php
				wc_get_template(
					'vendors/tabs.php',
					[
						'limit' => 8,
					]
				); ?>
				</div>
			</div>
			<?php } ?>

			<div class="row">

				<?php do_action( 'woocommerce_sidebar' ); ?>

				<section class="find-main col-xs-12 <?php echo is_active_sidebar( 'shop' ) ? esc_attr( ' col-md-8 col-xl-9' ) : null; ?>">
					<?php wc_get_template( 'products.php' ); ?>
				</section>

			</div>
		</div>

	<?php do_action( 'woocommerce_after_main_content' ); ?>

	</main>

<?php get_footer( 'shop' ); ?>
