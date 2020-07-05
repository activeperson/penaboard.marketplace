<?php
/**
 * Blog content.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 *
 * @var $blog_card_style
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

remove_filter( 'get_the_excerpt', 'wpautop' );
remove_filter( 'the_content', 'wpautop' );

if ( empty( $blog_card_style ) ) {
	$blog_card_style = get_theme_mod( 'blog-style', 'classic' );
} ?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'blog-grid__column js-reveal' ); ?>>

	<?php partial( 'blog/card-style-' . $blog_card_style ); ?>

</div>

