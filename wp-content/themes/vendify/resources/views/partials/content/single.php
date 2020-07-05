<?php
/**
 * Blog single content.
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
} ?>

<div class="main-content">
	<div class="blog-post container">
		<?php
		the_content();

		partial( 'content/more' );

		partial( 'content/tags' ); ?>

	</div>

	<section class="wp-block-vendify-section alignfull has-border-color has-neutral-border-color has-background has-light-background-color">
		<div class="blog-bio">
			<header class="blog-bio__header">
				<div class="blog-bio__author">
					<span class="blog-bio__avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 54 ); ?></span>

					<div>
						<div class="blog-bio__author__name"><?php the_author_posts_link(); ?></div>

						<?php if ( '' !== get_the_author_meta( 'additional-role' ) ) : ?>
							<div class="blog-bio__author__details">
								<?php echo wp_kses_data( get_the_author_meta( 'additional-role' ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<?php
				/**
				 * Hook here to add social links or any type of author bio header
				 */
				do_action( 'vendify_blog-bio-header' );
				?>
			</header>

			<?php if ( get_the_author_meta( 'description' ) ) : ?>
				<div><?php the_author_meta( 'description' ); ?></div>
			<?php endif; ?>

			<?php
			/**
			 * Hook here to add any kind of author bio content
			 */
			do_action( 'vendify_blog-bio-content' );
			?>
		</div>
	</section>

	<?php
	if ( comments_open() || get_comments_number() ) { ?>
		<section class="wp-block-vendify-section alignfull">
			<?php comments_template( '/resources/views/partials/comments.php' ); ?>
		</section>
	<?php } ?>

</div>
