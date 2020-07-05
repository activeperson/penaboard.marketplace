<?php
/**
 * Shop collections.
 *
 * Only appears on the main shop page.
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

$featured = woocommerce_featured_products();

if ( empty( $featured ) ) {
	return;
} ?>

<section class="hero hero--find hero--slider">
	<div class="flickity--image <?php if ( count( $featured ) > 1 ) { echo esc_attr( 'hero__slider' ); } ?>">

		<?php
		foreach ( $featured as $product ) :
			$post_object                     = get_post( $product->get_id() );
			setup_postdata( $GLOBALS['post'] =& $post_object ); // @codingStandardsIgnoreLine ?>

		<div class="hero__slide has-gradient--top">
			<?php the_post_thumbnail( 'fullsize' ); ?>

			<div class="hero__content container">
				<h1 class="display-1 has-text-color has-light-color"><?php the_title(); ?></h1>

				<span class="d-flex has-text-color has-light-color">
					<?php the_excerpt(); ?>
				</span>

				<div class="hero__cta">
					<a href="<?php the_permalink(); ?>" class="btn btn-light"><?php _e( 'View product', 'vendify' ); ?></a>
				</div>
			</div>
		</div>

		<?php endforeach; ?>

	</div>
</section>
