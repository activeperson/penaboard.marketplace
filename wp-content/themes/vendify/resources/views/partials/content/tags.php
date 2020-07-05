<?php
/**
 * Partial template which displays tags.
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

global $wp_rewrite;

$tags = apply_filters( 'the_tags_list', get_the_tags( get_the_ID() ), get_the_ID() );

$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

if ( ! empty( $tags ) ) { ?>
	<div class="post_tags has-border-color has-neutral-border-color">

		<span class="tags-links">
			<span class="has-text-color has-primary-color">
				<?php esc_html_e( 'Tags:', 'vendify' ); ?>
			</span>
			<span class="screen-reader-text"><?php esc_html_e( 'Tags:', 'vendify' ); ?></span>
				<?php
				foreach ( $tags as $tag ) { ?>
					<a href="<?php echo esc_url( get_category_link( $tag->term_id ) ) ?>" class="badge badge-outline-secondary" rel="<?php echo esc_attr( $rel ); ?>" >
						<?php echo esc_html( $tag->name ); ?>
					</a>
				<?php } ?>
		</span>
	</div>
<?php }
