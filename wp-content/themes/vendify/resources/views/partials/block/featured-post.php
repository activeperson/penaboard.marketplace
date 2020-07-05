<?php
/**
 * Blog posts.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 *
 * @var $attributes array The attributes.
 *
 */

namespace Astoundify\Vendify;

use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$post = new WP_Query(
	[
		'p' => $attributes['postID'],
	]
);

if ( ! $post->have_posts() ) {
	return;
}

global $wp_rewrite;

ob_start(); ?>

<div class="wp-block-vendify-featured-post container-fluid align<?php echo ( isset( $attributes['align'] ) ? $attributes['align'] : '' ); ?>">

	<?php while ( $post->have_posts() ) : $post->the_post(); ?>

		<div class="row has-background has-light-background-color">
			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" class="featured-post-card__thumbnail col-md-7 d-flex" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID() ) ) ?>)"></a>
			<?php endif;?>
			<div class="featured-post-content col-md-<?php echo has_post_thumbnail() ? '4' : '10' ?> text-center mx-auto">
				
				<div class="featured-post-categories">
					<?php
					$categories = apply_filters( 'the_category_list', get_the_category( get_the_ID() ), get_the_ID() );

					$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';
				
					foreach ( $categories as $category ) { ?> 
						<a href="<?php echo esc_url( get_category_link( $category->term_id ) ) ?>" class="has-text-color has-secondary-color" rel="<?php echo esc_attr( $rel ); ?>" >
							<?php echo esc_html( $category->name ); ?>	
						</a>
					<?php } ?>
				</div>
				<?php

				the_title( '<h4 class="featured-post-card__title display-2"><a href="' . esc_url( get_permalink() ) . '">', '</a></h4>' );

				printf(
					'<div class="featured-post-excerpt">%s</div>',
					get_limited_excerpt()
				);

				if ( ! empty( $attributes['linkText'] ) ) { ?>
					<a href="<?php the_permalink(  get_the_ID() ); ?>" class="btn btn-primary">
						<?php echo esc_html( $attributes['linkText'] ); ?>
					</a>
				<?php } ?>
			</div>

		</div>

	<?php endwhile; ?>

</div>

<?php
wp_reset_query();
