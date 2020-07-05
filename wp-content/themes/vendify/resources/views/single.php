<?php
/**
 * Blog post.
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

	<section class="hero hero--blog-post">
		<div class="hero__content hero__content--center hero__content--blog container">
			<div class="hero--blog-post__tag"><?php the_category( ', ' ); ?></div>
			<h1 class="display-2"><?php the_title(); ?></h1>

			<div class="hero--blog-post__info">
				<a class="link link-cta" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( sprintf( __( 'By %s', 'vendify' ), get_the_author() ) ); ?></a>
				<div class="hero--blog-post__date"><?php echo esc_html( get_the_date() ); ?></div>
			</div>
		</div>
	</section>

	<?php
	partial( 'content/single' );

endwhile;

view( 'global/footer' );
