<?php
/**
 * Page.
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

view( 'global/header' );

while ( have_posts() ) : the_post();
	$image = hero_image_src();

	if ( ! empty( get_the_title() ) && ! content_has_hero_block( get_the_content() ) ) { ?>
		<section class="hero hero--animatable hero--page has-gradient--top">

			<div class="hero__content hero__content--center content--blog container">
				<h1 class="hero--blog-post__title page-title has-text-color <?php if ( empty( $image ) ) { ?>has-primary-color<?php } else { ?>has-light-color<?php } ?>">
					<?php the_title(); ?>
				</h1>
			</div>

			<?php
			if ( ! empty( $image ) ) { ?>
				<div class="hero__image-holder has-background has-primary-background-color has-half-gradient--bottom" aria-hidden="true">
					<div class="hero__image" style="background-image: url(<?php echo esc_url( $image ); ?>)"></div>
				</div>
			<?php } ?>
		</section>
	<?php } ?>

	<div class="container page-content <?php echo esc_attr( content_has_hero_block( get_the_content() ) ? 'page-content--has-hero-block' : null ); ?>">
		<?php
		the_content();

		partial( 'content/more' ); ?>
	</div>

	<?php if ( comments_open() || get_comments_number() ) { ?>

		<section class="wp-block-vendify-section alignfull">
			<?php comments_template( '/resources/views/partials/comments.php' ); ?>
		</section>

	<?php }

endwhile;

view( 'global/footer' );
