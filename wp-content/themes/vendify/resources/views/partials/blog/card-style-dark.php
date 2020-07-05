<?php
/**
 * Blog Card Style Dark.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

global $wp_rewrite;

$card_style = '';

if ( has_post_thumbnail() ) {
	$card_style = 'style="background-image: url(\'' . get_the_post_thumbnail_url( get_the_ID(), 'medium' ) . '\')"';
} ?>

<div class="blog-card blog-card--dark">
	<a href="<?php the_permalink(); ?>" rel="bookmark" class="blog-card__link">
		<span class="screen-reader-text"><?php the_title(); ?></span>
	</a>

	<div class="blog-card__image_holder has-background-dim has-background-dim-50" <?php echo $card_style; // WPCS: XSS ok.?>></div>

	<div class="blog-card__content">

		<?php
		// Translators: %s human readable time.
		$time_label = sprintf(
			__( '%s ago', 'vendify' ),
			human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) )
		);

		echo sprintf(
			'<time class="blog-card__date has-text-color has-light-color" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( 'c' ) ),
			$time_label
		); ?>

			<div class="blog-post-categories">
				<?php
				$categories = apply_filters( 'the_category_list', get_the_category( get_the_ID() ), get_the_ID() );

				$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

				foreach ( $categories as $category ) { ?>
					<a href="<?php echo esc_url( get_category_link( $category->term_id ) ) ?>" class="badge badge-outline-light" rel="<?php echo esc_attr( $rel ); ?>" >
						<?php echo esc_html( $category->name ); ?>
					</a>
					<?php
					break; // stop at the first category
				} ?>
			</div>

		<?php the_title( '<h4 class="blog-card__title"><a class="has-text-color has-light-color" href="' . esc_url( get_permalink() ) . '">', '</a></h4>' ); ?>

		<div class="blog-post-excerpt has-text-color has-light-color">
			<?php the_excerpt(); ?>
		</div>

	</div>
</div>
