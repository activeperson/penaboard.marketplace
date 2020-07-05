<?php
/**
 * Branding
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$tag = 'p';

if ( isset( $args['tag'] ) ) {
	$tag = $args['tag'];
}

$tag = apply_filters( 'vendify_branding_tag', $tag ); ?>

<<?php echo esc_attr( $tag ); ?> class="site-title">
	<?php if ( has_custom_logo() ) : ?>
		<?php the_custom_logo(); ?>
	<?php else : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-logo">
			<?php bloginfo( 'name' ); ?>
		</a>
	<?php endif; ?>
</<?php echo esc_attr( $tag ); ?>>
