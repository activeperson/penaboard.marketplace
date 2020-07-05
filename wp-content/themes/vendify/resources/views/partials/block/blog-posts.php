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
 * @var $attributes array
 */

namespace Astoundify\Vendify;

use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$posts = new WP_Query(
	[
		'posts_per_page'      => $attributes['number'],
		'ignore_sticky_posts' => true,
	]
);

if ( ! $posts->have_posts() ) {
	return;
}

if ( $attributes['cardStyle'] === 'inherited' ) {
	$blog_card_style = get_theme_mod( 'blog-style', 'classic' );
} else {
	$blog_card_style = $attributes['cardStyle'];
}

$view_more_btn_class = 'link link-cta text-xs has-icon';

if ( $attributes['visitButtonStyle'] !== 'classic' ) {
	$view_more_btn_class = 'btn btn-default ' . $attributes['visitButtonStyle'];
}

ob_start(); ?>

<div class="wp-block-vendify-blog-posts">
	<div class="blog-grid js-reveal-container">

		<?php
		while ( $posts->have_posts() ) : $posts->the_post();
			partial( 'content', [ 'blog_card_style' => $blog_card_style ] );
		endwhile; ?>

	</div>

	<?php if ( isset( $attributes['linkText'] ) ) { ?>
		<div class="section__link-wrap">
			<a href="<?php echo esc_url( $attributes['link'] ); ?>" class="<?php echo esc_attr( $view_more_btn_class ); ?>">
				<?php echo esc_html( $attributes['linkText'] );

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
	<?php } ?>

</div>

<?php
wp_reset_query();
