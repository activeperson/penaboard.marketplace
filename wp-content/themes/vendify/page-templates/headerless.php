<?php
/**
 * Template Name: Headerless Page
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
