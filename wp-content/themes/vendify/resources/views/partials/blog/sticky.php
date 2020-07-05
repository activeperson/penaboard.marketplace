<?php
/**
 * Blog sticky/featured carousel.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$sticky = new WP_Query(
	[
		'posts_per_page'      => 5,
		'ignore_sticky_posts' => true,
		'post__in'            => get_option( 'sticky_posts' ) ? get_option( 'sticky_posts' ) : [ 0 ],
	]
);

if ( ! $sticky->have_posts() ) {
	return;
} ?>

<section class="hero hero--blog hero--slider has-gradient--top">
	<div class="flickity--image <?php if ( $sticky->post_count > 1 ) { echo esc_attr( 'hero__slider' ); } ?>">

	<?php
	while ( $sticky->have_posts() ) : $sticky->the_post(); ?>
		<div class="hero__slide">
			<?php if ( has_post_thumbnail() ) : ?>
				<img class="hero__slide__img" src="<?php echo esc_url( wp_get_attachment_image_url( get_post_thumbnail_id(), 'cover' ) ); ?>" alt="<?php esc_html_e( 'Hero slide image.', 'vendify' ); ?>" />
			<?php endif; ?>

			<div class="hero__content hero__content--center hero__content--blog container">
				<h1 class="hero--blog-post__title display-2"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></h1>

				<div class="hero__cta hero__cta--home mt-md-5">
					<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-light"><?php esc_html_e( 'Read more', 'vendify' ); ?></a>
				</div>
			</div>
		</div>
	<?php endwhile; ?>

	</div>
</section>

<?php wp_reset_postdata(); ?>
