<?php
/**
 * Template Name: Cart
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

while ( have_posts() ) : the_post(); ?>

	<section class="hero hero--animatable hero--page has-gradient--top">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="hero__image-holder" aria-hidden="true">
				<div class="hero__image" style="background-image: url(<?php echo esc_url( wp_get_attachment_image_url( get_post_thumbnail_id(), 'cover' ) ); ?>)"></div>
			</div>
		<?php } ?>

		<div class="hero__content hero__content--center content--blog container">
			<h1 class="hero--blog-post__title page-title"><?php the_title(); ?></h1>
		</div>
	</section>

	<div class="main-content">
		<section></section>

		<section class="section">
			<article class="container">
				<?php the_content(); ?>
			</article>
		</section>
	</div>

<?php endwhile;

view( 'global/footer' );
