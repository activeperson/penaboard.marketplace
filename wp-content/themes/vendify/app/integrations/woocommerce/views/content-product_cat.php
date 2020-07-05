<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
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
 * @version 2.6.1
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div <?php post_class( 'product js-reveal' ); ?>>
	<div class="product-item product-item--scale feature-card feature-card--large">
		<a class="product-item__link" href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ); ?>"></a>

		<div class="feature-card__image" style="background-image: url(<?php echo wp_get_attachment_image_url( get_term_meta( $category->term_id, 'thumbnail_id', true ), 'medium' ); ?>)"></div>

		<div class="feature-card__content">
			<div>
				<span class="feature-card__category"><?php echo esc_html( sprintf( __( '%d Items', 'vendify' ), $category->count ) ); ?></span>
				<h4><?php echo esc_html( $category->name ); ?>
			</div>

			<div class="btn-icon btn-featured">
				<?php svg( 'featured-arrow' ); ?>
			</div>
		</div>
	</div>
</div>
