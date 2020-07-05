<?php
/**
 * Blog Card Style Classic.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify; ?>

<div class="blog-card blog-card--card">
	<a href="<?php the_permalink(); ?>" rel="bookmark" class="blog-card__link">
		<span class="screen-reader-text"><?php the_title(); ?></span>
	</a>

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark" class="blog-card__thumbnail">
			<?php the_post_thumbnail( 'post-thumbnail', [ 'class' => 'card-img-top img-fluid' ] ); ?>
		</a>
	<?php endif; ?>

	<div class="blog-card__content">

		<div class="blog-card__author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 42 ); ?>
		</div>

		<?php
		// Translators: %s human readable time.
		$time_label = sprintf(
			__( '%s ago', 'vendify' ),
			human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) )
		);

		echo sprintf(
			'<time class="blog-card__date" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( 'c' ) ),
			$time_label
		);

		the_category( ', ' );

		the_title( '<h4 class="blog-card__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h4>' );

		the_excerpt(); ?>

		<a href="<?php the_permalink(); ?>" class="link link-cta text-xs has-icon">
			<?php
			esc_html_e( 'Read More', 'vendify' );

			svg(
				[
					'icon'    => 'long-arrow-right',
					'classes' => [
						'ico--xs',
						'ml-2',
					],
				]
			); ?>
		</a>

	</div>
</div>
