<?php
/**
 * Single product hero: secondary.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="shop-info__secondary">

	<?php
	foreach ( array_slice( $all_products, 0, 3 ) as $product ) :
		$post_object                     = get_post( $product->get_id() );
		setup_postdata( $GLOBALS['post'] =& $post_object ); // @codingStandardsIgnoreLine

		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );

		if ( ! $image[0] ) :
			continue;
		endif;
		?>

		<a href="<?php the_permalink(); ?>" class="product-thumbnail" style="background-image: url(<?php echo esc_url( $image ? $image[0] : null ); ?>)">
			<span class="screen-reader-text"><?php the_title(); ?></span>
		</a>

		<?php
		endforeach;
		wp_reset_postdata();
	?>

	<?php if ( count( $all_products ) - 3 > 0 ) : ?>

		<a href="<?php echo esc_url( get_term_link( $vendor_data['term_id'], WC_PRODUCT_VENDORS_TAXONOMY ) ); ?>" class="product-thumbnail">
			<span class="product-thumbnail__count">
				<?php echo count( $all_products ) - 3; ?>
			</span>
			<?php esc_html_e( 'more', 'vendify' ); ?>
		</a>

	<?php endif; ?>

</div>
